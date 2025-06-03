<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/FavoriteController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /cookbook/auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$favorites = FavoriteController::show($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $recipe_id = $_POST['recipe_id'];

    if ($user_id && $recipe_id) {
        FavoriteController::delete($user_id, $recipe_id);
    }

    header("Location: /cookbook/user/favorites.php");
    exit;
}
?>
<?php include '../layout/head.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="flex justify-between items-center mt-6 mb-4 p-4 bg-gray-200 dark:bg-gray-800 rounded-lg shadow">
    <h1 class="text-xl font-bold text-gray-900 dark:text-white">My Favorite Recipes</h1>
  </div>

  <?php if (count($favorites) > 0): ?>
    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
      <?php foreach ($favorites as $recipe): ?>
        <div class="border border-gray-200 bg-white rounded shadow dark:bg-gray-900 dark:border-gray-700 relative">
          <div class="h-48 overflow-hidden rounded-t">
            <img src="/cookbook/images/<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['name']) ?>" class="w-full h-full object-cover" />
          </div>
          <div class="p-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white break-words">
              <?= htmlspecialchars($recipe['name']) ?>
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-3">
              <?= htmlspecialchars($recipe['description']) ?>
            </p>
          </div>
          <form method="POST" action="favorites.php?action=delete" class="absolute top-2 right-2"
                onsubmit="return confirm('Remove this recipe from favorites?');">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded p-1 focus:outline-none focus:ring-2 focus:ring-red-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="mt-6 text-center text-gray-700 dark:text-gray-300 font-semibold">
      You have no favorite recipes yet.
    </div>
  <?php endif; ?>
</div>

<?php include '../layout/footer.php'; ?>
