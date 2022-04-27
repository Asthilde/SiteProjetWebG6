<?php
session_start();
require_once("connect.php");
require("functions.php");
if ($_SESSION['num_page'] == 0) {
  $req2 = "SELECT * FROM histoire WHERE nom_hist = '{$_SESSION['nom_hist']}'";
  $res2 = $BDD->query($req2);
  $idHist = $res2->fetch();
  $_SESSION['id_hist'] = $idHist['id_hist'];
}
if (isset($_POST['para1']) || isset($_POST['img1'])) {
  $req = $BDD->prepare("SELECT COUNT(*) as nb FROM page_hist WHERE id_page=:idPage");
  $req->execute(array(
    "idPage" => $_POST['page'] //ne trouve pas cette variable ...
  ));
  // On récupère la première ligne.
  $ligne = $req->fetch();

  // On vérifie le nombre d'éléments correspondant
  if ($ligne['nb'] == 0) {
    $cpt = 1;
    $nom = "para" . $cpt;
    $tab = array();
    while (isset($_POST[$nom])) {
      $tab['{$nom}'] =  $_POST['{$nom}'];
    }
    $nbPara = count($tab);
    $nom = "img" . $cpt;
    while (isset($_POST[$nom])) {
      $tab[$nom] =  $_POST['{$nom}'];
    }
    $nbImg = count($tab) - $nbPara;
    for ($i = 1; $i <= $nbPara; $i++) {
      //Il faut vérifier ce que l'utilisateur rentre comme texte !
      $sql = "INSERT INTO page_hist (id_page, id_hist, para_'{$i}') VALUES ('{$_SESSION['num_page']}','{$_SESSION['id_hist']}', :para'{$i}')";
      $req = $BDD->prepare($sql);
      $req->execute($tab);
    }
    for ($i = 1; $i <= $nbImg; $i++) { //Voir comment gérer le nom
      $_FILES["img'{$i}'"]['name'] =  strtolower("image_'{$_SESSION['num_page']}'_'{$i}'." . substr($_FILES["image"]['name'], strpos($_FILES["image"]['name'], '.')));
      if (move_uploaded_file($_FILES["img'{$i}'"]['tmp_name'], "../images/" . $_SESSION['nom_hist'] . $_FILES["image"]['name'])) {
        $sql = "INSERT INTO page_hist (id_page, id_hist, img_'{$i}') VALUES ('{$_POST['page']}','{$_SESSION['id_hist']}', :img'{$i}')";
        $req = $BDD->prepare($sql);
        $req->execute($tab);
      }
    }
  } else {
    echo "Les données existent déja dans la base !"; ?>
    <a href="ajout_page.php">CONTINUER</a>
    <a href="index.php">RETOUR</a>
    <a href="fin_hist.php"> TERMINER L'HISTOIRE</a>
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
    <h2 class="text-center">Ajout de la page <? if(isset($_POST['page'])){echo $_POST['page']; } else { echo '0';} ?></h2>
    <div class="col-sm-4 col-sm-offset-4">
      <div>
        Liste des choix déja renseignés :
        <?php $tabPages = array();
        if(isset($_POST['para1']) || isset($_POST['img1'])){
          $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
          $req->execute(array(
          "numero" => $_SESSION['id_hist']
          ));
          while ($ligne = $res->fetch()) {
            array_push($tabPages, $ligne['id_page']);
          }
          echo '0';
        }
        foreach($tabPages as $pageRenseignee) {
            echo (', ' . $pageRenseignee);
        } ?>
      </div>
      <a href="fin_hist.php" class="btn btn-default btn-primary"> Terminer l'histoire</a>
    </div>
    <div class="well">
      <form class="form-horizontal" role="form" enctype="multipart/form-data" action="ajout_page.php" method="post">
        <input type="hidden" name="id" value="">
        <!--Faire du JS si possible -->
        <div class="form-group">
          <label class="col-sm-4 control-label">Page à remplir</label>
          <div class="col-sm-6">
            <select class="form-control" name="page" required>
                <?php if(!isset($_POST['page'])){ ?>
                  <option value="0">0</option>
                <?php }
                $tab = array();
                pages($tab, null, 'A', 1);
                // On récupère la première ligne.
                foreach($tab as $page){ 
                  $dejaRenseigne = false;
                  foreach($tabPages as $pageRenseignee){
                    if($page == $pageRenseignee){ 
                      $dejaRenseigne = true;
                      break;
                    }
                  }
                  if(!$dejaRenseigne) {?>
                  <option value="<?= $page ?>"><?= $page ?></option>
                  <?php }
                } ?>
             </select>
            </div>
        </div>
        <?php for ($i = 1; $i < 6; $i++) { ?>
          <div class="form-group">
            <label class="col-sm-4 control-label">Paragraphe<?= $i ?></label>
            <div class="col-sm-6">
              <input type="text" name="para<?= $i ?>" value="" class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Image<?= $i ?></label>
            <div class="col-sm-4">
              <input type="file" name="img<?= $i ?>" />
            </div>
          </div>
        <?php } ?>
        <?php for ($i = 1; $i < 4; $i++) { ?>
          <div class="form-group">
            <label class="col-sm-4 control-label">Choix <?= $i ?> (si c'est la fin de la branche écrire NULL dans l'encadré)</label>
            <div class="col-sm-6">
              <input type="text" name="choix<?= $i ?>" value="" class="form-control" placeholder="Ecrivez le choix<?= $i ?>" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
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
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>