<?php

class User
{
  public ?string $alias = null;
  public ?string $description = null;
  private string $email;
  private string $name;
  private string $password_hash;

  public function __construct(string $email, string $name, string $password, ?string $alias = null, ?string $description = null)
  {
    $this->email = $email;
    $this->name = $name;
    $this->password_hash = password_hash($password, PASSWORD_DEFAULT);

    if (!is_null($alias)) {
      $this->alias = $alias;
    }

    if (!is_null($description)) {
      $this->description = $description;
    }
  }

  public function setAlias(string $alias)
  {
    $this->alias = $alias;
  }

  public function setDescription(string $description)
  {
    $this->description = $description;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;
  }

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getPasswordHash(): string
  {
    return $this->password_hash;
  }

  public function __toString(): string
  {
    return sprintf(
      "User: [Name: %s, Email: %s, Alias: %s, Description: %s]",
      $this->name,
      $this->email,
      $this->alias ?? 'N/A',
      $this->description ?? 'N/A'
    );
  }
}
