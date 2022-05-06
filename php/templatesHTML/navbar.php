<nav class="navbar navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../index.php"><span class="glyphicon glyphicon-book"></span> Une histoire dont vous êtes le héros</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-target">
      <?php if (isset($_SESSION['admin']) &&  $_SESSION['admin'] == 1) { ?>
        <ul class="nav navbar-nav">
          <li><a href="ajout_hist.php">Ajouter une histoire</a></li>
        </ul>
      <?php } ?>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user"></span>
            <?php if (isset($_SESSION['login'])) {
              echo "Bienvenue, " . $_SESSION['login'];
            } else {
              echo "Non connecté";
            } ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <?php if (isset($_SESSION['login'])) { ?>
              <li><a href="deconnexion.php">Se déconnecter</a></li>
            <?php } else { ?>
              <li><a href="connexion.php">Se connecter</a></li>
              <li><a href="creation_compte.php">Se créer un compte</a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>