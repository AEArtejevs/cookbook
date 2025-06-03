<?php
// include '../db_connect.php'; // or wherever your db connection file is
require_once '../includes/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fullName = $fname . " " . $lname;

            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$fullName, $email, $message]);

            if ($stmt->execute()) {
                header("Location: thankyou.php");
                exit();
            } else {
                $error_message = "Database error. Please try again.";
            }
        } else {
            $error_message = "Invalid email format.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<main class="flex-1 flex items-center justify-center px-4 py-12">
<section class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
      <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">Contact Us</h1>

      <form id="contact-form" class="space-y-6" method="POST" action="contact.php">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="fname" class="block mb-1 text-gray-700 dark:text-gray-300">First Name</label>
            <input type="text" id="fname" name="fname" placeholder="John"
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label for="lname" class="block mb-1 text-gray-700 dark:text-gray-300">Last Name</label>
            <input type="text" id="lname" name="lname" placeholder="Doe"
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
        </div>

        <div>
          <label for="email" class="block mb-1 text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" id="email" name="email" placeholder="you@example.com"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="message" class="block mb-1 text-gray-700 dark:text-gray-300">Message</label>
          <textarea id="message" name="message" rows="5" placeholder="Write your message here..."
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div class="text-center">
          <button type="submit"
            class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition duration-300">
            Submit
          </button>
        </div>
      </form>
      <div id="alert" class="hidden text-sm mt-3"></div>
    </section>
  </main>

  <?php include '../layout/footer.php'; ?>


  <script src="js/script.js"></script>

<script>
document.getElementById("contact-form").addEventListener("submit", function(event) {
  let fname = document.getElementById("fname").value.trim();
  let lname = document.getElementById("lname").value.trim();
  let email = document.getElementById("email").value.trim();
  let message = document.getElementById("message").value.trim();

  let emailRegex = /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/;
  let errors = [];

  if (!fname) errors.push("First name is required.");
  if (!lname) errors.push("Last name is required.");
  if (!email) errors.push("Email is required.");
  else if (!emailRegex.test(email)) errors.push("Invalid email format.");
  if (message.length < 10) errors.push("Message must be at least 10 characters long.");

  let alertBox = document.getElementById("alert");

  if (errors.length > 0) {
    event.preventDefault(); // stop submitting
    alertBox.className = "bg-red-100 text-red-700 border border-red-400 rounded px-4 py-3 my-4";
    alertBox.innerHTML = errors.join("<br>");
    alertBox.classList.remove("hidden");
  } else {
    // Allow real submission to PHP
  }
});
</script>



</body>

</html>
