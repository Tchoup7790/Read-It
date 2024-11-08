<?php

namespace Application\verificator;

use Application\dao\ArticleDao;
use Application\dao\UserDao;
use Error;

class ArticleVerificator
{
  private ArticleDao $articleDao;
  private UserDao $userDao;

  public function __construct()
  {
    $this->articleDao = ArticleDao::getInstance();
    $this->userDao = UserDao::getInstance();
  }

  public function verifUser(string $slug): bool
  {
    $user = $_SESSION["user"];
    $user = $this->userDao->findByAlias($user);

    $article = $this->articleDao->findBySlug($slug);

    if ($user->id == $article->user_id) {
      return true;
    } else {
      return false;
    }
  }

  public function verifRegister(): ?array
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // check title
      if ($_POST["title"] == "") {
        return ["-title", "Veuilliez rentrer une valeur pour le titre"];
      }
      try {
        $article = $this->articleDao->findBySlug(str_replace(' ', '-', strtolower($_POST["title"])));
      } catch (Error) {
      } finally {
        if (isset($article) && $article->title == $_POST["title"]) {
          return ["-title", "Ce titre d'article est déjà utilisé"];
        }
      }
    }

    return null;
  }

  public function verifChange(): ?array
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // check title
      if ($_POST["title"] != "") {
        try {
          $article = $this->articleDao->findBySlug(str_replace(' ', '-', strtolower($_POST["title"])));
        } catch (Error) {
        } finally {
          if (isset($article) && !is_null($article)) {
            return ["-title", "Ce titre d'article est déjà utilisé"];
          }
        }
      }
    }

    return null;
  }
}
