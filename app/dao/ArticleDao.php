<?php

namespace Application\dao;

use Application\Database;
use Application\model\Article;

use PDO;
use PDOException;
use Error;

class ArticleDao extends Dao
{
  private static ?ArticleDao $instance = null;

  // Construteur de la classe ArticleDao
  // Initialise la connexion à la BDD et donne le nom de la table à la class parent
  private function __construct(PDO $db_connection)
  {
    parent::__construct($db_connection, "articles");
  }

  // Donne l'instance unique du DAO
  public static function getInstance(): ArticleDao
  {
    if (self::$instance === null) {
      self::$instance = new ArticleDao(Database::$instance->getConnection());
    }
    return self::$instance;
  }

  // Récupère tous les articles de la BDD
  public function getAll(): array
  {
    $data = parent::getAll();

    $articles = [];
    foreach ($data as $row) {
      $article = new Article(
        $row["id_article"],
        $row["id_user"],
        $row["slug"],
        $row["title_article"],
        $row["content_article"],
      );
      $articles[] = $article;
    };
    return $articles;
  }

  // Récupère tous les articles liés à un utilisateur
  public function getByUserId(int $id): array
  {
    $request = "SELECT * FROM articles WHERE id_user = :id";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Error("ARTICLEDAO.getByUserId failed: " . $e->getMessage());
    }

    $articles = [];
    foreach ($data as $row) {
      $article = new Article(
        $row["id_article"],
        $row["id_user"],
        $row["slug"],
        $row["title_article"],
        $row["content_article"],
      );
      $articles[] = $article;
    };
    return $articles;
  }

  // Trouve un article par son identifiant
  public function findById(int $id): Article
  {
    $request = "SELECT * FROM articles WHERE id_article = :id LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("ARTICLEDAO.findById failed: article doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("ARTICLEDAO.findById failed: " . $e->getMessage());
    }

    return new Article(
      $data["id_article"],
      $data["id_user"],
      $data["slug"],
      $data["title_article"],
      $data["content_article"],
    );
  }

  // Trouve un article par son slug
  public function findBySlug(string $slug): Article
  {
    $request = "SELECT * FROM articles WHERE slug = :slug LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("ARTICLEDAO.findBySlug failed: article doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("ARTICLEDAO.findBySlug failed: " . $e->getMessage());
    }

    return new Article(
      $data["id_article"],
      $data["id_user"],
      $data["slug"],
      $data["title_article"],
      $data["content_article"],
    );
  }

  // Crée un nouvel article dans la BDD
  public function create(Article $new_article): Article
  {
    $request = "INSERT INTO articles (id_user, slug, title_article, content_article) VALUES (?, ?, ?, ?)";

    $stmt = self::$connection->prepare($request);

    $id_user = $new_article->user_id;
    $slug = $new_article->slug;
    $title = $new_article->title;
    $content = $new_article->content;

    $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
    $stmt->bindParam(2, $slug, PDO::PARAM_STR);
    $stmt->bindParam(3, $title, PDO::PARAM_STR);
    $stmt->bindParam(4, $content, PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("ARTICLEDAO.create failed: " . $e->getMessage());
    }

    return $this->findBySlug($new_article->slug);
  }

  // Met à jour les informations un article 
  public function update(Article $article): Article
  {
    $request = "UPDATE articles SET id_user = ?, slug = ?, title_article = ?, content_article = ? WHERE id_article = ?";

    $stmt = self::$connection->prepare($request);

    $id_user = $article->user_id;
    $slug = $article->slug;
    $title = $article->title;
    $content = $article->content;
    $id = $article->id;


    $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
    $stmt->bindParam(2, $slug, PDO::PARAM_STR);
    $stmt->bindParam(3, $title, PDO::PARAM_STR);
    $stmt->bindParam(4, $content, PDO::PARAM_STR);
    $stmt->bindParam(5, $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("ARTICLEDAO.update failed: " . $e->getMessage());
    }

    return $this->findById($article->id);
  }

  // Supprime un article selon son id
  public function delete(int $id)
  {
    $request = "DELETE FROM articles WHERE id_article = :id";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("ARTICLEDAO.delete failed: " . $e->getMessage());
    }
  }
}
