<?php

namespace Application\test;

use Application\dao\ArticleDao;
use Application\model\Article;
use Application\model\User;

use Error;

class ArticleTest
{
  private User $user;
  private array $articles;
  private ArticleDao $articleDao;

  public function __construct(User $user)
  {
    $this->articleDao = ArticleDao::getInstance();
    $this->articleDao->clean();

    $this->user = $user;

    $this->articles = [
      new Article(0, $this->user->id, "tech-innovation", "tech innovation", "aliqua ad aute officia", "Anim culpa quis culpa. Elit eu labore nostrud cupidatat sunt laboris consectetur reprehenderit ullamco. Nisi anim culpa ipsum nostrud non dolor nisi adipisicing adipisicing eiusmod aliqua."),
      new Article(0, $this->user->id, "wich-list", "wich list", "Consectetur ipsum culpa voluptate. Est non sit enim eu veniam cillum incididunt et officia cillum anim velit velit amet. Nisi esse consectetur incididunt ullamco deserunt commodo aliqua culpa deserunt."),
      new Article(0, $this->user->id, "video-games", "video games", "Sit deserunt sunt dolore ipsum cillum veniam aliqua sunt culpa incididunt Lorem consectetur occaecat aliquip. Velit anim irure ullamco enim eiusmod aute excepteur proident eu elit aute. Cupidatat reprehenderit enim excepteur non culpa fugiat quis labore incididunt reprehenderit nisi adipisicing laborum."),
    ];

    foreach ($this->articles as $article) {
      $this->articleDao->create($article);
    }
  }

  private function testGetAll()
  {
    $result = $this->articleDao->getAll();

    // Vérification de la taille du résultat
    assert(
      sizeof($result) == 3,
      new Error("ArticleTest.testGetAll failed: the size of the result is " . sizeof($result) . " but it should be 3")
    );

    // Met à jour l'ID de l'article dans le tableau
    foreach ($result as $index => $article) {
      $this->articles[$index]->id = $article->id;
    }

    echo "ArticleTest.testGetAll OK";
  }

  private function testFindById()
  {
    $article = $this->articles[0];
    $result = $this->articleDao->findById($article->id);

    assert(
      $result == $article,
      new Error("ArticleTest.testFindById failed: the recovered article is" . $result . " but it should be " . $article)
    );

    echo "ArticleTest.testFindById OK";
  }

  private function testFindBySlug()
  {
    $article = $this->articles[2];
    $result = $this->articleDao->findBySlug($article->slug);

    assert(
      $result == $article,
      new Error("ArticleTest.testFindBySlug failed: the recovered article is " . $result . " but it should be " . $article)
    );

    echo "ArticleTest.testFindBySlug OK";
  }


  private function testCreate()
  {
    $article = new Article(0, $this->user->id, "php-unit-test", "PHP Unit Test", "Occaecat id qui excepteur laboris. Occaecat mollit dolore qui in quis eu fugiat nulla tempor fugiat.");
    $result = $this->articleDao->create($article);

    // Met à jour l'ID de l'article dans le tableau
    $article->id = $result->id;

    $this->articles[] = $article;

    assert(
      $result == $article,
      new Error("ArticleTest.testCreate failed: the create article is " . $result . " but it should be " . $article)
    );

    echo "ArticleTest.testCreate OK";
  }

  private function testUpdate()
  {
    $article = $this->articles[2];
    $article->slug = "new-slug";

    $result = $this->articleDao->update($article);

    assert(
      $result->slug == $article->slug,
      new Error("ArticleTest.testUpdate failed: the updated article slug is " . $result->slug . " but it should be " . $article->slug)
    );


    echo "ArticleTest.testUpdate OK";
  }

  private function testDelete()
  {
    $article = $this->articles[3];

    $old_size = sizeof($this->articleDao->getAll());
    $this->articleDao->delete($article->id);

    $new_size = sizeof($this->articleDao->getAll());

    assert(
      $old_size - 1 == $new_size,
      new Error("ArticleTest.testDekete failed: the size of the result is " . $new_size . " but it should be " . $old_size - 1)
    );

    echo "ArticleTest.testDelete OK";
  }

  public function run()
  {
    $this->testGetAll();

    echo "<br>";

    $this->testFindById();

    echo "<br>";

    $this->testFindBySlug();

    echo "<br>";

    $this->testCreate();

    echo "<br>";

    $this->testUpdate();

    echo "<br>";

    $this->testDelete();

    echo "<p>";

    echo "ArticleTest OK";
  }
}
