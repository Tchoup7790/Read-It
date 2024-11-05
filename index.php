<?php

require "./database/Database.php";

require "./app/dao/Dao.php";
require "./app/dao/ArticleDao.php";
require "./app/dao/UserDao.php";
require "./app/dao/ReviewDao.php";

require "./app/test/ArticleTest.php";
require "./app/test/ReviewTest.php";
require "./app/test/UserTest.php";

require "./app/model/Article.php";
require "./app/model/Review.php";
require "./app/model/User.php";

require "./app/controller/ArticleController.php";

use Application\Database;

// changer les informations selon votre propre configuration
$db_host = "localhost";
$db_name = "read_it_prod";
$db_test_name = "read_it_test";
$db_username = "root";
$db_password = "root";

// création des dao
/*
Database::getInstance($db_host, $db_name, $db_username, $db_password);
*/
// Récupérer l'URL demandée
$request = $_SERVER['REQUEST_URI'];

$request = rtrim($request, '/');
$request = explode('/', $request);



if ($request[0] == "") {
}

// test

use Application\dao\UserDao;
use Application\dao\ArticleDao;

use Application\test\UserTest;
use Application\test\ArticleTest;
use Application\test\ReviewTest;

$test_database = Database::createInstance($db_host, $db_test_name, $db_username, $db_password);
$userDao = UserDao::getInstance();
$articleDao = ArticleDao::getInstance();


$testUserDao = new UserTest();
$testUserDao->run();

echo "<p>";

$users = $userDao->getAll();
$user = $users[0];

$testArticleDao = new ArticleTest($user);
$testArticleDao->run();

echo "<p>";

$articles = $articleDao->getAll();
$article = $articles[0];

$testReviewDao = new ReviewTest($user, $article);
$testReviewDao->run();
