<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>Page Utilisateur</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
  </head>

  <body>
    <?php include "./app/view/component/_simple-header.php" ?>
    <main class="container">
      <?php include "./app/view/component/_session.php" ?>
      <div class="grid" style="justify-content: center;align-items: center;display: flex;height: 50%;">
        <a href="/user/create">
          <button class="outline">Créer un compte</button>
        </a>
        <a href="/user/login">
          <button>Se Connecter</button>
        </a>
      </div>
    </main>
  </body>

  </html>
