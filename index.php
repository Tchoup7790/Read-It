<?php

require "data/config.php";
require "app/dao/user_dao.php";

$userDao = new UserDao($pdo);

$userDao->findAll();
