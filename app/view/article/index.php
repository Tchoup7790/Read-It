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
          <input type="search" id="search" name="search" placeholder="Chercher un article" />
        </li>
        <li>
          <a href="/user">
            <button>
              <?php
              if ($_SESSION["user"]) {
                echo "Bienvenue <strong>" . $_SESSION["user"]->name . "</strong>";
              } else {
                echo "Se Connecter";
              }
              ?>
            </button>
          </a>
        </li>
      </nav>
    </header>
    <main class="container">
      <h1>Bienvenue sur ReadIt</h1>
      <p>Ce site est un projet personnel fait en php natif avec mysql et picocss.</p>
      <?php foreach ($articles as $article): ?>
        <article>
          <h2><i><?php echo $article->title ?><i /></h2>
          <p><?php echo $article->content ?></p>
        </article>
      <?php endforeach; ?>
    </main>
  </body>

  </html>
