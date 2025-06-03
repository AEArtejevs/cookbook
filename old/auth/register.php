<?php
session_start();
require_once '../includes/db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $password_confirmation = $_POST['password_confirmation'];

  // Validate

  if (empty($name)) {
    $errors[] = "Full Name is required.";
  }
  if (empty($email)) {
    $errors[] = "Email is required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }
  if (empty($password)) {
    $errors[] = "Password is required.";
  }
  if (empty($password_confirmation)) {
    $errors[] = "Password confirmation is required.";
  }
  if ($password !== $password_confirmation) {
    $errors[] = "Passwords do not match.";
  }
  if (empty($errors)) {
    // Check if email exists
    $statement = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $statement->execute([$email]);
    if ($statement->fetch()) {
      $errors[] = "Email already registered.";
    } else {
      // Hash password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Insert user into database
      $statement = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
      $statement->execute([$name, $email, $hashedPassword]);

      // Redirect or success message
      $_SESSION['success'] = "Account created successfully! Please log in.";
      header('Location: login.php');
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">


  <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full sm:w-96 md:w-1/2 lg:w-1/3 space-y-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">

      <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 pb-3">Create an Account</h1>
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

      <form action="register.php" method="POST" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
          <input
            type="text"
            value="<?= isset($name) ? htmlspecialchars($name) : '' ?>"
            name="name"
            id="name"

            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Full Name" />
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email address</label>
          <input
            type="email"
            value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"
            name="email"
            id="email"
            
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Email Address" />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
          <input
            type="password"
            name="password"
            id="password"

            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Password" />
        </div>
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"

            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Confirm Password" />
        </div>
        <button type="submit" class="w-full focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Submit</button>

      </form>
      <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        Already have an account?
        <a href="./login.php" class="text-blue-600 hover:underline dark:text-blue-400">Log in</a>
      </p>
    </div>
  </main>

  <?php include '../layout/footer.php'; ?>
</body>

</html>