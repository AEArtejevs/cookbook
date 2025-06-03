<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/RecipesController.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: /cookbook/auth/login.php');
  exit;
}

$formData = RecipeController::create();
$categories = $formData['categories'];
$ingredients = $formData['ingredients'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $imageName = null;
  if (!empty($_FILES['image']['name'])) {
    $imageName = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $imageName);
  }

  $recipeData = [
    'user_id' => $_SESSION['user_id'],
    'name' => $_POST['name'] ?? '',
    'description' => $_POST['description'] ?? '',
    'instructions' => $_POST['instructions'] ?? '',
    'duration' => intval($_POST['duration'] ?? 0),
    'category_id' => intval($_POST['category_id'] ?? 0),
    'image' => $imageName,
    'ingredients' => $_POST['ingredients'] ?? []
  ];

  RecipeController::store($recipeData, $_FILES);
  header("Location: /cookbook/user/index.php");
  exit;
}
?>

<?php include '../layout/head.php'; ?>

<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6 my-10">
  <h2 class="text-2xl font-semibold mb-6">Create New Recipe</h2>

  <form method="POST" enctype="multipart/form-data" class="space-y-6">
    <div>
      <label for="name" class="block mb-1">Recipe Name</label>
      <input id="name" name="name" type="text" required
        class="p-2 w-full bg-white text-gray-900 border border-gray-300 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <label for="duration" class="block mb-1">Duration (minutes)</label>
        <input id="duration" name="duration" type="number" min="1" required
          class="p-2 w-full bg-white text-gray-900 border border-gray-300 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
      </div>

      <div>
        <label for="category_id" class="block mb-1">Category</label>
        <select id="category_id" name="category_id" required
          class="p-2 w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm">
          <option value="" disabled selected>Select Category</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div>
      <label for="description" class="block mb-1">Description</label>
      <textarea id="description" name="description" rows="4" required
        class="w-full bg-white text-gray-900 border border-gray-300 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
    </div>

    <div>
      <label for="instructions" class="block mb-1">Instructions</label>
      <textarea id="instructions" name="instructions" rows="4" required
        class="w-full bg-white text-gray-900 border border-gray-300 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
    </div>

    <div>
      <label for="image" class="block mb-1">Recipe Image</label>
      <input id="image" name="image" type="file" accept="image/*" required
        class="w-full pl-2 mt-2 block text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ingredients</label>

      <div class="relative mb-3">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input id="ingredient-search" type="text"
          class="block w-full ps-10 p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
          placeholder="Search (not functional)">
      </div>

      <div class="h-64 overflow-y-auto space-y-3 px-2 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md">
        <?php foreach ($ingredients as $ingredient): ?>
          <label for="ingredient-<?= $ingredient['id'] ?>"
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
            <div class="flex items-center space-x-2">
              <input id="ingredient-<?= $ingredient['id'] ?>" type="checkbox"
                name="ingredients[<?= $ingredient['id'] ?>][selected]" value="1"
                class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-600 dark:border-gray-500">
              <span class="text-sm font-medium text-gray-900 dark:text-gray-300">
                <?= htmlspecialchars($ingredient['name']) ?>
              </span>
            </div>

            <div class="flex space-x-2 w-full sm:w-auto">
              <input type="number" step="any" min="0"
                name="ingredients[<?= $ingredient['id'] ?>][quantity]" placeholder="Qty"
                   class="w-20 px-2 py-1 bg-gray-100 text-sm border border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
                
              <input type="text"
                name="ingredients[<?= $ingredient['id'] ?>][unit]" placeholder="Unit"
                   class="w-20 px-2 text-py-1 bg-gray-100 text-sm border border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
            </div>
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <div>
      <button type="submit"
        class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md">
        Create Recipe
      </button>
    </div>
  </form>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector('#ingredient-search');
    const labels = document.querySelectorAll('label[for^="ingredient-"]');

    searchInput.addEventListener("input", function() {
      const query = this.value.trim().toLowerCase();
      labels.forEach(label => {
        const span = label.querySelector("span");
        if (!span) return;
        const name = span.textContent.toLowerCase();
        label.style.display = name.includes(query) ? "flex" : "none";
      });
    });
  });
</script>

<?php include '../layout/footer.php'; ?>