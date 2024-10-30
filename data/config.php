<?php

$db_host = "localhost";
$db_name = "read_it_test";
$db_username = "root";
$db_password = "root";

try {
    $pdo = new PDO("mysql:host=".$db_host.";dbname=".$db_name, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
