<?php
session_start();
require_once("connect.php");
/*if ($_SESSION['admin'] == 0) {
  echo "ERREUR";
}*/

if (isset($_POST['nom']) && ($_POST['nom'] != ' ') && isset($_POST['resume']) && ($_POST['nom'] != ' ') && isset($_FILES["image"]['name'])) {
  $req = $BDD->prepare("SELECT COUNT(*) as nb FROM histoire WHERE nom_hist=:titre");
  $req->execute(array(
    "titre" => $_POST['nom']
  ));
  $ligne = $req->fetch();
  // On vérifie le nombre d'éléments correspondant
  if ($ligne['nb'] == 0) {
    //Avoir un nommage type de l'image en vérifiant son type ! (jpg, jpeg , ... ) et créer un dossier d'images par histoire
    if (is_dir("../images/" . $_POST['nom']) || mkdir("../images/" . $_POST['nom'])) {
      $_FILES["image"]['name'] =  strtolower("image_accueil_" . $_POST['nom'] . substr($_FILES["image"]['name'], strpos($_FILES["image"]['name'], '.')));
      if (move_uploaded_file($_FILES["image"]['tmp_name'], "../images/" . $_POST['nom'] . '/' . $_FILES["image"]['name'])) {
        // On prépare une nouvelle requête
        $req2 = "SELECT * FROM user WHERE pseudo = '{$_SESSION['login']}'";
        $res2 = $BDD->query($req2);
        $idUser = $res2->fetch();
        $sql = "INSERT INTO histoire (nom_hist, illustration, synopsis, id_createur) VALUES (:titre, :img, :synopsis, '{$idUser['id_user']}')";
        $req = $BDD->prepare($sql);

        // On exécute la requête en lui transmettant les données qui nous interessent
        $req->execute(array(
          "titre" => htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8', false),
          "synopsis" => htmlspecialchars($_POST['resume'], ENT_QUOTES, 'UTF-8', false),
          "img" => $_FILES["image"]['name']
        ));
        $_SESSION['nom_hist'] = $_POST['nom'];
        $_SESSION['num_page'] = '0';
        header('Location: ajout_page.php');
      }
    }
  } else {
    echo "L'histoire existe déja dans la base !"; ?>
    <a href="index.php">RETOUR</a>
<?php
  }
}
?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php'; ?>
    <h2 class="text-center">Ajout d'une histoire</h2>
    <div class="d-flex justify-content-center p-3">
      <?php if (count($_POST) > 0) { ?>
        <div class="alert alert-danger w-50 m-auto">
          <strong>Attention</strong> Un des champs n'a pas été renseigné !
        </div>
      <?php } ?>
    </div>
    <div class="d-flex justify-content-center p-3">
      <form class="form-horizontal w-50" role="form" enctype="multipart/form-data" action="ajout_hist.php" method="post">
        <div class="form-group">
          <input type="text" name="nom" value="<?php if (isset($_POST['nom'])) {
                                                  echo $_POST['nom'];
                                                } ?>" class="form-control" placeholder="Entrez le nom de votre histoire" required autofocus>
        </div>
        <div class="form-group">
          <input type="text" name="resume" value="" class="form-control" placeholder="Entrez son synopsis" required>
        </div>
        <div class="form-group">
          Image <br />
          <input type="file" name="image" />
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-default btn-success m-1"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
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