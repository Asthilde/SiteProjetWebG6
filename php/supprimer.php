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
    if(isset($_GET['id'])){
      $_SESSION['id_hist'] = $_GET['id'];
      $_SESSION['nom_hist'] = $_GET['nomHist'];
    }
    if ($BDD) {
      if(isset($_POST['suppr'])){
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
        $fichiers = glob("../images/" . $_SESSION['nom_hist'] . "/*");
        foreach($fichiers as $fichier){
          unlink($fichier);
        }
        rmdir("../images/" . $_SESSION['nom_hist']);
      }
      else{
    ?>
    <div class="container">
      <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          Etes-vous sur de supprimer l'histoire ?
        </div>
      </div>
      <form class="form-horizontal" role="form" action="supprimer.php" method="post">
        <div class="form-group">
          <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" name="suppr" class="btn btn-default btn-primary">Supprimer</button>
          </div>
        </div>
      </form>
    </div>
    <?php } ?>
  </div>
  <?php } 
  if(isset($_POST['suppr'])){ 
    unset($_SESSION['id_hist']); 
    header('Location:../index.php');?>
  <?php }
  ?>
  <?php include 'templatesHTML/footer.php'; ?>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>