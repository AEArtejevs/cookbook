<?php

require_once '../includes/db.php';

$adminEmail = 'admin@gmail.com';
$adminName = 'Admin';
$adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
$adminRole = 'admin';

try {
    $pdo->beginTransaction();

    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$adminEmail]);

    if ($check->rowCount() === 0) {
        $insert = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $insert->execute([$adminName, $adminEmail, $adminPassword, $adminRole]);
        echo "Admin user seeded successfully.";
    } else {
        echo "Admin user already exists.";
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error seeding admin user: " . $e->getMessage();
}
