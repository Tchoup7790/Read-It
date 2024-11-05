<?php

namespace Application\dao;

use Application\Database;
use Application\model\User;

use PDO;
use PDOException;
use Error;

class UserDao extends Dao
{
  private static $instance = null;

  // Constructeur de la classe UserDao
  // Initialise la connexion à la base de données
  public function __construct(PDO $db_connection)
  {
    parent::__construct($db_connection, "users");
  }

  // Donne l'instance unique du DAO
  public static function getInstance(): UserDao
  {
    if (self::$instance === null) {
      self::$instance = new UserDao(Database::$instance->getConnection());
    }
    return self::$instance;
  }

  // Récupère tous les utilisateurs de la base de données
  public function getAll(): array
  {
    $data = parent::getAll();

    $users = [];
    foreach ($data as $row) {
      $user = new User(
        $row["id_user"],
        $row["password"],
        $row["alias"],
        $row["email"],
        $row["name"],
        $row["description"],
      );
      $users[] = $user;
    }
    return $users;
  }

  // Trouve un utilisateur par son identifiant
  public function findById(int $id): User
  {
    $request = "SELECT * FROM users WHERE id_user = :id LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("USERDAO.findById failed: user doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("USERDAO.findById failed: " . $e->getMessage());
    }

    return new User(
      $data["id_user"],
      $data["password"],
      $data["alias"],
      $data["email"],
      $data["name"],
      $data["description"],
    );
  }

  // Trouve un utilisateur par son adresse email
  public function findByEmail(string $email): User
  {
    $request = "SELECT * FROM users WHERE email = :email LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Error("USERDAO.findByEmail failed: " . $e->getMessage());
    }

    return new User(
      $data["id_user"],
      $data["password"],
      $data["alias"],
      $data["email"],
      $data["name"],
      $data["description"],
    );
  }

  // Trouve un utilisateur par son alias 
  public function findByAlias(string $alias): User
  {
    $request = "SELECT * FROM users WHERE alias = :alias LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":alias", $alias, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Error("USERDAO.findByEmail failed: " . $e->getMessage());
    }

    return new User(
      $data["id_user"],
      $data["password"],
      $data["alias"],
      $data["email"],
      $data["name"],
      $data["description"],
    );
  }
  // Crée un nouvel utilisateur dans la base de données
  public function create(User $new_user): User
  {
    $request = "INSERT INTO users (password, alias, description, email, name) VALUES ( ?, ?, ?, ?, ?)";

    $stmt = self::$connection->prepare($request);

    $password = password_hash($new_user->password_hash, PASSWORD_DEFAULT);
    $alias = $new_user->alias;
    $description = is_null($new_user->description) ? null :  $new_user->description;
    $email = $new_user->email;
    $name = $new_user->name;

    $stmt->bindParam(1, $password, PDO::PARAM_STR);
    $stmt->bindParam(2, $alias, PDO::PARAM_STR);
    $stmt->bindParam(3, $description, PDO::PARAM_STR);
    $stmt->bindParam(4, $email, PDO::PARAM_STR);
    $stmt->bindParam(5, $name, PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      var_dump($e);
      throw new Error("USERDAO.create failed: " . $e->getMessage());
    }

    return $this->findByEmail($new_user->email);
  }

  // Met à jour les informations d'un utilisateur
  public function update(User $user): User
  {
    $request = "UPDATE users SET password = ?, email = ?, name = ?, alias = ?, description = ? WHERE id_user = ?";

    $stmt = self::$connection->prepare($request);

    $password = $user->password_hash;
    $email = $user->email;
    $name = $user->name;
    $alias = $user->alias;
    $description = $user->description;
    $user_id = $user->id;

    $stmt->bindParam(1, $password, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->bindParam(3, $name, PDO::PARAM_STR);
    $stmt->bindParam(4, $alias, PDO::PARAM_STR);
    $stmt->bindParam(5, $description, PDO::PARAM_STR);
    $stmt->bindParam(6, $user_id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("USERDAO.update failed: " . $e->getMessage());
    }

    return $this->findById($user->id);
  }

  // Supprime un utilisateur de la base de données
  public function delete(int $id)
  {
    $request = "DELETE FROM users WHERE id_user = :id";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("USERDAO.delete failed: " . $e->getMessage());
    }
  }
}
