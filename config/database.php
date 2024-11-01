<?php

class Database
{
  private $host;
  private $db_name;
  private $username;
  private $password;
  public $connection;

  public function __construct(string $db_host, string $db_name, string $db_username, string $db_password)
  {
    $this->host = $db_host;
    $this->db_name = $db_name;
    $this->username = $db_username;
    $this->password = $db_password;
  }

  public function getConnection()
  {
    $this->connection = null;
    try {
      $connection_information = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;

      $this->connection = new PDO($connection_information, $this->username, $this->password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    return $this->connection;
  }
}
