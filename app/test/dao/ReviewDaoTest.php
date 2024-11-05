<?php

namespace Application\test\dao;

use Application\dao\ReviewDao;
use Application\model\Review;
use Application\model\User;
use Application\model\Article;

use Error;

class ReviewDaoTest
{
  private $user;
  private $article;
  private $reviews;
  private $reviewDao;

  public function __construct(User $user, Article $article)
  {
    $this->reviewDao = ReviewDao::getInstance();
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
      new Error("ReviewDaoTest.testGetAll failed: the size of the result is " . sizeof($result) . " but it should be 3")
    );

    // Met à jour l'ID du commentaire dans le tableau
    foreach ($result as $index => $review) {
      $this->reviews[$index]->id = $review->id;
    }

    echo "ReviewDaoTest.testGetAll OK";
  }

  private function testFindById()
  {
    $review = $this->reviews[0];
    $result = $this->reviewDao->findById($review->id);

    assert(
      $result == $review,
      new Error("ReviewDaoTest.testFindById failed: the recovered review is" . $result . " but it should be " . $review)
    );

    echo "ReviewDaoTest.testFindById OK";
  }

  private function testFindBySlug()
  {
    $review = $this->reviews[2];
    $result = $this->reviewDao->findBySlug($review->slug);

    assert(
      $result == $review,
      new Error("ReviewDaoTest.testFindBySlug failed: the recovered review is " . $result . " but it should be " . $review)
    );

    echo "ReviewDaoTest.testFindBySlug OK";
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
      new Error("ReviewDaoTest.testCreate failed: the create review is " . $result . " but it should be " . $review)
    );

    echo "ReviewDaoTest.testCreate OK";
  }

  private function testUpdate()
  {
    $review = $this->reviews[2];
    $review->slug = "new-slug";

    $result = $this->reviewDao->update($review);

    assert(
      $result->slug == $review->slug,
      new Error("ReviewDaoTest.testUpdate failed: the updated review slug is " . $result->slug . " but it should be " . $review->slug)
    );


    echo "ReviewDaoTest.testUpdate OK";
  }

  private function testDelete()
  {
    $review = $this->reviews[3];

    $old_size = sizeof($this->reviewDao->getAll());
    $this->reviewDao->delete($review);

    $new_size = sizeof($this->reviewDao->getAll());

    assert(
      $old_size - 1 == $new_size,
      new Error("ReviewDaoTest.testDekete failed: the size of the result is " . $new_size . " but it should be " . $old_size - 1)
    );

    echo "ReviewDaoTest.testDelete OK";
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

    echo "ReviewDaoTest OK";
  }
}
