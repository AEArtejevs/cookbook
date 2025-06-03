<?php ob_start(); ?>

<?php
session_start();
require_once '../includes/db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validation
    // if no validation errors
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = "Email not found.";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Incorrect password.";
        } 
         else {
            // echo "Login successful for {$user['name']}<br>";

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['login_success'] = "Welcome back, {$user['name']}!";

            setcookie('name', $user['name'], time() + (86400 * 30), "/"); // 30 days
            setcookie('last_visit', date('Y-m-d H:i:s'), time() + (86400 * 30), "/"); // 30 days
            header('Location: /Practical-Assignment-3/index.php');
            exit;
        }
    }
}





?>
<html>
<?php include '../layout/head.php'; ?>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">

        <?php if (isset($_SESSION['success'])): ?>
            <div class="flex justify-center items-center h-screen">
                <div class="fixed left-1/2 transform -translate-x-1/2 z-50" style="top: 80px;">
                    <div class="message bg-green-100 text-xl text-green-800 p-4 rounded-lg text-center w-auto px-8 shadow-lg">
                        <?= htmlspecialchars($_SESSION['success']) ?>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['success']); ?>


        <?php endif; ?>
        <div class="w-full sm:w-96 md:w-1/2 lg:w-1/3 space-y-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">

            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 pb-3">Sign in to Your Account</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Enter your credentials below
                </p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-900 text-red-800 dark:text-gray-800 border border-red-400 rounded-lg p-4 mb-6 text-center">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="login.php" method="POST" class="mt-6 space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
                    <input
                        id="email"
                        name="email"
                        value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"
                        type="email"
                        required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="you@example.com" />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="••••••••" />
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                        <span class="ml-2 text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                    <a href="/forgot-password.php" class="text-blue-600 hover:underline dark:text-blue-400">
                        Forgot your password?
                    </a>
                </div>

                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Don't have an account?
                <a href="./register.php" class="text-blue-600 hover:underline dark:text-blue-400">Register here</a>
            </p>
        </div>
    </main>



    <?php include '../layout/footer.php'; ?>
    <?php ob_end_flush(); ?>

</body>

</html>