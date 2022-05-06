<?php
session_start();
require_once 'php/connect.php' ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <title>Une histoire dont vous êtes le héros</title>
</head>

<body>
  <div class="container">
    <nav class="navbar  navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-book"></span> Une histoire dont vous êtes le héros</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-target">
          <?php if (isset($_SESSION['admin']) &&  $_SESSION['admin'] == 1) { ?>
            <ul class="nav navbar-nav">
              <li><a href="php/ajout_hist.php">Ajouter une histoire</a></li>
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
                  <li><a href="php/deconnexion.php">Se déconnecter</a></li>
                <?php } else { ?>
                  <li><a href="php/connexion.php">Se connecter</a></li>
                  <li><a href="php/creation_compte.php">Se créer un compte</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
    if ($BDD) {
      $tabHistJouee = array();
      $demarrage = "php/connexion.php";
      if (isset($_SESSION['login'])) {
        $req = "SELECT * FROM user WHERE pseudo = '{$_SESSION['login']}'";
        $res = $BDD->prepare($req);
        $res->execute();
        $ligne = $res->fetch();
        $idUser = $ligne['id_user'];
        $req = "SELECT * FROM hist_jouee WHERE id_user = '{$idUser}'";
        $res = $BDD->prepare($req);
        $res->execute();
        $i = 0;
        while ($ligne = $res->fetch()) {
          if ($i == 0) { ?>
            <div class="row align-items-end">
              <h2 class="col">Histoires en cours</h2>
            </div>
          <?php
            $i++;
          }
          $demarrage = "php/jeu.php?id={$ligne['id_hist']}&pageDebut={$ligne['choix_eff']}&nbPdv={$ligne['nb_pts_vie']}'";
          array_push($tabHistJouee, $ligne['id_hist']);
          $idHist = (int) $ligne['id_hist'];
          $req2 = "SELECT * FROM histoire WHERE id_hist = {$idHist}";
          $res2 = $BDD->query($req2);
          $ligne2 = $res2->fetch();
          $idCrea = (int) $ligne2['id_createur'];
          $req3 = "SELECT * FROM user WHERE id_user = {$idCrea}";
          $res3 = $BDD->query($req3);
          $maLigne = $res3->fetch(); ?>
          <article>
            <!--Il faut vérifier ici si l'utilisateur est connecté -->
            <div class="row align-items-end">
              <h3 class="col"><?php echo $ligne2['nom_hist']; ?></h3>
              <div class="col" id="nomCreateur"> une histoire créée par <?= $maLigne['pseudo']; ?> </div>
              <div class="contenuHistoire"><?= $ligne2['synopsis'] ?></div>
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                  <a class="btn btn-default btn-success" href="<?= $demarrage ?>"> Démarrer </a>
                </div>
                <?php
                if (isset($_SESSION["admin"]) &&  $_SESSION["admin"] == 1) {
                ?>
                  <div class="col" id="imgModifSuppr">
                    <a class="bi bi-pencil-square" href="php/modifier.php?id=<?= $ligne2['id_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                      </svg></a>
                    <a class="bi bi-trash3-fill" href="php/supprimer.php?id=<?= $ligne2['id_hist'] ?>&nomHist=<?= $ligne2['nom_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                      </svg></a>
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                      <a class="btn btn-default btn-success" href="php/histoires.php?id=<?= $ligne2['id_hist'] ?>"> Plus d'infos </a>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>

            </div>
          </article>
      <?php }
      } ?>
      <div class="row align-items-end">
        <?php if (isset($_SESSION['login'])) { ?>
          <h2 class="col">Autres histoires</h2>
        <?php } else { ?>
          <h2 class="col">Histoires</h2>
        <?php } ?>

      </div>
      <?php $req = "SELECT * FROM histoire ORDER BY nom_hist";
      $res = $BDD->query($req);
      while ($ligne = $res->fetch()) {
        $req2 = "SELECT * FROM user WHERE id_user =" . $ligne['id_createur'];
        $res2 = $BDD->query($req2);
        $maLigne = $res2->fetch();
        if (isset($_SESSION['login'])) {
          $demarrage = "php/jeu.php?id={$ligne['id_hist']}&pageDebut=0&nbPdv=3";
        }
        if (!in_array($ligne['id_hist'], $tabHistJouee)) {
      ?>
          <article>
            <!--Il faut vérifier ici si l'utilisateur est connecté -->
            <div class="row align-items-end">
              <h3 class="col"><?php echo $ligne['nom_hist']; ?></h3>
              <div class="col" id="nomCreateur"> une histoire créée par <?= $maLigne['pseudo']; ?> </div>
              <div class="contenuHistoire"><?= $ligne['synopsis'] ?></div>
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                  <a class="btn btn-default btn-success" href="<?= $demarrage ?>"> Démarrer </a>
                </div>
                <?php
                if (isset($_SESSION["admin"]) &&  $_SESSION["admin"] == 1) {
                ?>
                  <div class="col" id="imgModifSuppr">
                    <a class="bi bi-pencil-square" href="php/modifier.php?id=<?= $ligne['id_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                      </svg></a>
                    <a class="bi bi-trash3-fill" href="php/supprimer.php?id=<?= $ligne['id_hist'] ?>&nomHist=<?= $ligne['nom_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                      </svg></a>
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                      <a class="btn btn-default btn-success" href="php/histoires.php?id=<?= $ligne['id_hist'] ?>"> Plus d'infos </a>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>

          </article>
    <?php }
      }
    } ?>
  </div>
  <?php include 'php/templatesHTML/footer.php'; ?>

  <!-- jQuery -->
  <script src="lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>