<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>Acceuil ReadIt</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
  </head>

  <body>
    <?php include "./app/view/component/_header.php" ?>
    <main class="container">
      <?php include "./app/view/component/_session.php" ?>
      <div style="display: flex; justify-content: space-between;padding-bottom: 30px;">
        <div>
          <h1>Bienvenue sur ReadIt</h1>
          <p>Ce site est un projet personnel fait en php natif avec mysql et picocss.</p>
        </div>
        <a href="/article/create">
          <button class="outline">Création d'un nouvel article</button>
        </a>
      </div>
      <?php foreach ($articles as $article): ?>
        <article>
          <h2><i><?php echo $article->title ?><i /></h2>
          <p><?php echo $article->content ?></p>
          <footer>
            <small>
              <a href=<?php echo "/article/" . $article->slug ?>>voir l'article</a>
              <?php if (isset($user) && $article->user_id == $user): ?>
                <br>
                <br>
                <a href=<?php echo "/article/update/" . $article->slug ?>>modification</a>
                <a href=<?php echo "/article/delete/" . $article->slug ?>>supprimer</a>
              <?php endif; ?>
            </small>
          </footer>
        </article>
      <?php endforeach; ?>
    </main>
  </body>

  </html>
