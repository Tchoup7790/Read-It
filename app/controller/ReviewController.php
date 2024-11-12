<?php

namespace Application\controller;

use Application\dao\ReviewDao;
use Application\dao\ArticleDao;
use Application\dao\UserDao;
use Application\verificator\ReviewVerificator;
use Application\model\Review;

use Error;

class ReviewController
{
  private UserDao $userDao;
  private ArticleDao $articleDao;

  private ReviewDao $reviewDao;
  private ReviewVerificator $verificator;

  public function __construct()
  {
    $this->userDao = UserDao::getInstance();
    $this->articleDao = ArticleDao::getInstance();
    $this->verificator = new ReviewVerificator;
    $this->reviewDao = ReviewDao::getInstance();
  }

  public function create(string $article)
  {
    if (!isset($_SESSION["user"])) {
      header("Location: /user");
      $_SESSION["message"] = "Connectez-vous ou créez un compte pour écrire un commentaire";
    } else {
      $data = ["action" => "/review/" . $article . "/register", "submit" => "Créer le commentaire", "slug_article" => $article];
      extract($data);
      include "./app/view/review/create.php";
    }
  }

  public function update(string $slug)
  {
    $verificator = $this->verificator->verifUser($slug);
    if ($verificator) {
      $review = $this->reviewDao->findBySlug($slug);
      $_SESSION["form_data"]["title"] = $review->title;
      $_SESSION["form_data"]["content"] = $review->content;
      $_SESSION["form_data"]["article_id"] = $review->article_id;
      $data = ["review" => $review, "action" => "/review/change/" . $review->slug, "submit" => "Mofifier le commentaire"];
      extract($data);
      include "./app/view/review/update.php";
    } else {
      header("Location: /");
    }
  }

  public function register(string $article_slug)
  {
    $verificator = $this->verificator->verifRegister();
    if (!is_null($verificator)) {
      $this->returnWithError("/article/" . $article_slug . "/create", $verificator[0], $verificator[1]);
    }

    $user = $this->userDao->findByAlias($_SESSION["user"]);
    $article = $this->articleDao->findBySlug($article_slug);

    $new_review = new Review(0,  $user->id, $article->id, str_replace(' ', '-', strtolower($_POST["title"])), $_POST["title"], $_POST["content"],);

    try {
      $this->reviewDao->create($new_review);
      $_SESSION["message"] = "Commentaire créé avec succès.";
      header("Location: /article/" . $article->slug);
      exit();
    } catch (Error $e) {
      $this->returnWithError("/article/" . $article_slug . "/create", "", "Unknown Error : " . $e->getMessage());
    }
  }

  public function change(string $slug)
  {
    $verificator = $this->verificator->verifUser($slug);
    if ($verificator) {
      $review = $this->reviewDao->findBySlug($slug);

      $verificator = $this->verificator->verifChange($review->id);
      if (!is_null($verificator)) {
        $this->returnWithError("/review/update/" . $review->slug, $verificator[0], $verificator[1]);
      }

      $new_review = new Review($review->id, $review->user_id, $review->article_id, str_replace(' ', '-', strtolower($_POST["title"])), $_POST["title"], $_POST["content"]);
      $article = $this->articleDao->findById($review->article_id);

      try {
        $this->reviewDao->update($new_review);
        $_SESSION["message"] = "Commentaire modifié avec succès.";
        header("Location: /article/" . $article->slug);
        exit();
      } catch (Error $e) {
        $this->returnWithError("/review/update/" . $review->slug, "", "Unknown Error : " . $e->getMessage());
      }
    } else {
      $review = $this->reviewDao->findBySlug($slug);
      $article = $this->articleDao->findById($review->article_id);
      header("Location: /article/" . $article->slug);
    }
  }

  public function delete(string $slug)
  {
    $review = $this->reviewDao->findBySlug($slug);
    $article = $this->articleDao->findById($review->article_id);

    try {
      $this->reviewDao->delete($review->id);
    } catch (Error $e) {
      $this->returnWithError("/", "", "Unknown Error : " . $e->getMessage());
    }

    $_SESSION["message"] = "Commentaire supprimé avec succès.";
    if (isset($_SERVER['HTTP_REFERER'])) {
      $lastUrl = $_SERVER['HTTP_REFERER'];
      header("Location: $lastUrl");
    } else {
      header("location: /");
    }
  }

  private function returnWithError(string $location, string $errorName, string $errorMessage)
  {
    $_SESSION["error" . $errorName] = $errorMessage;
    $_SESSION['form_data'] = $_POST;
    header("Location:" . $location);
    exit();
  }
}
