<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/RecipesController.php';
require_once '../controllers/FavoriteController.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo "Invalid recipe ID.";
    exit;
}

$recipeId = (int)$_GET['id'];
$recipe = RecipeController::show($recipeId);

if (!$recipe) {
    http_response_code(404);
    echo "Recipe not found.";
    exit;
}

$favoriteRecipeIds = [];
if (isset($_SESSION['user_id'])) {
    $favoriteRecipeIds = FavoriteController::getUserFavorites($pdo, $_SESSION['user_id']);
}
?>

<?php include '../layout/head.php'; ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <header class="mb-8">
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">
      <?= htmlspecialchars($recipe['name']) ?>
    </h1>

    <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
      <span>
        <a href="/cookbook/categories/show.php?id=<?= htmlspecialchars($recipe['category_id']) ?>" class="hover:underline">
          <?= htmlspecialchars($recipe['category_name'] ?? 'Unknown Category') ?>
        </a>
      </span>
      <span>By: <?= htmlspecialchars($recipe['user_name'] ?? 'Unknown') ?></span>
      <span class="ml-auto">
        <?php if (in_array($recipeId, $favoriteRecipeIds)): ?>
          <svg class="inline w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M5 5v14l7-7 7 7V5z" />
          </svg>
        <?php else: ?>
          <svg class="inline w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 5v14l7-7 7 7V5z" />
          </svg>
        <?php endif; ?>
      </span>
      <span><?= date("F j, Y", strtotime($recipe['created_at'])) ?></span>
    </div>
  </header>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
    <section class="md:col-span-2">
      <img src="/cookbook/images/<?= htmlspecialchars($recipe['image']) ?>"
           alt="<?= htmlspecialchars($recipe['name']) ?>"
           class="rounded-lg w-full h-96 object-cover shadow-lg mb-6">

      <div class="prose max-w-none dark:prose-invert text-gray-800 dark:text-gray-200">
        <h2>Description</h2>
        <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
      </div>
    </section>

    <aside class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
      <h3 class="text-xl font-semibold mb-4">Ingredients</h3>
      <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
        <?php foreach ($recipe['ingredients'] as $ingredient): ?>
          <li>
            <?= htmlspecialchars($ingredient['name']) ?> -
            <?= htmlspecialchars($ingredient['quantity']) ?>
            <?= htmlspecialchars($ingredient['unit']) ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="mt-6 text-gray-700 dark:text-gray-300">
        <strong>Cooking time:</strong> <?= (int)$recipe['duration'] ?> minutes
      </div>
    </aside>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
