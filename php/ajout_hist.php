<?php
session_start();
require_once("connect.php");
require_once("requetes.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if($BDD){
  //Si toutes les données sont renseignées, l'histoire est ajoutée à la BDD.
  if (isset($_POST['nom']) && ($_POST['nom'] != ' ') && isset($_POST['resume']) && ($_POST['nom'] != ' ') && isset($_FILES["image"]['name'])) {
    $titre = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8', false);
    //On vérifie que l'histoire n'est pas déja présente dans la BDD.
    $req = $BDD->prepare("SELECT COUNT(*) as nb FROM histoire WHERE nom_hist=:titre");
    $req->execute(array(
      "titre" => $titre
    ));
    $ligne = $req->fetch();
    if ($ligne['nb'] == 0) {
      //On vérifie si un dossier contenant les images d'une histoire exite. Sinon il est créé.
      if (is_dir("../images/" . $titre) || mkdir("../images/" . $titre)) {
        $_FILES["image"]['name'] =  strtolower("image_accueil_" . $titre . substr($_FILES["image"]['name'], strpos($_FILES["image"]['name'], '.')));
        if (move_uploaded_file($_FILES["image"]['tmp_name'], "../images/" . $titre . '/' . $_FILES["image"]['name'])) {
          insererHistoire($BDD);
          $_SESSION['nom_hist'] = $titre;
          $_SESSION['num_page'] = '0';
          header('Location: ajout_page.php');
        }
      }
    } 
    else {
      echo "L'histoire existe déja dans la base !"; ?>
      <a href="index.php"class="btn btn-default btn-success m-1">RETOUR</a>
  <?php }
  }
} ?>

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
          <input type="text" name="nom" value="<?php if (isset($_POST['nom'])) { echo $_POST['nom'];} ?>" class="form-control" placeholder="Entrez le nom de votre histoire" required autofocus>
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