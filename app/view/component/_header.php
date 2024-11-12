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
</header>
