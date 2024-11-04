<?php

require "./database/Database.php";
require "./app/test/UserTest.php";
require "./app/dao/UserDao.php";
require "./app/model/User.php";

use Application\Database;
use Application\test\UserTest;

// changer les informations selon votre propre configuration
$db_host = "localhost";
$db_name = "read_it_prod";
$db_test_name = "read_it_test";
$db_username = "root";
$db_password = "root";

$database = new Database($db_host, $db_name, $db_username, $db_password);
$test_database = new Database($db_host, $db_test_name, $db_username, $db_password);

$testUserDao = new UserTest($test_database->getConnection());
$testUserDao->run();
