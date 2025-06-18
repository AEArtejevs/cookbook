<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/UsersController.php';

$user = UsersController::getUserData($_SESSION['user_id']);

function calculateAge($birthdate)
{
    if (!$birthdate) return null;
    $dob = new DateTime($birthdate);
    $today = new DateTime('today');
    return $dob->diff($today)->y;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $birthdate = $_POST['birthdate'] ?? null;

    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../images/';
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $filename;
        }
    }

    UsersController::updateUserProfile($_SESSION['user_id'], $name, $gender, $birthdate, $imagePath);
    $user = UsersController::getUserData($_SESSION['user_id']);
}
?>

<?php include '../layout/head.php'; ?>

<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6 my-10">

    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">My Profile</h2>

    <div class="flex flex-col md:flex-row md:items-center md:space-x-6 space-y-4 md:space-y-0 mb-8">
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-300 dark:border-gray-600 mx-auto md:mx-0">
            <?php if (empty($user['image'])): ?>
                <div class="relative w-full h-full overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            <?php else: ?>
                <img src="/cookbook/images/<?= htmlspecialchars($user['image']) ?>"
                    alt="Profile"
                    class="w-full h-full object-cover">
            <?php endif; ?>
        </div>

        <div class="text-center md:text-left">
            <p class="text-lg font-semibold text-gray-800 dark:text-white">
                <?= htmlspecialchars($user['name'] ?? 'Name not set') ?>
            </p>
            <p class="text-gray-600 dark:text-gray-400"><?= htmlspecialchars($user['email']) ?></p>
            <?php if (!empty($user['gender'])): ?>
                <p class="text-sm text-gray-500 dark:text-gray-400 capitalize"><?= htmlspecialchars($user['gender']) ?></p>
            <?php endif; ?>
            <?php if (!empty($user['birthdate'])): ?>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Age: <?= calculateAge($user['birthdate']) ?> years
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Form -->
    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
            <input type="text" id="name" name="name"
                value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
        </div>

        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
            <select id="gender" name="gender"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                <option value="" disabled <?= empty($user['gender']) ? 'selected' : '' ?>>Select gender</option>
                <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div>
            <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate"
                value="<?= htmlspecialchars($user['birthdate'] ?? '') ?>"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Profile Image</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 
             file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <small class="text-gray-500 dark:text-gray-400">Leave blank to keep existing image.</small>
        </div>

        <div>
            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md">
                Save Changes
            </button>
        </div>
    </form>
</div>

<?php include '../layout/footer.php'; ?>
