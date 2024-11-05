<?php

namespace Application\dao;

use Application\Database;
use Application\model\Review;

use PDO;
use PDOException;
use Error;

class ReviewDao extends Dao
{
  private static ?ReviewDao $instance = null;

  // Construteur de la classe ReviewDao
  // Initialise la connexion à la BDD
  public function __construct(PDO $db_connection)
  {
    parent::__construct($db_connection, "reviews");
  }

  // Donne l'instance unique du Dao
  public static function getInstance(): ReviewDao
  {
    if (self::$instance === null) {
      self::$instance = new ReviewDao(Database::$instance->getConnection());
    }
    return self::$instance;
  }

  // Récupère tous les commentaires de la BDD
  public function getAll(): array
  {
    $data = parent::getAll();

    $reviews = [];
    foreach ($data as $row) {
      $review = new Review(
        $row["id_review"],
        $row["id_user"],
        $row["id_article"],
        $row["slug"],
        $row["title_review"],
        $row["content_review"],
      );
      $reviews[] = $review;
    };
    return $reviews;
  }

  // Trouve un commentaires par son identifiant
  public function findById(int $id): Review
  {
    $request = "SELECT * FROM reviews WHERE id_review = :id LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("REVIEWDAO.findById failed: review doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("REVIEWDAO.findById failed: " . $e->getMessage());
    }

    return new Review(
      $data["id_review"],
      $data["id_user"],
      $data["id_article"],
      $data["slug"],
      $data["title_review"],
      $data["content_review"],
    );
  }

  // Trouve un commentaire par son slug
  public function findBySlug(string $slug): Review
  {
    $request = "SELECT * FROM reviews WHERE slug = :slug LIMIT 1";

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

    try {
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        throw new Error("REVIEWDAO.findBySlug failed: review doesn't exist");
      }
    } catch (PDOException $e) {
      throw new Error("REVIEWDAO.findBySlug failed: " . $e->getMessage());
    }

    return new Review(
      $data["id_review"],
      $data["id_user"],
      $data["id_article"],
      $data["slug"],
      $data["title_review"],
      $data["content_review"],
    );
  }

  // Crée un nouvel commentaire dans la BDD
  public function create(Review $new_review): Review
  {
    $request = "INSERT INTO reviews (id_user, id_article, slug, title_review, content_review) VALUES ( ?, ?, ?, ?, ?)";

    $stmt = self::$connection->prepare($request);

    $id_user = $new_review->user_id;
    $id_article = $new_review->article_id;
    $slug = $new_review->slug;
    $title = $new_review->title;
    $content = $new_review->content;

    $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
    $stmt->bindParam(2, $id_article, PDO::PARAM_INT);
    $stmt->bindParam(3, $slug, PDO::PARAM_STR);
    $stmt->bindParam(4, $title, PDO::PARAM_STR);
    $stmt->bindParam(5, $content, PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("REVIEWDAO.create failed: " . $e->getMessage());
    }

    return $this->findBySlug($new_review->slug);
  }

  // Met à jour les commentaires un article 
  public function update(Review $review): Review
  {
    $request = "UPDATE reviews SET id_user = ?, id_article = ?, slug = ?, title_review = ?, content_review = ? WHERE id_review = ?";

    $stmt = self::$connection->prepare($request);

    $id_user = $review->user_id;
    $id_article = $review->article_id;
    $slug = $review->slug;
    $title = $review->title;
    $content = $review->content;
    $id = $review->id;

    $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
    $stmt->bindParam(2, $id_article, PDO::PARAM_INT);
    $stmt->bindParam(3, $slug, PDO::PARAM_STR);
    $stmt->bindParam(4, $title, PDO::PARAM_STR);
    $stmt->bindParam(5, $content, PDO::PARAM_STR);
    $stmt->bindParam(6, $id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("REVIEWDAO.update failed: " . $e->getMessage());
    }

    return $this->findById($review->id);
  }

  // Supprime un commentaire de la BDD
  public function delete(Review $review)
  {
    $request = "DELETE FROM reviews WHERE id_review = :id";

    $review_id = $review->id;

    $stmt = self::$connection->prepare($request);
    $stmt->bindParam(":id", $review_id, PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Error("REVIEWDAO.delete failed: " . $e->getMessage());
    }
  }
}
