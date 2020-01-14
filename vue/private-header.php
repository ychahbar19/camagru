<header>
  <nav class="private_nav">
    <div class="logo-link--div">
        <a href="./index.php" class="logo-link">
          <img src="./public/images/camagru-logo.png" alt="logo camagru" width="75" height="75" id="logo">
        </a>
    </div>
    <div class="nav-wrapper">
      <ul class="right hide-on-med-and-down">
        <!-- NO NEED OF THAT, changement de structure pour les settings ! -->
          <?php //if (isset($_GET['action']) && $_GET['action'] == 'profile') echo '<li><a href='.'"./index.php?action=edit-profile"'.'"><i class="'.'large material-icons'.'">edit</i></a></li>';?>
          <li><a href="./index.php?action=new_picture"><i class="large material-icons">add_a_photo</i></a></li>
          <li><a href="#"><i class="material-icons">notifications</i></a></li>
          <li><a href="./index.php?action=profile"><i class="material-icons">account_circle</i></a></li>
          <li><a href="./index.php?action=settings"><i class="material-icons">settings</i></a></li>
          <li><a href="./vue/deconnexion.php"><i class="material-icons">power_settings_new</i></a></li>
      </ul>
    </div>
  </nav>
</header>
