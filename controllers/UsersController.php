<?php
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UsersController
{
    public static function isAdmin()
    {
        return isset($_SESSION['user_id'], $_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public static function getAllUsers()
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE role = 'user'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function deleteRecipe($recipeId)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
        return $stmt->execute([$recipeId]);
    }

    public static function getUsersWithRecipes()
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT users.id AS user_id, users.name, users.email, users.role,
            recipes.id AS recipe_id, recipes.name AS recipe_name
            FROM users
            LEFT JOIN recipes ON users.id = recipes.user_id
            WHERE users.role = 'user'
            ORDER BY users.id DESC
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($rows as $row) {
            $id = $row['user_id'];
            if (!isset($users[$id])) {
                $users[$id] = [
                    'id' => $id,
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'role' => $row['role'],
                    'recipes' => [],
                ];
            }

            if ($row['recipe_id']) {
                $users[$id]['recipes'][] = [
                    'id' => $row['recipe_id'],
                    'name' => $row['recipe_name'],
                ];
            }
        }

        return array_values($users);
    }
}
    public static function getUserData($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, name, email, role, gender, birthdate, image FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function updateUserProfile($id, $name, $gender = null, $birthdate = null, $imagePath = null)
    {
        global $pdo;

        if ($imagePath) {
            $stmt = $pdo->prepare("
            UPDATE users
            SET name = ?, gender = ?, birthdate = ?, image = ?, updated_at = NOW()
            WHERE id = ?
        ");
            return $stmt->execute([$name, $gender, $birthdate, $imagePath, $id]);
        } else {
            $stmt = $pdo->prepare("
            UPDATE users
            SET name = ?, gender = ?, birthdate = ?, updated_at = NOW()
            WHERE id = ?
        ");
            return $stmt->execute([$name, $gender, $birthdate, $id]);
        }
    }
