<?php

namespace Application;

use PDO;
use PDOException;

class Database
{
  public static $instance = null;
  private $connection;
  private $host;
  private $db_name;
  private $username;
  private $password;

  private function __construct(string $db_host, string $db_name, string $db_username, string $db_password)
  {
    $this->host = $db_host;
    $this->db_name = $db_name;
    $this->username = $db_username;
    $this->password = $db_password;
    $this->connection = $this->connect();
  }

  public static function createInstance(string $db_host, string $db_name, string $db_username, string $db_password): Database
  {
    self::$instance = new Database($db_host, $db_name, $db_username, $db_password);
    return self::$instance;
  }

  private function connect(): PDO
  {
    if ($this->connection === null) {
      try {
        $connection_information = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
        $this->connection = new PDO($connection_information, $this->username, $this->password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }
    return $this->connection;
  }

  public function getConnection(): PDO
  {
    return $this->connection;
  }
}
