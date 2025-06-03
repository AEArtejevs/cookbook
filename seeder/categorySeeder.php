<?php

require_once '../includes/db.php';

$categories = [
    'Dinners',
    'Lunches',
    'Breakfasts',
    'Desserts',
    'Snacks & Appetizers',
    'Drinks',
    'Holidays & Seasons',
];

try {
    $pdo->beginTransaction();

    $checkCategories = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
    $insertStmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");

    foreach ($categories as $name) {
        $checkCategories->execute([$name]);
        $exists = $checkCategories->fetchColumn();

        if (!$exists) {
            $insertStmt->execute([$name]);
        }
    }

    $pdo->commit();
    echo "Categories seeded successfully.";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error seeding categories: " . $e->getMessage();
}
