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
    $ligne = "rien";
    if (isset($_POST['login']) && isset($_POST['mdp'])) {
      $sql = "SELECT * FROM user WHERE pseudo=:nom_user";
      $req = $BDD->prepare($sql);
      $req->execute(array(
        "nom_user" => $_POST['login']
      ));
      $ligne = $req->fetch();
      if (!empty($ligne) && password_verify($_POST['mdp'], $ligne['mdp'])) {
        $_SESSION['login'] = $_POST['login'];
        if ($ligne["est_admin"] == 1) {
          $_SESSION['admin'] = true;
        }
        header('Location: index.php');
      }
    }
    if (empty($ligne) || $ligne === "rien") {
      session_destroy(); ?>
      <h2 class="text-center">Connexion</h2>
      <?php if ($ligne !== "rien") { ?>
        <div class="alert alert-danger">
          <strong>Erreur</strong> Utilisateur et / ou mot de passe non connus !
          <!--A voir si on fait plus détaillé-->
        </div>
      <?php } ?>
      <div class="well">
        <form class="form-signin form-horizontal" role="form" action="connexion.php" method="post">
          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
              <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
              <input type="password" name="mdp" class="form-control" placeholder="Entrez votre mot de passe" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
              <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
            </div>
          </div>
        </form>
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