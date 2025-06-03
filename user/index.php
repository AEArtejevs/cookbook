<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/RecipesController.php';

$user_id = $_SESSION['user_id'] ?? null;
$recipes = [];

if ($user_id) {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'delete') {
    $user_id = $_SESSION['user_id'] ?? null;
    $recipe_id = $_POST['recipe_id'] ?? null;

    if ($user_id && $recipe_id) {
        RecipeController::delete($recipe_id, $user_id);
    }

    header("Location: /cookbook/user/index.php");
    exit;
}
?>

<?php include '../layout/head.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mt-6 mb-4 p-4 bg-gray-200 dark:bg-gray-800 rounded-lg shadow">
        <h1 class="text-xl font-bold">My Recipes</h1>
        <a href="/cookbook/user/create.php" class="text-blue-600 hover:text-blue-800" title="Create Recipe">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>

    <?php if (count($recipes) > 0): ?>
        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            <?php foreach ($recipes as $recipe): ?>
                <div class="border border-gray-200 bg-white rounded shadow dark:bg-gray-900 dark:border-gray-700 relative">

                    <form method="POST" action="index.php?action=delete" class="absolute top-2 right-2" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                        <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white rounded p-1 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7L5 7M10 11v6m4-6v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12" />
                            </svg>
                        </button>
                    </form>

                    <a href="/cookbook/user/edit.php?id=<?= $recipe['id'] ?>"
                        class="absolute top-2 right-10 bg-green-600 hover:bg-green-700 text-white rounded p-1 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536M9 11l6 6M4 20h7.586a1 1 0 0 0 .707-.293l9-9a1 1 0 0 0-1.414-1.414l-9 9A1 1 0 0 0 8.414 19H4v-3z" />
                        </svg>
                    </a>

                    <div class="h-48 overflow-hidden rounded-t">
                        <img src="/cookbook/images/<?= htmlspecialchars($recipe['image']) ?>" alt="Recipe Image"
                        class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white break-words">
                            <?= htmlspecialchars($recipe['name']) ?>
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-3">
                            <?= htmlspecialchars($recipe['description']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="mt-6 text-center text-gray-700 dark:text-gray-300 font-semibold">
            No recipes found.
        </div>
    <?php endif; ?>
</div>

<?php include '../layout/footer.php'; ?>
