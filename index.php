<?php

require "data/database.php";
require "app/dao/user_dao.php";

// change information for your mysql configuration
$db_host = "localhost";
$db_name = "read_it_test";
$db_username = "root";
$db_password = "root";

$database = new Database($db_host, $db_name, $db_username, $db_password);

$userDao = new UserDao($database->getConnection());

// $data = $userDao->getAll();
//
// foreach ($data as $value) {
//   foreach ($value as $key => $user) {
//     echo "$key: $user<br>";
//   }
//   echo "<br>";
// }

$data = $userDao->findByEmail("laura@example.com");

foreach ($data as $key => $value) {
  echo "$key => $value<br>";
}
