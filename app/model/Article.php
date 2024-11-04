<?php

namespace Application\model;

class Article
{
  public int $id;
  public int $user_id;
  public string $slug;
  public string $title;
  public string $content;

  public function __construct(
    int $id,
    int $user_id,
    string $slug,
    string $title,
    string $content
  ) {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->slug = $slug;
    $this->title = $title;
    $this->content = $content;
  }

  public function __toString(): string
  {
    return sprintf(
      "Article: [ID: %s, User: %s, Slug: %s, Title: %s, Content: %s]",
      $this->id,
      $this->user_id,
      $this->slug,
      $this->title,
      $this->content,
    );
  }
}
