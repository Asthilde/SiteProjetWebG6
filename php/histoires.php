<?php
session_start();
require_once("connect.php");
?>

<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>
<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php';
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $res = $BDD->prepare("SELECT * FROM histoire WHERE id_hist=:numero");
      $res->execute(array(
        "numero" => htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8', false)
      ));
      $ligne = $res->fetch(); ?>
      <div class="jumbotron">
        <div class="row">
          <div class="col-md-5 col-sm-7">
            <img class="img-responsive movieImage" src="../images/<?php echo $ligne['nom_hist'] . '/' . strtolower($ligne['illustration']); ?>" alt="Affiche histoire" title="<?= $ligne['nom_hist']; ?>" />
          </div>
          <div class="col-md-7 col-sm-5">
            <h2><?= $ligne['nom_hist']; ?></h2>
            <?php
              $req2 = $BDD->prepare("SELECT * FROM user WHERE id_user= '{$ligne['id_createur']}'");
              $req2->execute();
              $ligne2 = $req2->fetch();?>
            <p>Créateur : <?= $ligne2['pseudo']; ?></p>
            <p>Nombre de fois joué : <?= $ligne['nb_fois_jouee']; ?><br />
              Nombre de réussites : <?= $ligne['nb_reussites']; ?><br />
              Nombre d'échecs : <?= $ligne['nb_morts']; ?></p>
            <p><small><?= $ligne['synopsis']; ?></small></p>
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