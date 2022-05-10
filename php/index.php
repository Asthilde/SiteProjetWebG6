<?php
session_start();
require_once 'connect.php';
require_once 'requetes.php'; ?>
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
        $i = 0;
        $tabHistEnCours = afficherHistoireEnCours($BDD, $_SESSION['id_user']);
        foreach ($tabHistEnCours as $histoire) {
          if ($i == 0) { ?>
            <div class="row align-items-end">
              <h2 class="col p-5">Histoires en cours</h2>
            </div>
      <?php
            $i++;
          }
          $demarrage = "jeu.php?id={$histoire['id_hist']}&pageDebut={$histoire['choix_eff']}&nbPdv={$histoire['nb_pts_vie']}";
          array_push($tabHistJouee, $histoire['id_hist']);
          $infosHist = afficherInfosHistoire($BDD, (int) $histoire['id_hist']);
          $pseudoCreateur = afficherPseudoUser($BDD, $infosHist['id_createur']);
          if ($infosHist['cache'] != 1) {
            include 'templatesHTML/affichageHistoire.php';
          }
        }
      } ?>
      <div class="row align-items-end">
        <?php if (isset($_SESSION['login'])) { ?>
          <h2 class="col p-5">Autres histoires</h2>
        <?php } else { ?>
          <h2 class="col p-5 ">Histoires</h2>
        <?php } ?>
      </div>
    <?php
      $tabHistoires = afficherHistoires($BDD);
      foreach ($tabHistoires as $infosHist) {
        $pseudoCreateur = afficherPseudoUser($BDD, $infosHist['id_createur']);
        if (isset($_SESSION['login'])) {
          $demarrage = "jeu.php?id={$infosHist['id_hist']}";
        }
        if (!in_array($infosHist['id_hist'], $tabHistJouee)) {
          if ($infosHist['cache'] != 1) {
            include 'templatesHTML/affichageHistoire.php';
          }
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