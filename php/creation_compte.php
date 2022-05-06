<?php
session_start();
require_once("connect.php");
?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class="container">
    <?php
    include 'templatesHTML/navbar.php';

    if (isset($_POST['login']) && isset($_POST['mdp'])) {
      $pseudo = $_POST['login'];
      $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
      $sql = "INSERT INTO user(est_admin,pseudo,mdp) VALUES (?,?,?)";
      $req = $BDD->prepare($sql);
      $req->execute(array(0, $pseudo, $mdp));
      
      $sql2 = "SELECT * FROM user WHERE pseudo='{$pseudo}' AND mdp = '{$mdp}'";
      $req2 = $BDD->prepare($sql2);
      $req2->execute();
      $ligne = $req2->fetch();
      if (!empty($ligne)) {
        $_SESSION['login'] = $pseudo;
        header('Location: ../index.php');
      }
    } ?>
    <h2 class="text-center">Création de compte</h2>
    <div class="well">
      Bienvenue sur notre site ! Inscrivez-vous :
      <form class="form-signin form-horizontal" role="form" action="creation_compte.php" method="post">
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
            <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> S'inscrire </button>
          </div>
        </div>
      </form>
    </div>

    <?php include 'templatesHTML/footer.php'; ?>
  </div>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>