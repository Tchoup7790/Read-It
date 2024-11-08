<?php

namespace Application\dao;

use PDO;
use Error;
use PDOException;

abstract class Dao
{
  protected static ?PDO $connection = null;
  protected ?string $table_name = null;

  // Construteur de la classe DAO
  // Récupère le nom de la class lier à l'instance et la connection à la BDD
  public function __construct(PDO $db_connection, string $table_name)
  {
    if (self::$connection === null) {
      self::$connection = $db_connection;
    }
    if ($this->table_name === null) {
      $this->table_name = $table_name;
    }
  }

  // Donne la connection de la BDD
  protected function getConnection(): PDO
  {
    if (self::$connection === null) {
      throw new Error("Database connection is not initialized.");
    }
    return self::$connection;
  }

  // Récupère tous les elements de la table
  protected function getAll(): array
  {
    $request = "SELECT * FROM " . $this->table_name;

    $stmt = self::$connection->prepare($request);

    try {
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Error("DAO.getAll failed: " . $e->getMessage());
    }
    return $data;
  }

  // Supprime tous les élements de la table
  public function clean()
  {
    $request = "DELETE FROM " . $this->table_name;

    $stmt = self::$connection->prepare($request);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("DAO.clean failed: " . $e->getMessage());
    }
  }
}
