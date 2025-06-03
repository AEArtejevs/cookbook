<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/RecipesController.php';

$categoryId = $_GET['id'];


$data = RecipeController::recipesByCategory($pdo, $categoryId, $_SESSION['user_id'] ?? null);
$recipes = $data['recipes'];
$category = $data['category'];
$favoriteRecipeIds = $data['favoriteRecipeIds'];

include '../layout/head.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="flex flex-col rounded my-3">
    <h1 class="font-bold border-b border-gray-600 flex flex-row justify-between items-center py-2 uppercase">
      Recipes in Category: <?= htmlspecialchars($category['name']) ?>
    </h1>
  </div>

  <?php if (count($recipes) > 0): ?>
    <div class="bg-white rounded dark:bg-gray-800 grid gap-2 justify-center lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 p-2">
      <?php foreach ($recipes as $recipe): ?>
        <div class="border border-gray-200 bg-white rounded shadow dark:bg-gray-900 dark:border-gray-700 relative max-w-sm">
          <form method="POST" class="absolute top-2 right-2">
            <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['id']) ?>">
            <button type="submit"
              class="p-1 rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
              aria-label="Bookmark Recipe" title="Bookmark Recipe">
              <?php if (in_array($recipe['id'], $favoriteRecipeIds)): ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                  <path d="M5 5v14l7-7 7 7V5z" />
                </svg>
              <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 5v14l7-7 7 7V5z" />
                </svg>
              <?php endif; ?>
            </button>
          </form>

          <div class="h-48 overflow-hidden rounded-t">
            <img src="/cookbook/images/<?= htmlspecialchars($recipe['image']) ?>" alt="Recipe Image"
              class="w-full h-full object-cover" />
          </div>

          <div class="p-5 flex flex-col">
            <h5 class="mb-2 md:text-xl font-bold tracking-tight text-gray-900 break-all dark:text-white">
              <?= htmlspecialchars($recipe['name']) ?>
            </h5>
            <p class="mb-3 font-normal text-xs text-gray-700 break-all dark:text-gray-400 overflow-hidden flex-grow">
              <?= htmlspecialchars($recipe['description']) ?>
            </p>
            <a href="/cookbook/guest/show.php?id=<?= $recipe['id'] ?>"
              class="mt-auto text-center inline-block px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              More info
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <h1 class="bg-gray-200 p-2 font-semibold rounded text-center dark:bg-gray-800">
      No recipes found in this category.
    </h1>
  <?php endif; ?>
</div>

<?php include '../layout/footer.php'; ?>
