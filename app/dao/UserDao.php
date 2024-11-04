<?php

namespace Application\dao;

use Application\model\User;

use PDO;
use PDOException;
use Error;

class UserDao
{
  private $connection;

  // Constructeur de la classe UserDao
  // Initialise la connexion à la base de données
  public function __construct(PDO $db_connection)
  {
    $this->connection = $db_connection;
  }

  // Récupère tous les utilisateurs de la base de données
  public function getAll(): array
  {
    $request = "SELECT * FROM users";

    $stmt = $this->connection->prepare($request);
    $stmt->execute();

    try {
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Error("User.getAll failed: " . $e->getMessage());
    }

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

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("User.findById failed: user doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("User.findById failed: " . $e->getMessage());
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

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("User.findByEmail failed : user doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("User.findByEmail failed: " . $e->getMessage());
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

    $stmt = $this->connection->prepare($request);

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
      throw new Error("User.create failed: " . $e->getMessage());
    }

    return $this->findByEmail($new_user->email);
  }

  // Met à jour les informations d'un utilisateur
  public function update(User $user): User
  {
    $request = "UPDATE users SET password = ?, email = ?, name = ?, alias = ?, description = ? WHERE id_user = ?";

    $stmt = $this->connection->prepare($request);

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
      throw new Error("User.update failed: " . $e->getMessage());
    }

    return $this->findById($user->id);
  }

  // Supprime un utilisateur de la base de données
  public function delete(User $user)
  {
    $request = "DELETE FROM users WHERE id_user = :id";

    $user_id = $user->id;

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("User.delete failed: " . $e->getMessage());
    }
  }

  // Supprime tous les élements de la table users
  public function clean()
  {
    $request = "DELETE FROM users";

    $stmt = $this->connection->prepare($request);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("User.clean failed: " . $e->getMessage());
    }
  }
}
