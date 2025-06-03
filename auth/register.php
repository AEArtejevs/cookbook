
<?php
session_start();
require_once '../includes/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    $statement = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $statement->execute([$email]);
    if ($statement->fetch()) {
        $errors[] = "Email already registered.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $statement->execute([$name, $email, $hashedPassword]);
        $_SESSION['success'] = "Account created successfully!";
        header('Location: login.php');
        exit();
    }
}

?>
<?php include_once '../layout/head.php'; ?>

<div class="flex items-center justify-center min-h-screen">
  <div class="flex flex-col md:flex-row bg-white dark:bg-gray-800 p-10 m-4 rounded-xl shadow-md w-full max-w-4xl">

    <!-- Logo -->
<div class="flex items-center justify-center w-full md:w-1/2 border-b md:border-b-0 md:border-r border-gray-300 dark:border-gray-700 md:pr-8 pb-8 md:pb-0">
  <svg class="h-50 w-auto" viewBox="0 0 500 150" xmlns="http://www.w3.org/2000/svg" fill="none" role="img" aria-label="CookBook Logo">
    <g>
      <path d="M45 10c-14 0-25 11-25 25v25h10v20c0 5 3 8 8 8h34c5 0 8-3 8-8v-20h10V35c0-14-11-25-25-25z" fill="#2563eb" />
      <text x="110" y="90" fill="#2563eb" font-family="Arial, sans-serif" font-size="48" font-weight="bold">CookBook</text>
    </g>
  </svg>
</div>

    <!-- Register Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center">
      <form id="registerForm" method="POST" action="register.php" class="space-y-6 py-4 px-0 md:pl-10">
        <h2 class="text-2xl font-semibold mb-6 text-center md:text-left text-gray-800 dark:text-white">
          Create an Account
        </h2>

        <div>
          <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Name</label>
          <input id="name" type="text" name="name" autofocus
                 class="w-full mt-2 bg-white text-gray-900 border border-gray-300
                        dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                        focus:border-indigo-500 focus:ring-indigo-500
                        dark:focus:border-indigo-600 dark:focus:ring-indigo-600
                        rounded-md shadow-sm px-3 py-2">
        </div>

        <div>
          <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
          <input id="email" type="email" name="email"
                 class="w-full mt-2 bg-white text-gray-900 border border-gray-300
                        dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                        focus:border-indigo-500 focus:ring-indigo-500
                        dark:focus:border-indigo-600 dark:focus:ring-indigo-600
                        rounded-md shadow-sm px-3 py-2">
        </div>

        <div>
          <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password</label>
          <input id="password" type="password" name="password"
                 class="w-full mt-2 bg-white text-gray-900 border border-gray-300
                        dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                        focus:border-indigo-500 focus:ring-indigo-500
                        dark:focus:border-indigo-600 dark:focus:ring-indigo-600
                        rounded-md shadow-sm px-3 py-2">
        </div>

        <div>
          <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Confirm Password</label>
          <input id="password_confirmation" type="password" name="password_confirmation"
                 class="w-full mt-2 bg-white text-gray-900 border border-gray-300
                        dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700
                        focus:border-indigo-500 focus:ring-indigo-500
                        dark:focus:border-indigo-600 dark:focus:ring-indigo-600
                        rounded-md shadow-sm px-3 py-2">
        </div>

        <div>
          <button type="submit"
                  class="w-full justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700
                         text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2
                         focus:ring-offset-2 focus:ring-indigo-500">
            Register
          </button>
        </div>

        <p id="error-name" class="mt-1 text-sm text-red-600 dark:text-red-400"></p>
        <p id="error-email" class="mt-1 text-sm text-red-600 dark:text-red-400"></p>
        <p id="error-password" class="mt-1 text-sm text-red-600 dark:text-red-400"></p>
        <p id="error-password_confirmation" class="mt-1 text-sm text-red-600 dark:text-red-400"></p>
      </form>

      <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        Already have an account?
        <a href="login.php"
           class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
          Log in
        </a>
      </p>
    </div>
  </div>
</div>

<script src="../assets/js/registerValidation.js"></script>

<?php include_once '../layout/footer.php'; ?>
