<?php
header('Content-Type: text/html; charset=utf-8');

// Optional: include your layout
// include '../layout/head.php';

$host = 'localhost';
$port = 3306; // change to 3307 if you're using that in XAMPP
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dbname = 'cookbook_db';

try {
    // Connect without selecting a DB
    $dsn = "mysql:host=$host;port=$port;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create DB
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET $charset COLLATE utf8mb4_general_ci");
    echo "<p>Database '$dbname' created or already exists.</p>";

    // Connect to the new DB
    $dsnDb = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsnDb, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS categories (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS ingredients (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS recipes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            category_id INT UNSIGNED NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            instructions TEXT NOT NULL,
            duration INT UNSIGNED NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        );

        CREATE TABLE IF NOT EXISTS ingredient_recipe (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            recipe_id INT UNSIGNED NOT NULL,
            ingredient_id INT UNSIGNED NOT NULL,
            quantity VARCHAR(50) DEFAULT NULL,
            unit VARCHAR(50) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
            FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS favorites (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            recipe_id INT UNSIGNED NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
        );
    ");
    echo "<p>Tables created or already exist.</p>";

    // Optional: insert default admin user
    $adminEmail = 'admin@cookbook.test';
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$adminEmail]);
    if ($check->rowCount() === 0) {
        $name = 'Admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $insert->execute([$name, $adminEmail, $password]);
        echo "<p>Default admin user created (email: $adminEmail / password: admin123).</p>";
    } else {
        echo "<p>Admin user already exists.</p>";
    }

    echo "<p>Setup complete.</p>";

} catch (PDOException $e) {
    echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
}
?>
