<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>HomePage ReadIt</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
  </head>

  <body>
    <header class="container">
      <nav>
        <li>
          <h2>
            <a href="/">Read It</a>
          </h2>
        </li>
        <li>
          <input type="search" id="search" name="search" placeholder="Chercher un article" disabled />
        </li>
        <li>
          <?php
          if (isset($_SESSION["user"])) {
            echo "<a href='/" . $_SESSION["user"] . "'>";
          } else {
            echo "<a href='/user'>";
          }
          ?>
          <button>
            <?php
            if (isset($_SESSION["user"])) {
              echo "Bienvenue <strong>" . $_SESSION["user"] . "</strong>";
            } else {
              echo "Se Connecter";
            }
            ?>
          </button>
          <?php echo "</a>"; ?>
        </li>
      </nav>
      <?php include "./app/view/_session.php" ?>
    </header>
    <main class="container">
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
          <?php if (isset($user) && $article->user_id == $user): ?>
            <footer>
              <small>
                <a href=<?php echo "/article/update/" . $article->slug ?>>modification</a>
                <a href=<?php echo "/article/delete/" . $article->slug ?>>supprimer</a>
              </small>
            </footer>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </main>
  </body>

  </html>
