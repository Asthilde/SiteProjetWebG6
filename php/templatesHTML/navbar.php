<nav class="navbar  navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="../index.php"><img src="../images/bootstrapNEPASTOUCHER/book-half.svg" alt="petit livre"></img> Une histoire dont vous êtes le héros</a>
    </div>
    <div>
      <?php if (isset($_SESSION['admin']) &&  $_SESSION['admin'] == 1) { ?>
        <a href="php/ajout_hist.php">Ajouter une histoire</a>
    </div>

  <?php } ?>
  <div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php if (isset($_SESSION['login'])) {
        echo "Bienvenue, " . $_SESSION['login'];
      } else {
        echo "Non connecté";
      } ?> </a>
    </a>
    <div class="dropdown-menu">
      <?php if (isset($_SESSION['login'])) { ?>
        <a class="dropdown-item" href="../php/deconnexion.php">Se déconnecter</a>
      <?php } else { ?>
        <a class="dropdown-item" href="../php/connexion.php">Se connecter</a>
        <a class="dropdown-item" href="../php/creation_compte.php">Se créer un compte</a>
      <?php } ?>
    </div>
  </div>
  </div>


  </div>
</nav>