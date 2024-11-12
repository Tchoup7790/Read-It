<?php

namespace Application\controller;

use Application\dao\ArticleDao;
use Application\dao\ReviewDao;
use Application\dao\UserDao;
use Application\verificator\ArticleVerificator;
use Application\model\Article;

use Error;

class ArticleController
{
  private UserDao $userDao;
  private ReviewDao $reviewDao;

  private ArticleDao $articleDao;
  private ArticleVerificator $verificator;

  public function __construct()
  {
    $this->userDao = UserDao::getInstance();
    $this->reviewDao = ReviewDao::getInstance();
    $this->verificator = new ArticleVerificator;
    $this->articleDao = ArticleDao::getInstance();
  }

  public function home()
  {
    if (isset($_SESSION["user"])) {
      $user = $this->userDao->findByAlias($_SESSION["user"]);
      $user = $user->id;
    }
    $data = ["articles" => $this->articleDao->getAll()];
    extract($data);
    include "./app/view/home.php";
  }

  public function create()
  {
    if (!isset($_SESSION["user"])) {
      header("Location: /user");
      $_SESSION["message"] = "Connectez-vous ou créez un compte pour écrire un article";
    } else {
      $data = ["action" => "/article/register", "submit" => "Créer l'article"];
      extract($data);
      include "./app/view/article/create.php";
    }
  }

  public function update(string $slug)
  {
    $verificator = $this->verificator->verifUser($slug);
    if ($verificator) {
      $article = $this->articleDao->findBySlug($slug);
      $_SESSION["form_data"]["title"] = $article->title;
      $_SESSION["form_data"]["content"] = $article->content;
      $data = ["article" => $article, "action" => "/article/change/" . $article->slug, "submit" => "Mofifier l'article"];
      extract($data);
      include "./app/view/article/update.php";
    } else {
      header("Location: /");
    }
  }

  public function show($slug)
  {
    $article = $this->articleDao->findBySlug($slug);

    $data = [
      "article" => $article,
      "user" => $this->userDao->findById($article->user_id),
      "reviews" => $this->reviewDao->getByArticleId($article->id),
      "sessionUser" => $this->userDao->findByAlias($_SESSION["user"]),
      "users" => $this->userDao->getAll()
    ];
    extract($data);
    include "./app/view/article/show.php";
  }

  public function register()
  {
    $verificator = $this->verificator->verifRegister();
    if (!is_null($verificator)) {
      $this->returnWithError("/article/create", $verificator[0], $verificator[1]);
    }

    $user = $this->userDao->findByAlias($_SESSION["user"]);

    $new_article = new Article(0, $user->id, str_replace(' ', '-', strtolower($_POST["title"])), $_POST["title"], $_POST["content"],);

    try {
      $this->articleDao->create($new_article);
      $_SESSION["message"] = "Article créé avec succès.";
      header("Location: /article/" . $new_article->slug);
      exit();
    } catch (Error $e) {
      $this->returnWithError("/article/create", "", "Unknown Error : " . $e->getMessage());
    }
  }

  public function change(string $slug)
  {
    $verificator = $this->verificator->verifUser($slug);
    if ($verificator) {
      $article = $this->articleDao->findBySlug($slug);

      $verificator = $this->verificator->verifChange($article->id);
      if (!is_null($verificator)) {
        $this->returnWithError("/article/update/" . $article->slug, $verificator[0], $verificator[1]);
      }

      $new_article = new Article($article->id, $article->user_id, str_replace(' ', '-', strtolower($_POST["title"])), $_POST["title"], $_POST["content"]);

      try {
        $this->articleDao->update($new_article);
        $_SESSION["message"] = "Article modifié avec succès.";
        header("Location: /");
        exit();
      } catch (Error $e) {
        $this->returnWithError("/article/update/" . $article->slug, "", "Unknown Error : " . $e->getMessage());
      }
    } else {
      header("Location: /user");
    }
  }

  public function delete(string $slug)
  {
    $article = $this->articleDao->findBySlug($slug);

    try {
      $this->articleDao->delete($article->id);
    } catch (Error $e) {
      $this->returnWithError("/", "", "Unknown Error : " . $e->getMessage());
    }

    $_SESSION["message"] = "Article supprimé avec succès.";
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
