<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>Modification du compte <?php $user->alias ?></title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
  </head>

  <body>
    <?php include "./app/view/component/_simple-header.php" ?>
    <main class="container">
      <h2>Modification de votre compte</h2>
      <form action=<?php echo "/user/change/" . $user->alias ?> method="POST">

        <?php include "./app/view/component/_session.php" ?>

        <label for="name">Nom</label>
        <input
          type="text"
          id="name"
          name="name"
          value="<?php echo $user->name; ?>">
        <small>
          <?php if (isset($_SESSION["error-name"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-name"];
              unset($_SESSION["error-name"]) ?>
            </p>
          <?php endif; ?>
        </small>


        <label for="alias">Pseudo</label>
        <input
          type="text"
          id="alias"
          name="alias"
          value="<?php echo $user->alias; ?>">
        <small>
          <?php if (isset($_SESSION["error-alias"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-alias"];
              unset($_SESSION["error-alias"]) ?>
            </p>
          <?php endif; ?>
        </small>

        <label for="description">Description</label>
        <input
          type="text"
          id="description"
          name="description"
          value="<?php echo $user->description; ?>">
        <small>
          <?php if (isset($_SESSION["error-description"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-description"];
              unset($_SESSION["error-description"]) ?>
            </p>
          <?php endif; ?>
        </small>

        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?php echo $user->email; ?>">
        <small>
          <?php if (isset($_SESSION["error-email"])): ?>
            <p style="color: #ce7e7b;">
              <?php echo $_SESSION["error-email"];
              unset($_SESSION["error-email"]) ?>
            </p>
          <?php endif; ?>
        </small>
        <button type="submit">Modifier</button>
      </form>

      <?php
      unset($_SESSION['form_data']);
      ?>
    </main>
  </body>

  </html>
