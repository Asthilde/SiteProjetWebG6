<?php
session_start();
require_once 'connect.php'; ?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php';
if (isset($_SESSION['pageModifiee'])) {
  unset($_SESSION['pageModifiee']);
}
?>

<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php'; ?>
    <div class="d-flex justify-content-center mt-3 px-3">
      <form class="form-horizontal w-75 text-center" role="form" action="modifierPage.php" method="post">
      <div class="form-group mx-auto">    
      <h3>Page à modifier</h3>
          <select class="form-control text-center w-50 m-auto" id="pageChoisie" name="pageChoisie" required>
            <?php
            if ($BDD) {
              if (isset($_GET['id']) && !empty($_GET['id']))
                $_SESSION['id_hist'] = $_GET['id'];
              if (isset($_SESSION['id_hist'])) {
                $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
                $req->execute(array(
                  "numero" => $_SESSION['id_hist']
                ));
                while ($ligne = $req->fetch()) { ?>
                  <option value="<?= $ligne['id_page'] ?>"><?= $ligne['id_page'] ?></option>
            <?php }
              }
            } ?>
          </select>
      </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default btn-success m-1"> Choisir page</button>
        </div>
      </form>
    </div>
    <div class="d-flex justify-content-center px-5">
      <a class="btn btn-default btn-success m-1" href="fin_hist.php">Retour accueil</a>
    </div>
    <?php include 'templatesHTML/footer.php'; ?>
  </div>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>