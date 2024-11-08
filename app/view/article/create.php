<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>Create Article</title>
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
    </header>
    <main class="container">
      <h2>Création d'un article</h2>
      <form action="/article/register" method="POST">

        <?php include "./app/view/_session.php" ?>

        <label for="title">Titre</label>
        <input
          type="text"
          id="title"
          name="title"
          value="<?php echo isset($_SESSION['form_data']['title']) ? htmlspecialchars($_SESSION['form_data']['title']) : ''; ?>">
        <small>
          <?php if (isset($_SESSION["error-title"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-title"];
              unset($_SESSION["error-title"]) ?>
            </p>
          <?php endif; ?>
        </small>


        <label for="content">Texte</label>
        <textarea
          id="content"
          name="content"
          style="height: 300px; " />
        <?php echo isset($_SESSION['form_data']['content']) ? htmlspecialchars($_SESSION['form_data']['content']) : ''; ?>
        </textarea>
        <small>
          <?php if (isset($_SESSION["error-content"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-content"];
              unset($_SESSION["error-content"]) ?>
            </p>
          <?php endif; ?>
        </small>
        <br>
        <button type="submit">Créer l'article</button>
      </form>

      <?php
      unset($_SESSION['form_data']);
      ?>
    </main>
  </body>
