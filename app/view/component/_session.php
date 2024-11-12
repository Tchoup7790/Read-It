<?php if (isset($_SESSION["message"])): ?>
  <p style="color: #63af9a;">
    <?php echo $_SESSION["message"];
    unset($_SESSION["message"]); ?>
  </p>
<?php endif; ?>

<?php if (isset($_SESSION["error"])): ?>
  <p style="color: #ce7e7b;">
    <?php echo $_SESSION["error"];
    unset($_SESSION["error"]); ?>
  </p>
<?php endif; ?>
