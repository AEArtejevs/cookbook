<?php
session_start();
require_once '../controllers/UsersController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_recipe_id'])) {
    UsersController::deleteRecipe((int)$_POST['delete_recipe_id']);
    header("Location: admin_users_recipes.php?deleted=1");
    exit;
}

$users = UsersController::getUsersWithRecipes();
?>

<?php include '../layout/head.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Users and Their Recipes</h1>

  <?php if (isset($_GET['deleted'])): ?>
    <div class="mb-4 text-green-600 font-semibold">Recipe deleted successfully.</div>
  <?php endif; ?>

  <div class="overflow-x-auto rounded-lg shadow-md bg-white dark:bg-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-200 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Recipes</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php if (count($users)): ?>
          <?php foreach ($users as $user): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 align-top">
              <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($user['name']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($user['email']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($user['role']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 max-w-xs">
                <?php if (!empty($user['recipes'])): ?>
                  <ul class="list-disc list-inside space-y-1 max-h-48 overflow-auto">
                    <?php foreach ($user['recipes'] as $recipe): ?>
                      <li class="flex justify-between items-center">
                        <a href="/cookbook/recipes/show.php?id=<?= $recipe['id'] ?>" class="text-indigo-600 hover:underline">
                          <?= htmlspecialchars($recipe['name']) ?>
                        </a>
                        <form method="POST" class="ml-4" onsubmit="return confirm('Delete this recipe?');">
                          <input type="hidden" name="delete_recipe_id" value="<?= $recipe['id'] ?>">
                          <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
                        </form>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <span class="text-gray-500 dark:text-gray-400">No recipes</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No users found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
