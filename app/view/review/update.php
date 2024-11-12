<!DOCYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <title>Modification du commentaire <?php echo $review->slug ?></title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
  </head>

  <body>
    <?php include "./app/view/component/_header.php" ?>
    <main class="container">
      <h2>Modification d'un commentaire</h2>
      <?php include "./app/view/article/_form.php" ?>
    </main>
  </body>
