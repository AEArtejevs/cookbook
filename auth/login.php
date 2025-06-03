<?php
ob_start();
session_start();
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];
    header('Location: http://localhost/cookbook/guest/home.php');
    exit;
  }

  header('Location: http://localhost/cookbook/auth/login.php');
  exit;
}
?>
<html>
<?php include_once __DIR__ . '/../layout/head.php'; ?>


<div class="flex items-center justify-center min-h-screen">
  <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 p-10 m-4 rounded-xl shadow-md w-full max-w-4xl">
<div class="flex items-center justify-center w-full md:w-1/2 border-b md:border-b-0 md:border-r border-gray-300 dark:border-gray-700 md:pr-8 pb-8 md:pb-0">
  <svg class="h-50 w-auto" viewBox="0 0 500 150" xmlns="http://www.w3.org/2000/svg" fill="none" role="img" aria-label="CookBook Logo">
    <g>
      <path d="M45 10c-14 0-25 11-25 25v25h10v20c0 5 3 8 8 8h34c5 0 8-3 8-8v-20h10V35c0-14-11-25-25-25z" fill="#2563eb" />
      <text x="110" y="90" fill="#2563eb" font-family="Arial, sans-serif" font-size="48" font-weight="bold">CookBook</text>
    </g>
  </svg>
</div>

    <div class="w-full md:w-1/2 flex flex-col justify-center">
      <form id="loginForm" method="POST" action="login.php" class="space-y-6 py-4 px-0 md:pl-10">
        <h2 class="text-2xl font-semibold mb-6 text-center md:text-left text-gray-800 dark:text-white">
          Login to Your Account
        </h2>

        <div>
          <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
            Email
          </label>
          <input id="email" type="email" name="email" autofocus
            class="mt-2 w-full bg-white text-gray-900 border border-gray-300
                   dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                   focus:border-indigo-500 focus:ring-indigo-500
                   dark:focus:border-indigo-600 dark:focus:ring-indigo-600
                   rounded-md shadow-sm px-3 py-2">
        </div>

        <div>
          <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
            Password
          </label>
          <input id="password" type="password" name="password"
            class="mt-2 w-full bg-white text-gray-900 border border-gray-300
                   dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                   focus:border-indigo-500 focus:ring-indigo-500
                   dark:focus:border-indigo-600 dark:focus:ring-indigo-600
                   rounded-md shadow-sm px-3 py-2">
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
            <input type="checkbox" name="remember"
              class="rounded border-gray-500 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="ml-2">Remember me</span>
          </label>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
            <a href="register.php"
              class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
              Register
            </a>
          </p>
        </div>

        <div>
          <button type="submit"
            class="w-full justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700
                   text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2
                   focus:ring-offset-2 focus:ring-indigo-500">
            Log in
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>