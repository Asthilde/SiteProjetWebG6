<?php
session_start();
require_once 'connect.php' ?>
<!doctype html>
<html>

<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class="container">
    <?php
    include 'templatesHTML/navbar.php';
    if ($BDD) {
      $tabHistJouee = array();
      $demarrage = "connexion.php";
      if (isset($_SESSION['id_user'])) {
        $req = "SELECT * FROM hist_jouee WHERE id_user = '{$_SESSION['id_user']}'";
        $res = $BDD->prepare($req);
        $res->execute();
        $i = 0;
        while ($ligne = $res->fetch()) {
          if ($i == 0) { ?>
            <div class="row align-items-end">
              <h2 class="col p-5">Histoires en cours</h2>
            </div>
          <?php
            $i++;
          }
          $demarrage = "jeu.php?id={$ligne['id_hist']}&pageDebut={$ligne['choix_eff']}&nbPdv={$ligne['nb_pts_vie']}";
          array_push($tabHistJouee, $ligne['id_hist']);
          $idHist = (int) $ligne['id_hist'];
          $req2 = "SELECT * FROM histoire WHERE id_hist = {$idHist}";
          $res2 = $BDD->query($req2);
          $ligne2 = $res2->fetch();
          $idCrea = (int) $ligne2['id_createur'];
          $req3 = "SELECT * FROM user WHERE id_user = {$idCrea}";
          $res3 = $BDD->query($req3);
          $maLigne = $res3->fetch(); ?>
          <div class="form-group">
            <!--<a class="btn btn-default btn-success" href="<?= $demarrage ?>"> Démarrer </a>-->
            <div class="align-items-end">
              <h3><?php echo $ligne2['nom_hist']; ?></h3>
              <div id="nomCreateur">Une histoire créée par <?= $maLigne['pseudo']; ?> </div>
            </div>
            <div class="d-flex flex-row justify-content-between">
              <div class="pt-2"><?= $ligne2['synopsis'] ?></div>
              <div class="form-group">
                <div>
                  <a class="btn btn-default btn-success m-1" href="<?= $demarrage ?>">Continuer</a>
                </div>

                <?php
                if (isset($_SESSION["admin"]) &&  $_SESSION["admin"] == 1) {
                ?>
                  <div class="m-1" id="imgModifSuppr">
                    <a class="bi bi-pencil-square" href="modifier.php?id=<?= $ligne2['id_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                      </svg></a>
                    <a class="bi bi-trash3-fill" href="supprimer.php?id=<?= $ligne2['id_hist'] ?>&nomHist=<?= $ligne2['nom_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                      </svg></a>
                  </div>
                  <div class="m-1">
                    <a class="btn btn-default btn-success" href="histoires.php?id=<?= $ligne2['id_hist'] ?>"> Plus d'infos </a>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
      <?php }
      } ?>
      <div class="row align-items-end">
        <?php if (isset($_SESSION['login'])) { ?>
          <h2 class="col p-5">Autres histoires</h2>
        <?php } else { ?>
          <h2 class="col p-5 ">Histoires</h2>
        <?php } ?>
      </div>
      <?php $req = "SELECT * FROM histoire ORDER BY nom_hist";
      $res = $BDD->query($req);
      while ($ligne = $res->fetch()) {
        $req2 = "SELECT * FROM user WHERE id_user =" . $ligne['id_createur'];
        $res2 = $BDD->query($req2);
        $maLigne = $res2->fetch();
        if (isset($_SESSION['login'])) {
          $demarrage = "jeu.php?id={$ligne['id_hist']}";
        }
        if (!in_array($ligne['id_hist'], $tabHistJouee)) { ?>
          <div class='container mb-3'>
            <!--Il faut vérifier ici si l'utilisateur est connecté -->
            <div class="align-items-end">
              <h3><?php echo $ligne['nom_hist']; ?></h3>
              <div id="nomCreateur"> une histoire créée par <?= $maLigne['pseudo']; ?> </div>
            </div>
            <div class="d-flex flex-row justify-content-between">
              <div class="pt-2"><?= $ligne['synopsis'] ?></div>
              <div class="form-group">
                <a class="btn btn-default btn-success m-1" href="<?= $demarrage ?>"> Démarrer </a>
                <?php
                if (isset($_SESSION["admin"]) &&  $_SESSION["admin"] == 1) {
                ?>
                  <div class="m-1" id="imgModifSuppr">
                    <a class="bi bi-pencil-square" href="modifier.php?id=<?= $ligne['id_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                      </svg></a>
                    <a class="bi bi-trash3-fill" href="supprimer.php?id=<?= $ligne['id_hist'] ?>&nomHist=<?= $ligne['nom_hist'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                      </svg></a>
                  </div>
                  <div class="m-1">
                    <a class="btn btn-default btn-success" href="histoires.php?id=<?= $ligne['id_hist'] ?>"> Plus d'infos </a>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
    <?php }
      }
    } ?>
  </div>
  <?php include 'templatesHTML/footer.php'; ?>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>