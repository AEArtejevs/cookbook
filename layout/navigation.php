<!-- drawer init and show -->
<?php require_once '../controllers/UsersController.php'; ?>
<nav class="flex items-center justify-between p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
  <!-- Sidebar trigger -->
  <button type="button" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation"
    aria-controls="drawer-navigation"
    class="text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white focus:outline-none">
    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

  <div class="px-2 flex-grow max-w-xl">
    <label for="drawer-search" class="sr-only">Search</label>
    <div class="relative">

      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
          stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <circle cx="11" cy="11" r="7" stroke-linecap="round" stroke-linejoin="round" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </div>

      <form method="GET" action="/cookbook/guest/index.php">
        <input id="drawer-search" type="search" name="search"
          value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
          placeholder="Search recipes by name..."
          class="block w-full pl-10 pr-3 py-2 text-sm rounded-md shadow-sm
           bg-white text-gray-900 placeholder-gray-500 border border-gray-300
           focus:ring-indigo-500 focus:border-indigo-500
           dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-400 dark:border-gray-700
           dark:focus:ring-indigo-600 dark:focus:border-indigo-600" />
      </form>


    </div>
  </div>



  <button id="theme-toggle" type="button"
    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg">
      <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
    </svg>
    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 48 48"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M28.96 5.66c-3.24-.88-6.68-.88-9.92 0L24-.04 28.96 5.66zM14.539 7.524c-2.913 1.669-5.346 4.101-7.014 7.014L7.001 7.001 14.539 7.524zM5.66 19.04c-.88 3.24-.88 6.68 0 9.92L-.04 24 5.66 19.04zM7.524 33.461c1.669 2.913 4.101 5.346 7.014 7.014l-7.538.523L7.524 33.461zM19.04 42.34c3.24.88 6.68.88 9.92 0L24 48.04 19.04 42.34zM33.461 40.476c2.913-1.669 5.346-4.101 7.014-7.014l.523 7.538L33.461 40.476zM42.34 28.96c.88-3.24.88-6.68 0-9.92l5.7 4.96L42.34 28.96zM40.476 14.539c-1.669-2.913-4.101-5.346-7.014-7.014l7.538-.523L40.476 14.539zM24 8A16 16 0 1024 40 16 16 0 1024 8z">
      </path>
    </svg>
  </button>
</nav>

