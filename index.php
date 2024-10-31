<?php

require "data/config.php";
require "app/dao/user_dao.php";

$userDao = new UserDao($pdo);

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
