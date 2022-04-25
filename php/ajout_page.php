<?php
session_start();
require_once("connect.php");
if($_SESSION['num_page'] == 0){
    $req2 = "SELECT * FROM histoire WHERE nom_hist = '{$_SESSION['nom_hist']}'";
    $res2 = $BDD->query($req2);
    $idHist = $res2->fetch();
    $_SESSION['id_hist'] = $idHist['id_hist'];
}
$tabPages = array();
for($i=0; $i < 5; $i++){
  for($j = 1; $j < 4 ; $j++){

  }
}
array(
  "A" => ["1", "2", "3"],
  "A1B" => ["1", "2", "3"]
);
if(isset($_POST['para1']) || isset($_POST['img1'])) {
    $req = $BDD->prepare("SELECT COUNT(*) as nb FROM page WHERE id_page=:idPage");
    $req->execute(array(
        "idPage" => $_SESSION['num_page']
    ));
    // On récupère la première ligne.
    $ligne = $req->fetch();

    // On vérifie le nombre d'éléments correspondant
    if($ligne['nb'] == 0) {
        $cpt=1;
        $nom = "para" . $cpt;
        $tab = array();
        while(isset($_POST[$nom])){
            $tab[$nom] =  $_POST['{$nom}'];
        }
        $nbPara = count($tab);
        $nom = "img" . $cpt;
        while(isset($_POST[$nom])){
            $tab[$nom] =  $_POST['{$nom}'];
        }
        $nbImg = count($tab) - $nbPara;
        for($i=1; $i <= $nbPara ; $i++){
            $sql = "INSERT INTO 'page' (id_page, id_hist, para_'{$i}') VALUES ('{$_SESSION['num_page']}','{$_SESSION['id_hist']}', :para'{$i}')";
            $req = $BDD->prepare($sql);
            $req->execute($tab);
        }
        for($i=1; $i <= $nbImg ; $i++){ //Voir comment gérer le nom
            $_FILES["img'{$i}'"]['name'] =  strtolower("image_'{$_SESSION['num_page']}'_'{$i}'.".substr($_FILES["image"]['name'], strpos($_FILES["image"]['name'], '.')));
            if(move_uploaded_file($_FILES["img'{$i}'"]['tmp_name'], "../images/".$_SESSION['nom_hist'].$_FILES["image"]['name'])){
                $sql = "INSERT INTO 'page' (id_page, id_hist, img_'{$i}') VALUES ('{$_SESSION['num_page']}','{$_SESSION['id_hist']}', :img'{$i}')";
                $req = $BDD->prepare($sql);
                $req->execute($tab);
            }
        }
        if($_SESSION['num_page'] == 0){
          $_SESSION['num_page'] = 'A1';
        }
        else if(count_chars($_SESSION['num_page']) == 2) {
          if(str_contains($_SESSION['num_page'], '3')){
            $_SESSION['num_page'] = 'A1B1';
          }
          else{
            $_SESSION['num_page'] = 'A'. ((count($_COOKIE)-2)%3);
          }
        }
        else if(count_chars($_SESSION['num_page']) == 4) {
          if(str_contains($_SESSION['num_page'], '3')){ //Il faudrait commencer à vérifier si les pages ont des enfants ou non pour prendre le bon nom de cookie
            $_SESSION['num_page'] = 'A1B1';
          }
          else{
            $_SESSION['num_page'] = 'A'. ((count($_COOKIE)-2)%3);
          }
        }
        //Trouver comment savoir quelle page est renseignée
    }
    else {
        echo "Les données existent déja dans la base !"; ?>
        <a href="ajout_page.php">CONTINUER</a>
        <a href="index.php">RETOUR</a>
        <a href="fin_hist.php"> TERMINER L'HISTOIRE</a> <!--Gérer la suppression des cookies ? -->
        <?php
    }
}
?>
  <!doctype html>
  <html>
    <?php include 'templatesHTML/head.php';?>
    <body>
      <div class="container">
        <?php include 'templatesHTML/navbar.php'; ?>
          <h2 class="text-center">Ajout de la page du choix <?= $_SESSION['num_page']; ?></h2>
          <div class="col-sm-4 col-sm-offset-4">
            <div>
              Liste des choix déja renseignés :
              <?php for($i = 1 ; $i <= count($_COOKIE) ; $i++){
                echo '0' . '<br/>';
                if($i < 5){
                  echo($_COOKIE['A{$i}'] . ', ');
                }
                else if($i < 11){
                  echo($_COOKIE['B{$i}'] . ', ');
                }
                }?>
            </div>
            <a href="fin_hist.php" class="btn btn-default btn-primary"> Terminer l'histoire</a>
          </div>
          <div class="well">
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="ajout_page.php" method="post">
              <input type="hidden" name="id" value="">
              <!--Faire du JS si possible -->
              <?php for($i = 1; $i < 6; $i++) {?>
              <div class="form-group">
                <label class="col-sm-4 control-label">Paragraphe<?= $i ?></label>
                <div class="col-sm-6">
                  <input type="text" name="para<?= $i ?>" value="" class="form-control" placeholder="Ecrivez votre paragraphe" <?php if($i == 1) { ?>required <?php } ?> autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Image<?= $i ?></label>
                <div class="col-sm-4">
                  <input type="file" name="img<?= $i ?>" />
                </div>
              </div>
              <?php } ?>
              <?php for($i = 1; $i < 4; $i++) {?>
              <div class="form-group">
                <label class="col-sm-4 control-label">Choix <?= $i ?> (si c'est la fin de la branche écrire NULL dans l'encadré)</label>
                <div class="col-sm-6">
                  <input type="text" name="choix<?= $i ?>" value="" class="form-control" placeholder="Ecrivez le choix<?= $i ?>" <?php if($i == 1) { ?>required <?php } ?> autofocus>
                </div>
              </div>
              <?php } ?>
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
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>    </body>

  </html>

  