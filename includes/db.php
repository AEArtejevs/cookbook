<?php
require_once __DIR__ . '/../classes/Database.php';

$db = new Database();
$pdo = $db->connect();
