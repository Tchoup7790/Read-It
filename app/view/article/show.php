<!docype html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>Article <?php echo $article->title ?></title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
  </head>

  <body>
    <?php include "./app/view/component/_header.php" ?>
    <main class="container">
      <?php include "./app/view/component/_session.php" ?>
      <br>
      <h1><?php echo $article->title ?></h1>
      <small>
        <p>écrit par <i><?php echo $user->name ?></i></p>
      </small>
      <p><?php echo $article->content ?></p>
      <?php if (isset($_SESSION["user"]) && $_SESSION["user"] == $article->user_id): ?>
        <footer>
          <small>
            <a href=<?php echo "/article/update/" . $article->slug ?>>modification</a>
            <a href=<?php echo "/article/delete/" . $article->slug ?>>supprimer</a>
          </small>
        </footer>
      <?php endif; ?>
      <br>
      <br>
      <div style="display: flex; justify-content: space-between;padding-bottom: 10px;">
        <h2>Commentaires</h3>
          <a href="<?php echo "/article/" . $article->slug . "/create" ?>">
            <button class=" outline">Commenter l'article</button>
          </a>
      </div>
      <?php foreach ($reviews as $review): ?>
        <article>
          <h4><i><?php echo $review->title ?><i /></h4>
          <small>
            <p>écrit par <i>
                <?php
                $user = array_filter($users, fn($user) => $user->id == $review->user_id);
                $user = reset($user);
                echo $user->name;
                ?>
              </i></p>
          </small>
          <p><?php echo $review->content ?></p>
          <footer>
            <small>
              <?php if (isset($sessionUser) && $sessionUser->id == $review->user_id): ?>
                <a href=<?php echo "/review/update/" . $review->slug ?>>modification</a>
                <a href=<?php echo "/review/delete/" . $review->slug ?>>supprimer</a>
              <?php endif; ?>
            </small>
          </footer>
        </article>
      <?php endforeach; ?>
    </main>
  </body>
