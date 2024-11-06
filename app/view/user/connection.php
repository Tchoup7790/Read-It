<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>User Page ReadIt</title>
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
      <?php include "./app/view/_session.php" ?>

      <form action="/user/authentificate" method="post">

        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>">
        <small>
          <?php if (isset($_SESSION["error-email"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-email"];
              unset($_SESSION["error-email"]) ?>
            </p>
          <?php endif; ?>
        </small>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <small>
          <?php if (isset($_SESSION["error-password"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-password"];
              unset($_SESSION["error-password"]) ?>
            </p>
          <?php endif; ?>
        </small>

        <button type="submit">Se Connecter</button>
      </form>
    </main>
  </body>

  </html>
