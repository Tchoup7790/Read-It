<?php

namespace Application\controller;

use Application\dao\ArticleDao;

class ArticleController
{
  private ArticleDao $articleDao;

  public function __construct(ArticleDao $dao)
  {
    $this->articleDao = $dao;
  }

  public function homepage()
  {
    $articles = $this->articleDao->getAll();
    require "./app/view/home.php";
  }
}
