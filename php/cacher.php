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
    if ($BDD) {
      if (isset($_POST['cache']) && isset($_SESSION['id_hist'])) {
        $req = $BDD -> prepare("UPDATE histoire SET cache=:cacher WHERE id_hist=:numHist"); 
        $req->execute(array(
          'cacher' => 1,
          'numHist' => $_SESSION['id_hist']
        )); 
      } else { ?>
        <div class="d-flex flex-column mt-5 px-5">
            <div class="text-center mb-3">
              Etes-vous sur de cacher l'histoire ?
          </div>
          <form class="form-horizontal" role="form" action="cacher.php" method="post">
              <div class="form-group text-center">
                <button type="submit" name="cache" class="btn btn-default btn-success m-1">Cacher</button>
            </div>
          </form>
        </div>
      <?php } ?>
  </div>
<?php }
    if (isset($_POST['cache'])) {
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