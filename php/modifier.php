<?php
session_start();
require_once 'connect.php';?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php';
if(isset($_SESSION['pageModifiee'])){
  unset($_SESSION['pageModifiee']);
}
?>

<body>
<div class="container">
  <?php include 'templatesHTML/navbar.php'; ?>
  <div class="well">
    <form class="form-horizontal" role="form" action="modifierPage.php" method="post">
      <input type="hidden" name="id" value="">
      <div class="form-group">
        <label class="col-sm-4 control-label">Page à modifier</label>
        <div class="col-sm-6">
          <select class="form-control" id="pageChoisie" name="pageChoisie" required>
            <?php 
            if (isset($_GET['id']) && !empty($_GET['id']))
              $_SESSION['id_hist'] = $_GET['id'];
            if(isset($_SESSION['id_hist'])){
              $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
              $req->execute(array(
                "numero" => $_SESSION['id_hist']
              ));
              while ($ligne = $req->fetch()) {?>
              <option value="<?= $ligne['id_page'] ?>"><?= $ligne['id_page'] ?></option>
              <?php }} ?>
          </select>
        </div>
      </div>
      <div class="form-group">
          <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-default btn-primary"> Choisir page</button>
          </div> <!--A voir pour le placement du bouton -->
        </div>
    </form>
    </div>
    <div class="row align-items-end">
      <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          <a class="btn btn-default btn-primary" href="fin_hist.php">Retour accueil</a>
                  <!-- A voir pour avoir une autre forme qu'un bouton -->
        </div>
      </div>
  </div>
  <?php include 'templatesHTML/footer.php'; ?>
</div>

<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>