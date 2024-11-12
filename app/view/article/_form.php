<form action="<?php echo $action ?>" method="POST">

  <?php include "./app/view/component/_session.php" ?>

  <label for="title">Titre</label>
  <input
    type="text"
    id="title"
    name="title"
    value="<?php echo isset($_SESSION["form_data"]["title"]) ? htmlspecialchars($_SESSION["form_data"]["title"]) : ""; ?>">
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
    style="height: 300px; ">
  <?php echo isset($_SESSION["form_data"]["content"]) ? htmlspecialchars($_SESSION["form_data"]["content"]) : ""; ?>
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
  <button type="submit"><?php echo $submit ?></button>
</form>

<?php
unset($_SESSION["form_data"]);
?>
