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

<body class=>
  <div class="container">
    <?php include 'templatesHTML/navbar.php'; ?>
    <h2 class="text-center">Ajout d'une histoire</h2>
    <div class="well">
      <?php if (count($_POST) > 0) { ?>
        <div class="alert alert-danger">
          <strong>Attention</strong> Un des champs n'a pas été renseigné !
        </div>
      <?php } ?>
      <form class="form-horizontal" role="form" enctype="multipart/form-data" action="ajout_hist.php" method="post">
        <input type="hidden" name="id" value="">
        <div class="form-group">
          <label class="col-sm-4 control-label">Titre</label>
          <div class="col-sm-6">
            <input type="text" name="nom" value="<?php if (isset($_POST['nom'])) {
                                                    echo $_POST['nom'];
                                                  } ?>" class="form-control" placeholder="Entrez le nom de votre histoire" required autofocus>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">Synopsis</label>
          <div class="col-sm-6">
            <textarea name="resume" class="form-control" placeholder="Entrez son synopsis" required>
              <?php if (isset($_POST['resume'])) {
                echo str_replace('  ', '', $_POST['resume']);
              } ?>
            </textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">Image</label>
          <div class="col-sm-4">
            <input type="file" name="image" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
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