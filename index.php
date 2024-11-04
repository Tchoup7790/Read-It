<?php

require "./database/Database.php";

require "./app/test/UserTest.php";
require "./app/dao/UserDao.php";
require "./app/model/User.php";

require "./app/test/ArticleTest.php";
require "./app/dao/ArticleDao.php";
require "./app/model/Article.php";

require "./app/test/ReviewTest.php";
require "./app/dao/ReviewDao.php";
require "./app/model/Review.php";

use Application\Database;

use Application\dao\UserDao;
use Application\dao\ArticleDao;

use Application\test\UserTest;
use Application\test\ArticleTest;
use Application\test\ReviewTest;

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

$articleDao = new ArticleDao($test_database->getConnection());
$articles = $articleDao->getAll();
$article = $articles[0];

echo "<p>";

$testReviewDao = new ReviewTest($test_database->getConnection(), $user, $article);
$testReviewDao->run();
