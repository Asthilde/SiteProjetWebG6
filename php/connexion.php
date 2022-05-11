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
    $ligne = "rien";
    if ($BDD) {
      if (isset($_POST['login']) && isset($_POST['mdp'])) {
        $sql = "SELECT * FROM user WHERE pseudo=:nom_user";
        $req = $BDD->prepare($sql);
        $req->execute(array(
          "nom_user" => $_POST['login']
        ));
        $ligne = $req->fetch();
        if (!empty($ligne) && password_verify($_POST['mdp'], $ligne['mdp'])) {
          $_SESSION['login'] = $_POST['login']; //Il faut faire une variable de session pour avoir l'idUser
          $_SESSION['id_user'] = (int) $ligne['id_user'];

          if ($ligne["est_admin"] == 1) {
            $_SESSION['admin'] = 1;
          } else
            $_SESSION['admin'] = 0;
          header('Location: ../index.php');
        }
      }
    }
    if (empty($ligne) || $ligne === "rien") {
      session_destroy(); ?>
      <h2 class="text-center p-5">Connexion</h2>
      <?php if ($ligne !== "rien") { ?>
        <div class="alert alert-danger">
          <strong>Erreur</strong> Utilisateur et / ou mot de passe non connus !
          <!--A voir si on fait plus détaillé-->
        </div>
      <?php } ?>
      <div class="d-flex justify-content-center">
        <form class="form-signin form-horizontal" role="form" action="connexion.php" method="post">
          <div class="form-group">
            <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
          </div>
          <div class="form-group">
            <input type="password" name="mdp" class="form-control" placeholder="Entrez votre mot de passe" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-default btn-success"><i class="bi bi-box-arrow-in-right"></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
              </svg> Se connecter</button>
          </div>
          <div class="form-group text-center">
            <p>Vous n'avez pas de compte ? Inscrivez-vous : </p>
            <a href="creation_compte.php" class="btn btn-default btn-success justify-content-center"> Se créer un compte</a>
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