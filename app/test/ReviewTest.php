<?php

namespace Application\test;

use Application\dao\ReviewDao;
use Application\model\Review;
use Application\model\User;
use Application\model\Article;

use Error;
use PDO;

class ReviewTest
{
  private $user;
  private $article;
  private $reviews;
  private $reviewDao;

  public function __construct(PDO $db_connection, User $user, Article $article)
  {
    $this->reviewDao = new ReviewDao($db_connection);
    $this->reviewDao->clean();

    $this->user = $user;
    $this->article = $article;

    $this->reviews = [
      new Review(0, $this->user->id, $this->article->id, "tech-innovation-review", "tech innovation review", "aliqua ad aute officia", "Anim culpa quis culpa. Elit eu labore nostrud cupidatat sunt laboris consectetur reprehenderit ullamco. Nisi anim culpa ipsum nostrud non dolor nisi adipisicing adipisicing eiusmod aliqua."),
      new Review(0, $this->user->id, $this->article->id, "wich-list-review", "wich list review", "Consectetur ipsum culpa voluptate. Est non sit enim eu veniam cillum incididunt et officia cillum anim velit velit amet. Nisi esse consectetur incididunt ullamco deserunt commodo aliqua culpa deserunt."),
      new Review(0, $this->user->id, $this->article->id, "video-games-review", "video games review", "Sit deserunt sunt dolore ipsum cillum veniam aliqua sunt culpa incididunt Lorem consectetur occaecat aliquip. Velit anim irure ullamco enim eiusmod aute excepteur proident eu elit aute. Cupidatat reprehenderit enim excepteur non culpa fugiat quis labore incididunt reprehenderit nisi adipisicing laborum."),
    ];

    foreach ($this->reviews as $review) {
      $this->reviewDao->create($review);
    }
  }

  private function testGetAll()
  {
    $result = $this->reviewDao->getAll();

    // Vérification de la taille du résultat
    assert(
      sizeof($result) == 3,
      new Error("ReviewTest.testGetAll failed: the size of the result is " . sizeof($result) . " but it should be 3")
    );

    // Met à jour l'ID du commentaire dans le tableau
    foreach ($result as $index => $review) {
      $this->reviews[$index]->id = $review->id;
    }

    echo "ReviewTest.testGetAll OK";
  }

  private function testFindById()
  {
    $review = $this->reviews[0];
    $result = $this->reviewDao->findById($review->id);

    assert(
      $result == $review,
      new Error("ReviewTest.testFindById failed: the recovered review is" . $result . " but it should be " . $review)
    );

    echo "ReviewTest.testFindById OK";
  }

  private function testFindBySlug()
  {
    $review = $this->reviews[2];
    $result = $this->reviewDao->findBySlug($review->slug);

    assert(
      $result == $review,
      new Error("ReviewTest.testFindBySlug failed: the recovered review is " . $result . " but it should be " . $review)
    );

    echo "ReviewTest.testFindBySlug OK";
  }


  private function testCreate()
  {
    $review = new Review(0, $this->user->id, $this->article->id, "php-unit-test", "PHP Unit Test", "Occaecat id qui excepteur laboris. Occaecat mollit dolore qui in quis eu fugiat nulla tempor fugiat.");
    $result = $this->reviewDao->create($review);

    // Met à jour l'ID du commentaire dans le tableau
    $review->id = $result->id;

    $this->reviews[] = $review;

    assert(
      $result == $review,
      new Error("ReviewTest.testCreate failed: the create review is " . $result . " but it should be " . $review)
    );

    echo "ReviewTest.testCreate OK";
  }

  private function testUpdate()
  {
    $review = $this->reviews[2];
    $review->slug = "new-slug";

    $result = $this->reviewDao->update($review);

    assert(
      $result->slug == $review->slug,
      new Error("ReviewTest.testUpdate failed: the updated review slug is " . $result->slug . " but it should be " . $review->slug)
    );


    echo "ReviewTest.testUpdate OK";
  }

  private function testDelete()
  {
    $review = $this->reviews[3];

    $old_size = sizeof($this->reviewDao->getAll());
    $this->reviewDao->delete($review);

    $new_size = sizeof($this->reviewDao->getAll());

    assert(
      $old_size - 1 == $new_size,
      new Error("ReviewTest.testDekete failed: the size of the result is " . $new_size . " but it should be " . $old_size - 1)
    );

    echo "ReviewTest.testDelete OK";
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

    echo "ReviewTest OK";
  }
}
