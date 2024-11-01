<?php

require "config/database.php";
require "app/dao/UserDao.php";
require "app/models/User.php";

// change information for your mysql configuration
$db_host = "localhost";
$db_name = "read_it_test";
$db_username = "root";
$db_password = "root";

$database = new Database($db_host, $db_name, $db_username, $db_password);

$userDao = new UserDao($database->getConnection());

require "app/utils/testUserDao.php";
