<?php
session_start();
require_once("connect.php");
require_once("requetes.php");
?>

<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>
<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php';
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $histoire = afficherInfosHistoire($BDD, (int) htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8', false)); ?>
      <div class="d-flex justify-content-center p-3">
        <div class="row align-items-center">
          <div class="col-md-5 col-sm-7 text-center ">
            <img class="img-responsive movieImage pr-3" src="../images/<?php echo $histoire['nom_hist'] . '/' . strtolower($histoire['illustration']); ?>" alt="Affiche histoire" title="<?= $histoire['nom_hist']; ?>" width="300" />
          </div>
          <div class="col-md-7 col-sm-5">
            <h2><?= $histoire['nom_hist']; ?></h2>
            <?php
              $pseudo = afficherPseudoUser($BDD, (int) $histoire['id_createur']);?>
            <p>Créateur : <?= $pseudo; ?></p>
            <p>Nombre de fois joué : <?= $histoire['nb_fois_jouee']; ?><br />
              Pourcentage de réussite : <?php if($histoire['nb_fois_jouee'] == 0) {echo '0%'; } else {echo round((($histoire['nb_reussites']/$histoire['nb_fois_jouee'])*100),1) . '%';} ?><br />
              Pourcentage d'échec : <?php if($histoire['nb_fois_jouee'] == 0) {echo '0%'; } else {echo round((($histoire['nb_morts']/$histoire['nb_fois_jouee'])*100),1). '%';} ?></p>
            <p><small><?= $histoire['synopsis']; ?></small></p>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php include 'templatesHTML/footer.php'; ?>
  </div>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>