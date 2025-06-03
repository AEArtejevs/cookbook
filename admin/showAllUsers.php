<?php
session_start();
require_once '../controllers/UsersController.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $userId = (int) $_POST['delete_user_id'];
    UsersController::delete($userId);
    header("Location: admin_users.php?deleted=1");
    exit;
}

$users = UsersController::getAllUsers();
?>

<?php include '../layout/head.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Users List</h1>

  <?php if (isset($_GET['deleted'])): ?>
    <div class="mb-4 text-green-600 font-semibold">User deleted successfully.</div>
  <?php endif; ?>

  <div class="overflow-x-auto rounded-lg shadow-md">
    <table class="min-w-full bg-white dark:bg-gray-800">
      <thead class="bg-gray-200 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php if (count($users) > 0): ?>
          <?php foreach ($users as $user): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900">
              <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($user['id']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($user['name']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($user['email']) ?></td>
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($user['role']) ?></td>
              <td class="px-6 py-4 text-center text-sm font-medium">
                <form method="POST" onsubmit="return confirm('Delete this user?');">
                  <input type="hidden" name="delete_user_id" value="<?= $user['id'] ?>">
                  <button type="submit" class="inline-flex items-center px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
              No users found.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
