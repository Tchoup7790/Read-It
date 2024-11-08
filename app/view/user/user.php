<!docype html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>user page readit</title>
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
      </nav>
      <?php include "./app/view/_session.php" ?>
    </header>
    <main class="container">
      <div style="width: 50vw;">
        <div style="display: flex; justify-content: space-between;padding-bottom: 30px;">
          <h1>Articles</h1>
          <a href="/article/new">
            <button class="outline">Création d'un nouvel article</button>
          </a>
        </div>
        <?php foreach ($articles as $article): ?>
          <article>
            <h2><i><?php echo $article->title ?><i /></h2>
            <p><?php echo $article->content ?></p>
            <footer>
              <small>
                <a href=<?php echo "/article/update/" . $article->slug ?>>modification</a>
              </small>
            </footer>
          </article>
        <?php endforeach; ?>
      </div>
      <aside>
        <article style="width: 30vw; position: absolute; top: 150px; right: 100px;">
          <h2>Informations</h2>
          <p><strong><?php echo $user->name . " - " . $user->alias ?></strong></p>
          <p><strong>Description</strong></p>
          <p><?php echo $user->description ? $user->description : "<em>pas de description</em>" ?></p>
          <p>Email: <strong><?php echo $user->email ?></strong></p>
          <a href=<?php echo "/user/update/" . $user->alias ?>>modification du compte</a>
          <br>
          <a href=<?php echo "/user/logout" ?>>déconnection</a>
        </article>
      </aside>
    </main>
  </body>

  </html>
