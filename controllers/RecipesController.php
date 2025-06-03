<?php
require_once '../includes/db.php';

class RecipeController
{
    public static function userRecipes($user_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function index($pdo, $userId = null)
    {
        $search = $_GET['search'] ?? '';

        if (!empty($search)) {
            $stmt = $pdo->prepare("SELECT * FROM recipes WHERE name LIKE ? ORDER BY created_at DESC LIMIT 10");
            $stmt->execute(["%$search%"]);
        } else {
            $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC LIMIT 10");
        }

        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $favoriteRecipeIds = [];
        if ($userId) {
            $stmt = $pdo->prepare("SELECT recipe_id FROM favorites WHERE user_id = ?");
            $stmt->execute([$userId]);
            $favoriteRecipeIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'recipe_id');
        }

        return [
            'recipes' => $recipes,
            'favoriteRecipeIds' => $favoriteRecipeIds
        ];
    }

    public static function show($recipe_id)
    {
        global $pdo;

        // Join with categories and users to get full data
        $stmt = $pdo->prepare("
        SELECT r.*, c.name AS category_name, u.name AS user_name
        FROM recipes r
        LEFT JOIN categories c ON r.category_id = c.id
        LEFT JOIN users u ON r.user_id = u.id
        WHERE r.id = ?
    ");
        $stmt->execute([$recipe_id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            return null; // Recipe not found
        }

        // Load ingredients (name, quantity, unit)
        $ingredients = $pdo->prepare("
        SELECT i.id, i.name, ir.quantity, ir.unit
        FROM ingredients i
        JOIN ingredient_recipe ir ON i.id = ir.ingredient_id
        WHERE ir.recipe_id = ?
    ");
        $ingredients->execute([$recipe_id]);
        $recipe['ingredients'] = $ingredients->fetchAll(PDO::FETCH_ASSOC);

        return $recipe;
    }


    public static function create()
    {
        global $pdo;
        $categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
        $ingredients = $pdo->query("SELECT id, name FROM ingredients ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
        return compact('categories', 'ingredients');
    }

    public static function store($data, $files)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO recipes (user_id, name, description, instructions, duration, category_id, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $data['user_id'],
            $data['name'],
            $data['description'],
            $data['instructions'],
            $data['duration'],
            $data['category_id'],
            $data['image']
        ]);
        $recipe_id = $pdo->lastInsertId();

        foreach ($data['ingredients'] as $id => $info) {
            if (isset($info['selected'])) {
                $stmt = $pdo->prepare("INSERT INTO ingredient_recipe (recipe_id, ingredient_id, quantity, unit) VALUES (?, ?, ?, ?)");
                $stmt->execute([$recipe_id, $id, $info['quantity'] ?? null, $info['unit'] ?? null]);
            }
        }

        return $recipe_id;
    }
    public static function edit($recipe_id)
    {
        global $pdo;
        $recipe = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
        $recipe->execute([$recipe_id]);
        $recipe = $recipe->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            return null; // Recipe not found
        }

        $categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
        $ingredients = $pdo->query("SELECT id, name FROM ingredients ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

        return compact('recipe', 'categories', 'ingredients');
    }
    public static function update($recipe_id, $data, $files)
    {
        global $pdo;

        $stmt = $pdo->prepare("UPDATE recipes SET name = ?, description = ?, instructions = ?, duration = ?, category_id = ?, image = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['instructions'],
            $data['duration'],
            $data['category_id'],
            $data['image'],
            $recipe_id
        ]);

        // Update ingredients
        $pdo->prepare("DELETE FROM ingredient_recipe WHERE recipe_id = ?")->execute([$recipe_id]);
        foreach ($data['ingredients'] as $id => $info) {
            if (isset($info['selected'])) {
                $stmt = $pdo->prepare("INSERT INTO ingredient_recipe (recipe_id, ingredient_id, quantity, unit) VALUES (?, ?, ?, ?)");
                $stmt->execute([$recipe_id, $id, $info['quantity'] ?? null, $info['unit'] ?? null]);
            }
        }

        return true;
    }
    public static function delete($recipe_id)
    {
        global $pdo;

        $pdo->prepare("DELETE FROM ingredient_recipe WHERE recipe_id = ?")->execute([$recipe_id]);
        $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
        return $stmt->execute([$recipe_id]);
    }
    public static function recipesByCategory($pdo, $categoryId, $userId = null)
{
    // Fetch category
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        // Handle not found, or redirect
        header("Location: /cookbook/guest/index.php");
        exit;
    }

    // Fetch recipes in this category
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE category_id = ? ORDER BY created_at DESC LIMIT 10");
    $stmt->execute([$categoryId]);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get favorites for this user
    $favoriteRecipeIds = [];
    if ($userId !== null) {
        $stmt = $pdo->prepare("SELECT recipe_id FROM favorites WHERE user_id = ?");
        $stmt->execute([$userId]);
        $favoriteRecipeIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'recipe_id');
    }

    return [
        'recipes' => $recipes,
        'category' => $category,
        'favoriteRecipeIds' => $favoriteRecipeIds
    ];
}

}
