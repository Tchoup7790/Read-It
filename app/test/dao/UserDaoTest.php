<?php

namespace Application\test\dao;

use Application\dao\UserDao;
use Application\model\User;

use Error;

class UserDaoTest
{
  private array $users;
  private UserDao $userDao;

  public function __construct()
  {
    $this->userDao = UserDao::getInstance();
    $this->userDao->clean();

    $this->users = [
      new User(0, "test", "johnD1234", "johnDoe@mail.com", "John Doe"),
      new User(0, "test", "MM1204", "mickeymouse@mail.com", "Mickey Mouse"),
      new User(0, "test", "spongB", "spongeBOB@mail.com", "Sponge Bob"),
    ];

    foreach ($this->users as $user) {
      $this->userDao->create($user);
    }
  }

  private function testGetAll()
  {
    $result = $this->userDao->getAll();

    // Vérification de la taille du résultat
    assert(
      sizeof($result) == 3,
      new Error("UserDaoTest.testGetAll failed: the size of the result is " . sizeof($result) . " but it should be 3")
    );

    // Met à jour l'ID et le Password de l'utilisateur dans le tableau
    foreach ($result as $index => $user) {
      $this->users[$index]->id = $user->id;
      $this->users[$index]->password_hash = $user->password_hash;
    }

    echo "UserDaoTest.testGetAll OK";
  }

  private function testFindById()
  {
    $user = $this->users[0];
    $result = $this->userDao->findById($user->id);

    assert(
      $result == $user,
      new Error("UserDaoTest.testFindById failed: the recovered user is " . $result . " but it should be " . $user)
    );

    echo "UserDaoTest.testFindById OK";
  }

  private function testFindByEmail()
  {
    $user = $this->users[2];
    $result = $this->userDao->findByEmail($user->email);

    assert(
      $result == $user,
      new Error("UserDaoTest.testFindByEmail failed: the recovered user is " . $result . " but it should be " . $user)
    );

    echo "UserDaoTest.testFindByEmail OK";
  }

  private function testFindByAlias()
  {
    $user = $this->users[2];
    $result = $this->userDao->findByAlias($user->alias);

    assert(
      $result == $user,
      new Error("UserDaoTest.testFindByAlias failed: the recovered user is " . $result . " but it should be " . $user)
    );

    echo "UserDaoTest.testFindByAlias OK";
  }

  private function testCreate()
  {
    $user = new User(0, "test", "bapt12iste", "juliobaptiste@mail.com", "Baptiste Julio");
    $result = $this->userDao->create($user);

    // Met à jour l'ID et le Password de l'utilisateur dans le tableau
    $user->id = $result->id;
    $user->password_hash = $result->password_hash;

    $this->users[] = $user;

    assert(
      $result == $user,
      new Error("UserDaoTest.testCreate failed: the create user is " . $result . " but it should be " . $user)
    );

    echo "UserDaoTest.testCreate OK";
  }

  private function testUpdate()
  {
    $user = $this->users[2];
    $user->alias = "Spong22";

    $result = $this->userDao->update($user);

    assert(
      $result->alias == $user->alias,
      new Error("UserDaoTest.testUpdate failed: the updated user alias is " . $result->alias . " but it should be " . $user->alias)
    );

    echo "UserDaoTest.testUpdate OK";
  }

  private function testDelete()
  {
    $user = $this->users[3];

    $old_size = sizeof($this->userDao->getAll());
    $this->userDao->delete($user->id);

    $new_size = sizeof($this->userDao->getAll());

    assert(
      $old_size - 1  == $new_size,
      new Error("UserDaoTest.testDelete failed: the size of the result is " . $new_size . " but it should be " . $old_size - 1)
    );

    echo "UserDaoTest.testDelete OK";
  }

  public function run()
  {
    $this->testGetAll();

    echo "<br>";

    $this->testFindById();

    echo "<br>";

    $this->testFindByEmail();

    echo "<br>";

    $this->testFindByAlias();

    echo "<br>";

    $this->testCreate();

    echo "<br>";

    $this->testUpdate();

    echo "<br>";
    $this->testDelete();

    echo "<p>";

    echo "UserDaoTest Ok";
  }
}
