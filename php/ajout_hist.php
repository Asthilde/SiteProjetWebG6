<?php
session_start();
require_once("connect.php");
if(isset($_POST['titre']) && isset($_POST['resume'])) {
    $req = $BDD->prepare("SELECT COUNT(*) as nb FROM histoire WHERE nom_hist=:titre");
    $req->execute(array(
        "titre" => $_POST['nom']
    ));
    // On récupère la première ligne.
    $ligne = $req->fetch();

    // On vérifie le nombre d'éléments correspondant
    if($ligne['nb'] == 0) {
        //Avoir un nommage type de l'image et créer un dossier d'images par histoire ?
        mkdir("../images/".$_POST['nom']);
        $_FILES["image"]['name'] =  strtolower($_POST['title']) . $_FILES["image"]['name'] . 'jpg';
        if(move_uploaded_file($_FILES["image"]['tmp_name'], "../images/".$_FILES["image"]['name'])){
            // On prépare une nouvelle requête
            $req2 = "SELECT id_user FROM user WHERE pseudo =" . $_SESSION['login'];
            $res2 = $BDD->query($req2);
            $idUser = $res2->fetch();
            $sql = "INSERT INTO histoire (nom_hist, illustration, synopsis, id_createur) VALUES (:titre, :img, :synopsis," . $idUser . ")";
            $req = $BDD->prepare($sql);

            // On exécute la requête en lui transmettant les données qui nous interessent
            $req->execute(array(
                "titre" => $_POST['nom'],
                "synopsis" => $_POST['resume'],
                "img" => $_FILES["image"]['name'] 
            ));
        }
        header('Location: ajoutPage.php') ;
    }
    else {
        echo "L'histoire existe déja dans la base !"; ?>
        <a href="index.php">RETOUR</a>
        <?php
    }
}
?>
  <!doctype html>
  <html>
    <?php include 'head.php';?>
    <body>
      <div class="container">
        <?php include 'navbar.php'; ?>
          <h2 class="text-center">Ajout d'une histoire</h2>
          <div class="well">
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="ajout_hist.php" method="post">
              <input type="hidden" name="id" value="">
              <div class="form-group">
                <label class="col-sm-4 control-label">Titre</label>
                <div class="col-sm-6">
                  <input type="text" name="nom" value="" class="form-control" placeholder="Entrez le nom de votre histoire" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Synopsis</label>
                <div class="col-sm-6">
                    <textarea name="resume" class="form-control" placeholder="Entrez son synopsis" required>
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
          <?php include 'footer.php'; ?>
        </div>

      <!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>    </body>

  </html>

  