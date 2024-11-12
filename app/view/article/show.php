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
      <div style="display: flex; justify-content: space-between;padding-bottom: 50px;">
        <h1>Articles</h1>
        <a href="/review/create">
          <button class=" outline">Commenter l'article</button>
        </a>
      </div>
      <h2><i><?php echo $article->title ?><i /></h2>
      <p><?php echo $article->content ?></p>
      <?php if (isset($_SESSION["user"]) && $_SESSION["user"] == $article->user_id): ?>
        <footer>
          <small>
            <a href=<?php echo "/article/update/" . $article->slug ?>>modification</a>
            <a href=<?php echo "/article/delete/" . $article->slug ?>>supprimer</a>
          </small>
        </footer>
      <?php endif; ?>
    </main>
  </body>
