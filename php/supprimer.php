<?php
session_start();
require_once 'connect.php'; ?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class="container">
    <?php
    include 'templatesHTML/navbar.php';
    if (isset($_GET['id'])) {
      $_SESSION['id_hist'] = (int) htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8', false);
    }
    if (isset($_GET['nomHist'])) {
      $_SESSION['nom_hist'] = htmlspecialchars($_GET['nomHist'], ENT_QUOTES, 'UTF-8', false);
    }
    if ($BDD) {
      if (isset($_POST['suppr']) && isset($_SESSION['id_hist'])) {
        $req = $BDD->prepare("DELETE FROM page_hist WHERE id_hist=:numero");
        $req->execute(array(
          "numero" => $_SESSION['id_hist']
        ));
        $req = $BDD->prepare("DELETE FROM histoire WHERE id_hist=:numero");
        $req->execute(array(
          "numero" => $_SESSION['id_hist']
        ));
        $req = $BDD->prepare("DELETE FROM choix WHERE id_hist=:numero");
        $req->execute(array(
          "numero" => $_SESSION['id_hist']
        ));
        $req = $BDD->prepare("DELETE FROM hist_jouee WHERE id_hist=:numero");
        $req->execute(array(
          "numero" => $_SESSION['id_hist']
        ));
        $fichiers = glob("../images/" . $_SESSION['nom_hist'] . "/*");
        foreach ($fichiers as $fichier) {
          unlink($fichier);
        }
        rmdir("../images/" . $_SESSION['nom_hist']);
      } else {
    ?>
        <div class="d-flex flex-column mt-5 px-5">
            <div class="text-center mb-3">
              Etes-vous sur de supprimer l'histoire ?
          </div>
          <form class="form-horizontal" role="form" action="supprimer.php" method="post">
              <div class="form-group text-center">
                <button type="submit" name="suppr" class="btn btn-default btn-success m-1">Supprimer</button>
            </div>
          </form>
        </div>
      <?php } ?>
  </div>
<?php }
    if (isset($_POST['suppr'])) {
      unset($_SESSION['id_hist']);
      header('Location:../index.php'); ?>
<?php }
?>
<?php include 'templatesHTML/footer.php'; ?>

<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>