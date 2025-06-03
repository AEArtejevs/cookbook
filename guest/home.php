<?php include_once '../layout/head.php'; ?>

<section>
  <div class="grid max-w-screen-xl px-4 py-4 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
    <div class="mr-auto place-self-center lg:col-span-7">
      <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
        Cookbooks
      </h1>
      <p class="max-w-2xl mb-6 font-light text-gray-700 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
        Join a community of cookbook lovers & discover that Eat Your Books is a great way to make better use of your own collection
      </p>
      <a href="#" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
        Get started
        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </a>
      <a href="../guest/index.php" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
        See our newest recipes
      </a>
    </div>
    <div class="hidden max-w-full h-auto lg:mt-0 lg:col-span-5 lg:flex">
      <img src="../images/file.png" alt="mockup">
    </div>
  </div>
</section>

<?php include_once '../layout/footer.php'; ?>
