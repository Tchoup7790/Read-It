<?php

namespace Application\model;

class User
{
  public int $id;
  public string $password_hash;
  public string $alias;
  public ?string $description = null;
  public string $email;
  public string $name;


  public function __construct(
    int $id,
    string $password,
    string $alias,
    string $email,
    string $name,
    ?string $description = null,
  ) {
    $this->id = $id;
    $this->password_hash = $password;
    $this->alias = $alias;
    $this->email = $email;
    $this->name = $name;

    if (!is_null($description)) {
      $this->description = $description;
    }
  }

  public function __toString(): string
  {
    return sprintf(
      "User: [ID: %s, Password: %s, Alias: %s, Description: %s, Name: %s, Email: %s]",
      $this->id,
      $this->password_hash,
      $this->alias,
      $this->description ?? 'N/A',
      $this->name,
      $this->email
    );
  }
}
