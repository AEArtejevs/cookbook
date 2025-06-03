<?php
session_start();
require_once '../includes/db.php';
require_once '../controllers/RecipesController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /cookbook/auth/login.php');
    exit;
}

$recipe_id = $_GET['id'] ?? null;
if (!$recipe_id) {
    header("Location: /cookbook/user/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // image upload
    $imageName = $_FILES['image']['name'] ?? null;
    if ($imageName) {
        $imageName = time() . '_' . basename($imageName);
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $imageName);
    } else {
        // Keep existing image
        $stmt = $pdo->prepare("SELECT image FROM recipes WHERE id = ?");
        $stmt->execute([$recipe_id]);
        $imageName = $stmt->fetchColumn();
    }

    $data = [
        'name' => $_POST['name'] ?? '',
        'description' => $_POST['description'] ?? '',
        'instructions' => $_POST['instructions'] ?? '',
        'duration' => intval($_POST['duration'] ?? 0),
        'category_id' => intval($_POST['category_id'] ?? 0),
        'image' => $imageName,
        'ingredients' => $_POST['ingredients'] ?? []
    ];

    if (RecipeController::update($recipe_id, $data, $_FILES)) {
        header("Location: /cookbook/user/index.php");
        exit;
    } else {
        echo "Failed to update recipe.";
        exit;
    }
}


$data = RecipeController::edit($recipe_id);
extract($data); // $recipe, $categories, $ingredients


?>
<?php include '../layout/head.php'; ?>

<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6 my-10">
  <h2 class="text-2xl font-semibold mb-6">Edit Recipe</h2>

<form method="POST" action="edit.php?id=<?= $recipe['id'] ?>" enctype="multipart/form-data" class="space-y-6">
  <input type="hidden" name="_method" value="PUT" />

  <div>
    <label for="name" class="block mb-1">Recipe Name</label>
    <input id="name" name="name" type="text" required value="<?= htmlspecialchars($recipe['name']) ?>"
           class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500" />
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
      <label for="duration" class="block mb-1">Duration (minutes)</label>
      <input id="duration" name="duration" type="number" min="1" required value="<?= htmlspecialchars($recipe['duration']) ?>"
             class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500" />
    </div>
    <div>
      <label for="category_id" class="block mb-1">Category</label>
      <select id="category_id" name="category_id" required
              class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500">
        <option value="" disabled>Select Category</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $recipe['category_id'] == $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div>
    <label for="description"class="block mb-1">Description</label>
    <textarea id="description" name="description" rows="4" required
              class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($recipe['description']) ?></textarea>
  </div>

  <div>
    <label for="instructions" class="block mb-1">Instructions</label>
    <textarea id="instructions" name="instructions" rows="4" required
              class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($recipe['instructions']) ?></textarea>
  </div>

  <div>
    <label class="block mb-1">Current Recipe Image</label>
    <img src="/cookbook/images/<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['name']) ?>"
         class="w-48 h-auto rounded-md mt-2 mb-3 shadow" />
  </div>

  <div>
    <label for="image" class="block mb-1">Upload New Image</label>
    <input id="image" name="image" type="file" accept="image/*"
           class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 dark:file:bg-indigo-900 dark:file:text-indigo-300 dark:hover:file:bg-indigo-800" />
    <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">Leave blank to keep existing image.</p>
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
    <div class="h-64 overflow-y-auto space-y-2 px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md">
      <?php
      $stmt = $pdo->prepare("SELECT ingredient_id, quantity, unit FROM ingredient_recipe WHERE recipe_id = ?");
      $stmt->execute([$recipe['id']]);
      $existing = [];
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $i) {
        $existing[$i['ingredient_id']] = $i;
      }
      ?>

      <?php foreach ($ingredients as $ingredient): ?>
        <?php $has = isset($existing[$ingredient['id']]); ?>
        <label for="ingredient-<?= $ingredient['id'] ?>" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
          <div class="flex items-center gap-2">
            <input id="ingredient-<?= $ingredient['id'] ?>" type="checkbox"
                   name="ingredients[<?= $ingredient['id'] ?>][selected]" value="1"
                   <?= $has ? 'checked' : '' ?>
                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-500">
            <span class="text-sm text-gray-900 dark:text-gray-300"><?= htmlspecialchars($ingredient['name']) ?></span>
          </div>
          <div class="flex gap-2">
            <input type="number" step="any" min="0"
                   name="ingredients[<?= $ingredient['id'] ?>][quantity]"
                   placeholder="Qty"
                   value="<?= $has ? htmlspecialchars($existing[$ingredient['id']]['quantity']) : '' ?>"
                   class="w-20 px-2 py-1 bg-gray-100 text-sm border border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />

            <input type="text"
                   name="ingredients[<?= $ingredient['id'] ?>][unit]"
                   placeholder="Unit"
                   value="<?= $has ? htmlspecialchars($existing[$ingredient['id']]['unit']) : '' ?>"
                   class="w-20 px-2 py-1 bg-gray-100 text-sm border border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200" />
          </div>
        </label>
      <?php endforeach; ?>
    </div>
  </div>

  <div>
    <button type="submit"
            class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow">
      Update Recipe
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
