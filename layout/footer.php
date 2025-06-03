<!-- /layout/footer.php -->
  </div> <!-- closes .flex-grow -->

  <footer class="bg-white text-gray-600 dark:bg-gray-900 dark:text-gray-300 mt-auto">
    <div class="flex flex-col lg:flex-row justify-between items-center px-6 py-4 border-t border-gray-300 dark:border-gray-700">
      <div class="text-sm">
        <p>© <span id="year"></span> CookBook. All rights reserved.</p>
      </div>
      <div class="flex space-x-4 text-xl mt-2 lg:mt-0">
        <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="hover:text-blue-400 dark:hover:text-blue-300"><i class="fab fa-twitter"></i></a>
        <a href="#" class="hover:text-pink-500 dark:hover:text-pink-400"><i class="fab fa-instagram"></i></a>
        <a href="#" class="hover:text-gray-800 dark:hover:text-white"><i class="fab fa-github"></i></a>
      </div>
    </div>

    <div class="text-center py-4 text-sm">
      <a href="/cookbook/guest/home.php" class="hover:underline mx-2">Home</a>
      <a href="/cookbook/user/index.php" class="hover:underline mx-2">My Recipes</a>
      <a href="/cookbook/guest/index.php" class="hover:underline mx-2">Browse</a>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="/cookbook/admin/showAllUsers.php" class="hover:underline mx-2">Admin Panel</a>
      <?php endif; ?>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="/cookbook/assets/js/darkmode.js"></script>
  <script>document.getElementById("year").textContent = new Date().getFullYear();</script>
</body>
</html>
