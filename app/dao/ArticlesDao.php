<?php

namespace Application\dao;

use Application\model\Article;

use PDO;
use PDOException;
use Error;

class ArticleDao
{
  private $connection;


  // Construteur de la classe ArticleDao
  // Initialise la connexion à la BDD
  public function __construct(PDO $db_connection)
  {
    $this->connection = $db_connection;
  }

  // Récupère tous les articles de la BDD
  public function getAll(): array
  {
    $request = "SELECT * FROM articles";

    $stmt = $this->connection->prepare($request);
    $stmt->execute();

    try {
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Error("Article.getAll failed : " . $e->getMessage());
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

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("Article.findById failed: article doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("Article.findById failed: " . $e->getMessage());
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

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("Article.findBySlug failed: article doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("Article.findBySlug failed: " . $e->getMessage());
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
    $request = "INSERT INTO articles (id_user, slug, title_article, content_article) VALUES ( ?, ?, ?, ?)";

    $stmt = $this->connection->prepare($request);

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
      throw new Error("Article.create failed: " . $e->getMessage());
    }

    return $this->findBySlug($new_article->slug);
  }

  // Met à jour les informations un article 
  public function update(Article $article): Article
  {
    $request = "UPDATE articles SET id_user = ?, slug = ?, title_article = ?, content_article = ? WHERE id_article = ?";

    $stmt = $this->connection->prepare($request);

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
      throw new Error("Article.update failed: " . $e->getMessage());
    }

    return $this->findById($article->id);
  }

  // Supprime un article de la BDD
  public function delete(Article $article)
  {
    $request = "DELETE FROM articles WHERE id_article = :id";

    $article_id = $article->id;

    $stmt = $this->connection->prepare($request);
    $stmt->bindParam(":id", $article_id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("Article.delete failed: " . $e->getMessage());
    }
  }

  // Supprime tous les élements de la table articles
  public function clean()
  {
    $request = "DELETE FROM articles";

    $stmt = $this->connection->prepare($request);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("Article.clean failed: " . $e->getMessage());
    }
  }
}
