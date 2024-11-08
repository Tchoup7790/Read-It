<?php

namespace Application\verificator;

use Application\dao\UserDao;

use Error;

class UserVerificator
{
  private UserDao $userDao;

  public function __construct()
  {
    $this->userDao = UserDao::getInstance();
  }

  public function verifAuthentificate(): ?array
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // check email
      if ($_POST["email"] == "") {
        return ["-email", "Veuilliez rentrer une valeur pour le mail"];
      } else {
        $email = $_POST["email"];
        try {
          $this->userDao->findByEmail($email);
        } catch (Error) {
          return ["-email", "Cet email n'est lié à aucun compte"];
        }
      }

      // check password
      if ($_POST["password"] == "") {
        return ["-password", "Veuilliez entrer un mot de passe"];
      }
    }
    return null;
  }

  public function verifChange(int $id): ?array
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // check alias
      if (!$_POST["alias"] == "") {
        try {
          $user = $this->userDao->findById($id);
        } catch (Error) {
        } finally {
          if (isset($user) && $user->id != $id) {
            return ["-alias", "Ce nom est déjà utilisé, choisissez en un autre"];
          }
        }

        // check email
        if (!$_POST["email"] == "") {
          $email = $_POST["email"];
          try {
            $user = $this->userDao->findByEmail($email);
          } catch (Error) {
          } finally {
            if (isset($user) && $user->id != $id) {
              return ["-email", "Cet email est déjà lié à un compte"];
            }
          }
        }
      }
    }
    return null;
  }

  public function verifRegister(): ?array
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // check name
      if ($_POST["name"] == "") {
        return ["-name", "Veuilliez rentrer une valeur pour le nom"];
      }

      // check alias
      if ($_POST["alias"] == "") {
        return ["-alias", "Veuilliez rentrer une valeur pour le alias"];
      } else {
        $alias = $_POST["alias"];
        try {
          $user = $this->userDao->findByAlias($alias);
        } catch (Error) {
        } finally {
          if (isset($user) && !is_null($user)) {
            return ["-alias", "Ce nom est déjà utilisé, choisissez en un autre"];
          }
        }
      }

      // check email
      if ($_POST["email"] == "") {
        return ["-email", "Veuilliez rentrer une valeur pour le mail"];
      } else {
        $email = $_POST["email"];
        try {
          $user = $this->userDao->findByEmail($email);
        } catch (Error) {
        } finally {
          if (isset($user) && !is_null($user)) {
            return ["-email", "Cet email est déjà lié à un compte"];
          }
        }
      }

      // check password
      if ($_POST["password"] == "") {
        return ["-password", "Veuilliez entrer un mot de passe"];
      }
    }
    return null;
  }
}
