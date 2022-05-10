<?php
session_start();
require_once 'connect.php'; 
require_once 'requetes.php';?>
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
        $tabHistEnCours = afficherHistoireEnCours($BDD);
        //var_dump(afficherHistoireEnCours($BDD));
        foreach($tabHistEnCours as $histoire){
        //while ($ligne = $res->fetch()) {
          if ($i == 0) { ?>
            <div class="row align-items-end">
              <h2 class="col p-5">Histoires en cours</h2>
            </div>
          <?php
            $i++;
          }
          $demarrage = "jeu.php?id={$histoire['id_hist']}&pageDebut={$histoire['choix_eff']}&nbPdv={$histoire['nb_pts_vie']}";
          array_push($tabHistJouee, $histoire['id_hist']);
          //$idHist = (int) $histoire['id_hist'];
          $infosHist = afficherInfosHistoire($BDD, (int) $histoire['id_hist']);
          /*$req2 = "SELECT * FROM histoire WHERE id_hist = {$idHist}";
          $res2 = $BDD->query($req2);
          $ligne2 = $res2->fetch();
          $idCrea = (int) $ligne2['id_createur'];
          $req3 = "SELECT * FROM user WHERE id_user = {$idCrea}";
          $res3 = $BDD->query($req3);
          $maLigne = $res3->fetch();*/
          //var_dump(afficherPseudoUser($BDD, $infosHist['id_createur']));
          $pseudoCreateur = afficherPseudoUser($BDD, $infosHist['id_createur']);
          if ($infosHist['cache'] != 1) { ?>
            <div class="form-group">
              <div class="align-items-end">
                <h3><?php echo $infosHist['nom_hist']; ?></h3>
                <div id="nomCreateur">Une histoire créée par <?= $pseudoCreateur; ?> </div>
              </div>
              <div class="d-flex flex-row justify-content-between">
                <div class="pt-2"><?= $infosHist['synopsis'] ?></div>
                <div class="form-group">
                  <div>
                    <a class="btn btn-default btn-success m-1" href="<?= $demarrage ?>">Continuer</a>
                  </div>

                  <?php
                  if (isset($_SESSION["admin"]) &&  $_SESSION["admin"] == 1) {
                    $_SESSION['id_hist'] = $infosHist['id_hist'];
                    $_SESSION['nom_hist'] = $infosHist['nom_hist'];
                    include 'templatesHTML/pouvoirs_admin.php';
                  }
                  ?>
                </div>
              </div>
            </div>
      <?php }
        }
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
        if (!in_array($ligne['id_hist'], $tabHistJouee)) {
          if ($ligne['cache'] != 1) { ?>
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
                    include 'templatesHTML/pouvoirs_admin.php';
                  }
                  ?>
                </div>
              </div>
            </div>
    <?php }
        }
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