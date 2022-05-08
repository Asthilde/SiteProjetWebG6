<nav class="navbar  navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="../index.php"><i class="bi bi-book-half navbar-brand"></i><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-book-half" viewBox="0 0 16 16">
          <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
        </svg> Une histoire dont vous êtes le héros</a>
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