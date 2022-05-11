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
    <h2 class="text-center p-5">Création de compte</h2>
    <div class="text-center">
      Bienvenue sur notre site ! Inscrivez-vous :
    </div>
    <div class="d-flex justify-content-center p-3">
      <form class="form-signin form-horizontal w-25" role="form" action="creation_compte.php" method="post">
        <div class="form-group">
          <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
        </div>
        <div class="form-group">
          <input type="password" name="mdp" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-default btn-success justify-content-center"><i class="bi bi-box-arrow-in-right"></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
              <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
            </svg> S'inscrire </button>
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