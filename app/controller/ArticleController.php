<?php

namespace Application\controller;

use Application\dao\ArticleDao;
use Application\dao\UserDao;
use Application\verificator\ArticleVerificator;
use Application\model\Article;

use Error;

class ArticleController
{
  private UserDao $userDao;

  private ArticleDao $articleDao;
  private ArticleVerificator $verificator;

  public function __construct()
  {
    $this->userDao = UserDao::getInstance();
    $this->verificator = new ArticleVerificator;
    $this->articleDao = ArticleDao::getInstance();
  }

  public function index()
  {
    if (isset($_SESSION["user"])) {
      $user = $this->userDao->findByAlias($_SESSION["user"]);
      $user = $user->id;
    }
    $articles = $this->articleDao->getAll();
    include "./app/view/article/index.php";
  }

  public function create()
  {
    if (!isset($_SESSION["user"])) {
      header("Location: /user/");
    } else {
      include "./app/view/article/create.php";
    }
  }

  public function update(string $slug)
  {
    $verificator = $this->verificator->verifUser($slug);
    if ($verificator) {
      $article = $this->articleDao->findBySlug($slug);
      include "./app/view/article/update.php";
    } else {
      header("Location: /");
    }
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
      header("Location: /" . $user->alias);
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

      $new_article = new Article($article->id, $article->id, str_replace(' ', '-', strtolower($_POST["title"])), $_POST["title"], $_POST["content"]);

      try {
        $this->articleDao->update($new_article);
        $_SESSION["message"] = "Article modifié avec succès.";
        header("Location: /");
        exit();
      } catch (Error $e) {
        $this->returnWithError("/article/update/" . $article->slug, "", "Unknown Error : " . $e->getMessage());
      }
    } else {
      header("location: /");
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
    header("location: /");
  }

  private function returnWithError(string $location, string $errorName, string $errorMessage)
  {
    $_SESSION["error" . $errorName] = $errorMessage;
    $_SESSION['form_data'] = $_POST;
    header("Location:" . $location);
    exit();
  }
}
