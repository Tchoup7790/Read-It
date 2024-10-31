<?php

class UserDao
{
  private $connection;

  public function __construct($db_connection)
  {
    $this->connection = $db_connection;
  }

  public function getAll()
  {
    $request = "SELECT * FROM users";

    $stmt = $this->connection->prepare($request);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByEmail(string $email)
  {
    $request = "SELECT * FROM users WHERE email = :email LIMIT 1";

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
