<?php

namespace Application\verificator;

use Application\dao\ReviewDao;
use Application\dao\UserDao;
use Error;

class ReviewVerificator
{
  private ReviewDao $reviewDao;
  private UserDao $userDao;

  public function __construct()
  {
    $this->reviewDao = ReviewDao::getInstance();
    $this->userDao = UserDao::getInstance();
  }

  public function verifUser(string $slug): bool
  {
    $user = $_SESSION["user"];
    $user = $this->userDao->findByAlias($user);

    $review = $this->reviewDao->findBySlug($slug);

    if ($user->id == $review->user_id) {
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
        $review = $this->reviewDao->findBySlug(str_replace(' ', '-', strtolower($_POST["title"])));
      } catch (Error) {
      } finally {
        if (isset($review) && $review->title == $_POST["title"]) {
          return ["-title", "Ce titre d'article est déjà utilisé"];
        }

        // check content
        if ($_POST["content"] == "") {
          return ["-content", "Veuilliez rentrer un texte"];
        }
      }
    }

    return null;
  }

  public function verifChange(): ?array
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // check title
      if ($_POST["title"] == "") {
        return ["-title", "Veuilliez rentrer une valeur pour le titre"];
      }

      // check content
      if ($_POST["content"] == "") {
        return ["-content", "Veuilliez rentrer un texte"];
      }
    }

    return null;
  }
}
