<?php

namespace Application\controller;

use Application\dao\ArticleDao;

class ArticleController
{
  private ArticleDao $articleDao;

  public function __construct()
  {
    $this->articleDao = ArticleDao::getInstance();
  }

  public function index()
  {
    extract(["articles" => $this->articleDao->getAll()]);
    include "./app/view/article/index.php";
  }
}