<div id="drawer-navigation"
  class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
  tabindex="-1" aria-labelledby="drawer-navigation-label">
  <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu
  </h5>
  <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd"
        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
        clip-rule="evenodd"></path>
    </svg>
    <span class="sr-only">Close menu</span>
  </button>
  <div class="py-4 overflow-y-auto">
    <ul class="space-y-2 font-medium">
      <li>
        <a href="../guest/home.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <svg aria-hidden="true"
            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M10.707 1.707a1 1 0 00-1.414 0L2 9v9a1 1 0 001 1h5a1 1 0 001-1v-6h2v6a1 1 0 001 1h5a1 1 0 001-1v-9l-7.293-7.293z" />
          </svg>
          <span class="ms-3">Home</span>
        </a>
      </li>
      <li>
        <a href="../guest/index.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <svg aria-hidden="true"
            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
          </svg>
          <span class="ms-3">Recipes</span>
        </a>
      </li>
      <li>
        <button type="button"
          class="flex items-center w-full p-2 text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
          aria-controls="categories-dropdown" data-collapse-toggle="categories-dropdown">
          <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path
              d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
          </svg>
          <span class="flex-1 ms-3 text-left whitespace-nowrap">Categories</span>
          <svg class="w-3 h-3 ml-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M1 1l4 4 4-4" />
          </svg>
        </button>
        <?php
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <ul id="categories-dropdown" class="hidden py-2 space-y-2">
          <?php foreach ($categories as $category): ?>
            <li>
              <a href="/cookbook/guest/category.php?id=<?= $category['id'] ?>"
                class="flex items-center w-full p-2 pl-5 text-sm text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                aria-label="Category: <?= htmlspecialchars($category['name']) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                  class="w-4 h-4 mr-3 flex-shrink-0 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                  fill="currentColor" aria-hidden="true">
                  <path
                    d="M416 0C400 0 288 32 288 176v112c0 35.3 28.7 64 64 64h32v128c0 17.7 14.3 32 32 32s32-14.3 32-32V352h0V240V32c0-17.7-14.3-32-32-32zM64 16c0-8.2-6.1-15-14.3-15.9S34.2 4.6 32.4 12.5L2.1 148.8c-1.4 6.3-2.1 12.7-2.1 19.1 0 45.9 35.1 83.6 80 87.7V480c0 17.7 14.3 32 32 32s32-14.3 32-32v-224.4c44.9-4.1 80-41.8 80-87.7 0-6.4-.7-12.8-2.1-19.1L191.6 12.5c-1.8-8-9.3-13.3-17.4-12.4S160 7.8 160 16v134.2c0 5.4-4.4 9.8-9.8 9.8-5.1 0-9.3-3.9-9.8-9L127.9 14.6c-.7-8.3-7.6-14.6-16-14.6s-15.2 6.3-15.9 14.6L83.7 151c-.5 5.1-4.7 9-9.8 9-5.4 0-9.8-4.4-9.8-9.8L64 16zm48.3 152l-.3 0-.3 0 .3-.7 .3 .7z" />
                </svg>
                <span><?= htmlspecialchars($category['name']) ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>


      </li>

      <?php if (UsersController::isAdmin()): ?>
        <li>
          <button type="button"
            class="flex items-center w-full p-2 text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            aria-controls="admin-dropdown" data-collapse-toggle="admin-dropdown">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
              class="shrink-0 w-5 h-5 text-yellow-500 transition duration-75 dark:text-yellow-400 group-hover:text-yellow-700 dark:group-hover:text-yellow-300"
              fill="currentColor" aria-hidden="true">
              <path
                d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
            </svg>

            <span class="flex-1 ms-3 text-left whitespace-nowrap">Admin</span>

            <svg class="w-3 h-3 ml-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M1 1l4 4 4-4" />
            </svg>
          </button>

          <ul id="admin-dropdown" class="hidden py-2 space-y-2">
            <li>
              <a href="/cookbook/admin/showAllUsers.php"
                class="flex items-center w-full p-2 pl-5 text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">


                <svg class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                  <path
                    d="M16 0H4a2 2 0 0 0-2 2v1H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3 3 0 1 1 0 6 3 3 0 0 1 0-6ZM13.929 17H7.071a.5.5 0 0 1-.5-.5 3.935 3.935 0 1 1 7.858 0 .5.5 0 0 1-.5.5Z" />
                </svg>
                Users
              </a>
            </li>

            <li>
              <a href="/cookbook/admin/showUsersRecipes.php"
                class="flex items-center w-full p-2 pl-5 text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                  class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" fill="currentColor"
                  aria-hidden="true">
                  <path
                    d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l448 0c53 0 96-43 96-96l0-320c0-53-43-96-96-96L96 0zM64 96c0-17.7 14.3-32 32-32l448 0c17.7 0 32 14.3 32 32l0 320c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32L64 96zm159.8 80a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM96 309.3c0 14.7 11.9 26.7 26.7 26.7l56.1 0c8-34.1 32.8-61.7 65.2-73.6c-7.5-4.1-16.2-6.4-25.3-6.4l-69.3 0C119.9 256 96 279.9 96 309.3zM461.2 336l56.1 0c14.7 0 26.7-11.9 26.7-26.7c0-29.5-23.9-53.3-53.3-53.3l-69.3 0c-9.2 0-17.8 2.3-25.3 6.4c32.4 11.9 57.2 39.5 65.2 73.6zM372 289c-3.9-.7-7.9-1-12-1l-80 0c-4.1 0-8.1 .3-12 1c-26 4.4-47.3 22.7-55.9 47c-2.7 7.5-4.1 15.6-4.1 24c0 13.3 10.7 24 24 24l176 0c13.3 0 24-10.7 24-24c0-8.4-1.4-16.5-4.1-24c-8.6-24.3-29.9-42.6-55.9-47zM512 176a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM320 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128z" />
                </svg>

                Users Recipes
              </a>
            </li>

          </ul>
        </li>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user_id'])): ?>

      <li>
        <button type="button"
          class="flex items-center w-full p-2 text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
          aria-controls="user-dropdown" data-collapse-toggle="user-dropdown">
          <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path
              d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
          </svg>
          <span class="flex-1 ms-3 text-left whitespace-nowrap">Profile</span>
          <svg class="w-3 h-3 ml-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M1 1l4 4 4-4" />
          </svg>
        </button>
        <ul id="user-dropdown" class="hidden py-2 space-y-2">

          <li>
            <a href="/cookbook/user/account.php"
              class="flex items-center w-full p-2 pl-5 text-sm text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                class="w-4 h-4 mr-3 flex-shrink-0 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                aria-hidden="true" fill="currentColor">
                <path
                  d="M61.1 224C45 224 32 211 32 194.9c0-1.9 .2-3.7 .6-5.6C37.9 168.3 78.8 32 256 32s218.1 136.3 223.4 157.3c.5 1.9 .6 3.7 .6 5.6c0 16.1-13 29.1-29.1 29.1L61.1 224zM144 128a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm240 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32zM272 96a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zM16 304c0-26.5 21.5-48 48-48l384 0c26.5 0 48 21.5 48 48s-21.5 48-48 48L64 352c-26.5 0-48-21.5-48-48zm16 96c0-8.8 7.2-16 16-16l416 0c8.8 0 16 7.2 16 16l0 16c0 35.3-28.7 64-64 64L96 480c-35.3 0-64-28.7-64-64l0-16z" />
              </svg>
              My Account
            </a>
          </li>

          <li>
            <a href="/cookbook/user/index.php"
              class="flex items-center w-full p-2 pl-5 text-sm text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                class="w-4 h-4 mr-3 flex-shrink-0 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                aria-hidden="true" fill="currentColor">
                <path
                  d="M61.1 224C45 224 32 211 32 194.9c0-1.9 .2-3.7 .6-5.6C37.9 168.3 78.8 32 256 32s218.1 136.3 223.4 157.3c.5 1.9 .6 3.7 .6 5.6c0 16.1-13 29.1-29.1 29.1L61.1 224zM144 128a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm240 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32zM272 96a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zM16 304c0-26.5 21.5-48 48-48l384 0c26.5 0 48 21.5 48 48s-21.5 48-48 48L64 352c-26.5 0-48-21.5-48-48zm16 96c0-8.8 7.2-16 16-16l416 0c8.8 0 16 7.2 16 16l0 16c0 35.3-28.7 64-64 64L96 480c-35.3 0-64-28.7-64-64l0-16z" />
              </svg>

              My Recipes
            </a>
          </li>


          <li>
            <a href="../user/favorites.php"
              class="flex items-center w-full p-2 pl-5 text-sm text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                class="w-4 h-4 mr-3 flex-shrink-0 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                fill="currentColor" aria-hidden="true">
                <path
                  d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
              </svg>
              Bookmarks
            </a>
          </li>

        </ul>
      </li>
      <?php endif; ?>

      <?php if (empty($_SESSION['user_id'])): ?>

        <li>
          <a href="/cookbook/auth/login.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
            </svg>
            <span class="ms-3">Login</span>
          </a>
        </li>
        <li>
          <a href="/cookbook/auth/register.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
            </svg>
            <span class="ms-3">Register</span>
          </a>
        </li>

      <?php else: ?>
        <li>
          <a href="/cookbook/auth/logout.php">
            <button type="submit"
              class="flex items-center w-full p-2 text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
              style="margin-top: 34rem;" aria-label="Logout" title="Logout">
              <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                <path
                  d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
              </svg>
              <span class="flex-1 ms-3 text-left whitespace-nowrap">Logout</span>
            </button>
          </a>
        </li>
      <?php endif; ?>

    </ul>
  </div>
</div>
