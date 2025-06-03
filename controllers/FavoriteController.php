<?php
require_once '../includes/db.php';

class FavoriteController
{
    public static function show($user_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT f.id as favorite_id, r.*
            FROM favorites f
            JOIN recipes r ON f.recipe_id = r.id
            WHERE f.user_id = ?
            ORDER BY f.created_at DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function store($user_id, $recipe_id)
    {
        global $pdo;
        $check = $pdo->prepare("SELECT id FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $check->execute([$user_id, $recipe_id]);

        if ($check->rowCount() === 0) {
            $insert = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
            return $insert->execute([$user_id, $recipe_id]);
        }
        return false;
    }

    public static function delete($user_id, $recipe_id)
    {
        global $pdo;
        $delete = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?");
        return $delete->execute([$user_id, $recipe_id]);
    }
    public static function getUserFavorites($pdo, $userId)
    {
        $stmt = $pdo->prepare("SELECT recipe_id FROM favorites WHERE user_id = ?");
        $stmt->execute([$userId]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'recipe_id');
    }
}
