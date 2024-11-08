<?php

require "./database/Database.php";

require "./app/dao/Dao.php";
require "./app/dao/ArticleDao.php";
require "./app/dao/UserDao.php";
require "./app/dao/ReviewDao.php";

require "./app/model/Article.php";
require "./app/model/Review.php";
require "./app/model/User.php";

require "./app/controller/ArticleController.php";
require "./app/controller/AuthController.php";

require "./app/verificator/UserVerificator.php";
require "./app/verificator/ArticleVerificator.php";

require "./router.php";

use Application\controller\ArticleController;
use Application\controller\AuthController;
use Application\Database;
use Application\Router;

// mise en place de la session et de la db
$db_host = "localhost";
$db_name = "read_it_prod";
$db_test_name = "read_it_test";
$db_username = "root";
$db_password = "root";

session_start();
Database::createInstance($db_host, $db_name, $db_username, $db_password);

// routage, controller et dao
$articleController = new ArticleController();
$authController = new AuthController();

Router::addRoute("GET", "/", [$articleController, "index"]);

Router::addRoute("GET", "/user", [$authController, "index"]);
Router::addRoute("GET", "/{alias}", [$authController, "user"]);
Router::addRoute("GET", "/user/create", [$authController, "create"]);
Router::addRoute("POST", "/user/register", [$authController, "register"]);
Router::addRoute("GET", "/user/login", [$authController, "login"]);
Router::addRoute("POST", "/user/authentificate", [$authController, "authentificate"]);
Router::addRoute("GET", "/user/update/{alias}", [$authController, "update"]);
Router::addRoute("POST", "/user/change/{alias}", [$authController, "change"]);
Router::addRoute("GET", "/user/create", [$authController, "create"]);
Router::addRoute("GET", "/user/logout", [$authController, "logout"]);

Router::addRoute("GET", "/article/create", [$articleController, "create"]);
Router::addRoute("POST", "/article/register", [$articleController, "register"]);
Router::addRoute("GET", "/article/update/{slug}", [$articleController, "update"]);
Router::addRoute("POST", "/article/change/{slug}", [$articleController, "change"]);
Router::addRoute("GET", "/article/delete/{slug}", [$articleController, "delete"]);

$method = $_SERVER["REQUEST_METHOD"];
$path = $_SERVER["REQUEST_URI"];

Router::dispatch($method, $path);

// test
/*
require "./app/test/TestDao.php";
require "./app/test/dao/ArticleDaoTest.php";
require "./app/test/dao/ReviewDaoTest.php";
require "./app/test/dao/UserDaoTest.php";

use Application\test\TestDao;

Database::createInstance($db_host, $db_test_name, $db_username, $db_password);
TestDao::run();
*/
