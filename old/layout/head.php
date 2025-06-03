
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Your custom CSS -->
  <link rel="stylesheet" href="/Practical-Assignment-3/src/css/styles.css" />
<!-- You have two of these -->
<!-- <link rel="stylesheet" href="/Practical-Assignment-3/src/css/output.css" /> -->
<link href="/Practical-Assignment-3/src/output.css" rel="stylesheet">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" /> -->


  <title>Document</title>

  <script>
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark')
    }
  </script>
</head>
<?php include __DIR__ . '/navigation.php';?>