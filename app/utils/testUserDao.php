<?php

// test for user getAll 
/*
$data = $userDao->getAll();

foreach ($data as $user) {
  echo "$user<br>";
}
*/

// test for user findById

// echo $userDao->findById(2);


// test for user findByEmail 

// echo $userDao->findByEmail("laura@example.com");


//test for user create
/*
$john = new User("john@doe", "john doe", "test");
$userDao->create($john);

echo $userDao->findByEmail("john@doe");
*/

//test for user update
/*
$john = new User("john@doe", "john doe", "test");
$userDao->create($john);

echo $userDao->findByEmail("john@doe")."<br>";

$john->setName("test");
$john->setAlias("test");

$userDao->update($john);

echo $userDao->findByEmail("john@doe");
*/

//test for user delete
/*
$john = new User("john@doe", "john doe", "test");
$userDao->create($john);

echo $userDao->findByEmail("john@doe") . "<br>";

$userDao->delete($john);

echo $userDao->findByEmail("john@doe");
*/
