<?php

namespace Application\controller;

use Application\dao\ArticleDao;
use Application\dao\UserDao;
use Application\model\User;
use Application\verificator\UserVerificator;

use Error;

class UserController
{
  private ArticleDao $articleDao;

  private UserDao $userDao;
  private UserVerificator $verificator;

  public function __construct()
  {
    $this->articleDao = ArticleDao::getInstance();
    $this->userDao = UserDao::getInstance();
    $this->verificator = new UserVerificator;
  }

  public function index()
  {
    include "./app/view/user/index.php";
  }

  public function login()
  {
    include "./app/view/user/connection.php";
  }

  public function logout()
  {
    unset($_SESSION["user"]);
    header("Location: /");
  }

  public function create()
  {
    include "./app/view/user/create.php";
  }

  public function update($alias)
  {
    $verificator = $this->verificator->verifUser($alias);
    if ($verificator) {
      $data = ["user" => $this->userDao->findByAlias($alias)];
      extract($data);
      include "./app/view/user/update.php";
    } else {
      header("Location: /");
    }
  }

  public function show($alias)
  {
    $verificator = $this->verificator->verifUser($alias);
    if ($verificator) {
      $user = $this->userDao->findByAlias($alias);

      $data = ["articles" => $this->articleDao->getByUserId($user->id), "user" => $user];
      extract($data);
      include "./app/view/user/show.php";
    } else {
      header("Location: /");
    }
  }

  public function authentificate()
  {
    $verificator = $this->verificator->verifAuthentificate();
    if (!is_null($verificator)) {
      $this->returnWithError("/user/connection", $verificator[0], $verificator[1]);
    }

    $user = $this->userDao->findByEmail($_POST["email"]);

    if (password_verify($_POST["password"], $user->password_hash)) {
      $_SESSION["user"] = $user->alias;
      header("Location: /");
    } else {
      $this->returnWithError("/user/connection", "password", "Le mot de passe n'est pas correct");
    }
  }

  public function register()
  {
    $verificator = $this->verificator->verifRegister();
    if (!is_null($verificator)) {
      unset($_POST["password"]);
      $this->returnWithError("/user/create", $verificator[0], $verificator[1]);
    }

    $new_user = new User(0, $_POST["password"], $_POST["alias"], $_POST["email"], $_POST["name"],);

    unset($_POST["password"]);

    try {
      $this->userDao->create($new_user);
      $_SESSION["message"] = "Utilisateur créé avec succès.";
      header("Location: /user/connection");
      exit();
    } catch (Error $e) {
      $this->returnWithError("/user/create", "", "Unknown Error : " . $e->getMessage());
    }
  }

  public function change(string $alias)
  {
    $verificator = $this->verificator->verifUser($alias);
    if ($verificator) {
      $user = $this->userDao->findByAlias($alias);

      $verificator = $this->verificator->verifChange($user->id);
      if (!is_null($verificator)) {
        $this->returnWithError("/user/update/" . $user->alias, $verificator[0], $verificator[1]);
      }

      $new_user = new User($user->id, $user->password_hash, $_POST["alias"], $_POST["email"], $_POST["name"], $_POST["description"]);

      try {
        $this->userDao->update($new_user);
        $_SESSION["message"] = "Utilisateur modifié avec succès.";
        header("Location: /" . $new_user->alias);
        exit();
      } catch (Error $e) {
        $this->returnWithError("/user/update/" . $user->alias, "", "Unknown Error : " . $e->getMessage());
      }
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
