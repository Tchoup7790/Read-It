<?php

namespace Application\test;

use Application\dao\UserDao;
use Application\dao\ArticleDao;

use Application\test\dao\UserDaoTest;
use Application\test\dao\ArticleDaoTest;
use Application\test\dao\ReviewDaoTest;


class TestDao
{
  public static function run()
  {
    echo "<em>TEST DAO</em>";

    echo "<p>";

    $userDao = UserDao::getInstance();
    $articleDao = ArticleDao::getInstance();


    $testUserDao = new UserDaoTest();
    $testUserDao->run();

    echo "<p>";

    $users = $userDao->getAll();
    $user = $users[0];

    $testArticleDao = new ArticleDaoTest($user);
    $testArticleDao->run();

    echo "<p>";

    $articles = $articleDao->getAll();
    $article = $articles[0];

    $testReviewDao = new ReviewDaoTest($user, $article);
    $testReviewDao->run();
  }
}
