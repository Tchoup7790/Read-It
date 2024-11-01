<?php

class UserDao
{
  private $connection;

  // Constructeur de la classe UserDao
  // Initialise la connexion à la base de données
  public function __construct($db_connection)
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
      throw new Exception("User.getAll failed: " . $e->getMessage());
    }

    $users = [];
    foreach ($data as $row) {
      $user = new User($row["email"], $row["name"], $row["password"], $row["alias"], $row["description"]);
      $users[] = $user;
    }
    return $users;
  }

  // Trouve un utilisateur par son identifiant
  public function findById(int $id_user)
  {
    $request = "SELECT * FROM users WHERE id_user = :id LIMIT 1";

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":id", $id_user, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Exception("User.findById failed : user doesn't exist"); // Retourne une erreur si l'utilisateur n'est pas trouvé
      }
    } catch (PDOException $e) {
      throw new Exception("User.findById failed: " . $e->getMessage());
    }

    return new User($data["email"], $data["name"], $data["password"], $data["alias"], $data["description"]);
  }

  // Trouve un utilisateur par son adresse email
  public function findByEmail(string $email)
  {
    $request = "SELECT * FROM users WHERE email = :email LIMIT 1";

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère une seule ligne

      if (!$data) {
        throw new Exception("User.findByEmail failed : user doesn't exist"); // Retourne une erreur si l'utilisateur n'est pas trouvé
      }
    } catch (PDOException $e) {
      throw new Exception("User.findByEmail failed: " . $e->getMessage());
    }

    return new User($data["email"], $data["name"], $data["password"], $data["alias"], $data["description"]);
  }

  // Crée un nouvel utilisateur dans la base de données
  public function create(User $new_user)
  {
    $request = "INSERT INTO users (password, email, name) VALUES (?, ?, ?)";

    $stmt = $this->connection->prepare($request);

    $password = $new_user->getPasswordHash();
    $email = $new_user->getEmail();
    $name = $new_user->getName();

    $stmt->bindParam(1, $password, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->bindParam(3, $name, PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("User.create failed: " . $e->getMessage());
    }
  }

  // Met à jour les informations d'un utilisateur
  public function update(User $user)
  {
    $user_id = $this->getIdByEmail($user->getEmail());

    $request = "UPDATE users SET password = ?, email = ?, name = ?, alias = ?, description = ? WHERE id_user = ?";

    $stmt = $this->connection->prepare($request);

    $password = $user->getPasswordHash();
    $email = $user->getEmail();
    $name = $user->getName();
    $alias = $user->alias;
    $description = $user->description;

    $stmt->bindParam(1, $password, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->bindParam(3, $name, PDO::PARAM_STR);
    $stmt->bindParam(4, $alias, PDO::PARAM_STR);
    $stmt->bindParam(5, $description, PDO::PARAM_STR);
    $stmt->bindParam(6, $user_id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("User.update failed: " . $e->getMessage());
    }
  }

  // Supprime un utilisateur de la base de données
  public function delete(User $user)
  {
    $user_id = $this->getIdByEmail($user->getEmail());

    $request = "DELETE FROM users WHERE id_user = :id";

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("User.delete failed: " . $e->getMessage());
    }
  }

  // Récupère l'ID d'un utilisateur par son adresse email
  private function getIdByEmail(string $email)
  {
    $request = "SELECT * FROM users WHERE email = :email LIMIT 1";

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Exception("User.getIdByEmail failed : user doesn't exist"); // Retourne une erreur si l'utilisateur n'est pas trouvé
      }
    } catch (PDOException $e) {
      throw new Exception("User.getIdByEmail failed: " . $e->getMessage());
    }

    return $data["id_user"]; // Retourne l'ID de l'utilisateur
  }
}
