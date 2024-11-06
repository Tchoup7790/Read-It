<?php

namespace Application\controller;

use Application\dao\UserDao;
use Application\model\User;
use Application\verificator\UserVerificator;

use Error;

class AuthController
{
  private UserDao $userDao;
  private UserVerificator $verificator;

  public function __construct()
  {
    $this->userDao = UserDao::getInstance();
    $this->verificator = new UserVerificator;
  }

  public function index()
  {
    include "./app/view/user/index.php";
  }

  public function connection()
  {
    include "./app/view/user/connection.php";
  }

  public function create()
  {
    include "./app/view/user/create.php";
  }

  public function authentificate()
  {
    $verificator = $this->verificator->verifAuthentificate();
    if (!is_null($verificator)) {
      $this->returnWithError("/user/connection", $verificator[0], $verificator[1]);
    }

    $user = $this->userDao->findByEmail($_POST["email"]);

    if (password_verify($_POST["password"], $user->password_hash)) {
      $_SESSION["user"] = $user;
      header("Location: /");
    } else {
      $this->returnWithError("/user/connection", "password", "Le mot de passe n'est pas correct");
    }
  }

  public function register()
  {
    $verificator = $this->verificator->verifRegister();
    if (!is_null($verificator)) {
      $this->returnWithError("/user/create", $verificator[0], $verificator[1]);
    }

    $new_user = new User(
      0,
      $_POST["password"],
      $_POST["alias"],
      $_POST["email"],
      $_POST["name"],
    );

    try {
      $this->userDao->create($new_user);
      $_SESSION["message"] = "Utilisateur créé avec succès.";
      header("Location: /user/connection");
      exit();
    } catch (Error $e) {
      $this->returnWithError("/user/create", "unknown", "Unknown Error : " . $e->getMessage());
    }
  }

  private function returnWithError(string $location, string $errorName, string $errorMessage)
  {
    $_SESSION["error"] = "Erreur lors de la création. <br>";
    $_SESSION["error-" . $errorName] = $errorMessage;
    $_SESSION['form_data'] = $_POST;
    header("Location:" . $location);
    exit();
  }
}
