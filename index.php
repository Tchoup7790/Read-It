<?php

require "./database/Database.php";
require "./app/test/UserTest.php";
require "./app/dao/UserDao.php";
require "./app/model/User.php";
require "./app/test/ArticleTest.php";
require "./app/dao/ArticleDao.php";
require "./app/model/Article.php";

use Application\dao\UserDao;
use Application\Database;
use Application\test\UserTest;
use Application\test\ArticleTest;

// changer les informations selon votre propre configuration
$db_host = "localhost";
$db_name = "read_it_prod";
$db_test_name = "read_it_test";
$db_username = "root";
$db_password = "root";

$database = new Database($db_host, $db_name, $db_username, $db_password);

// test
$test_database = new Database($db_host, $db_test_name, $db_username, $db_password);

$testUserDao = new UserTest($test_database->getConnection());
$testUserDao->run();

$userDao = new UserDao($test_database->getConnection());
$users = $userDao->getAll();
$user = $users[0];

echo "<p>";

$testArticleDao = new ArticleTest($test_database->getConnection(), $user);
$testArticleDao->run();
