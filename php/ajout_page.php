<?php
session_start();
require_once("connect.php");
require("functions.php");
if (!isset($_POST['pageChoisie'])) { //$_SESSION['num_page'] == 0) {
  $req2 = "SELECT * FROM histoire WHERE nom_hist = '{$_SESSION['nom_hist']}'";
  $res2 = $BDD->query($req2);
  $idHist = $res2->fetch();
  $_SESSION['id_hist'] = $idHist['id_hist'];
}
if (isset($_POST['para_1']) || isset($_POST['img_1'])) {
  $req = $BDD->prepare("SELECT COUNT(*) as nb FROM page_hist WHERE id_page='{$_POST['pageChoisie']}'");
  $req->execute();
  /*$req->execute(array(
    "idPage" => $_POST['pageChoisie']
  ));
  // On récupère la première ligne.*/
  $ligne = $req->fetch();
  // On vérifie le nombre d'éléments correspondant
  if ($ligne['nb'] == 0) {
    $cpt = 1;
    $tab = array(
      'numero' => $_POST['pageChoisie'],
      'numHist' => (int)$_SESSION['id_hist'],
      'para_1' => '',
      'para_2' => '',
      'para_3' => '',
      'para_4' => '',
      'para_5' => '',
      'img_1' => '',
      'img_2' => '',
      'img_3' => '',
      'img_4' => '',
      'img_5' => ''
    );
    for($i=1; $i < 6; $i++){
      $nom = "para_" . $cpt;
      if (isset($_POST[$nom])) {
        $tab[$nom] = $_POST[$nom];
      }
    }
    for($i=1; $i < 6; $i++){
      $nom = "img_" . $cpt;
      if(isset($_FILES[$nom])) { //Voir comment gérer le nom
        $_FILES[$nom]['name'] =  strtolower("image_{$_POST['pageChoisie']}_{$cpt}" . substr($_FILES[$nom]['name'], strpos($_FILES[$nom]['name'], '.')));
        if (move_uploaded_file($_FILES[$nom]['tmp_name'], "../images/" . $_SESSION['nom_hist'] . $_FILES[$nom]['name'])) {
          $tab[$nom] = $_FILES[$nom]['name'];  
        }
      }
      else{
        $tab[$nom] = "";
      }
    }
      //var_dump($tab);
      $sql = "INSERT INTO page_hist (id_page, id_hist, para_1, para_2, para_3, para_4, para_5, img_1, img_2, img_3, img_4, img_5) VALUES (:numero, :numHist, :para_1, :para_2, :para_3, :para_4, :para_5, :img_1, :img_2, :img_3, :img_4, :img_5)"; //'{$_SESSION['num_page']}','{$_SESSION['id_hist']}', :para'{$cpt}')";
      $req = $BDD->prepare($sql);
      $req->execute($tab);

    for($i=1; $i < 4; $i++){
      $nom = "choix" . $cpt; 
      if($_POST['pageChoisie'] == 0){
        $nivSuiv = 'A';
        $nomPageCible = 'A' . $i;
      }
      else {
        $nivSuiv = chr(ord(substr($_POST['pageChoisie'], -2, 1))+1) ;
        //echo 'Niveau suivant : ' . $nivSuiv;
        $nomPageCible = $_POST['pageChoisie'] . $nivSuiv . $i;   
        //echo ' - PageCible : ' . $nomPageCible . '<br/>';
      }
      $sql = "INSERT INTO choix (id_page, id_page_cible, id_hist, contenu) VALUES (:numPage, :numPageCible, :numHist, :choix)"; //'{$_SESSION['num_page']}','{$_SESSION['id_hist']}', :para'{$cpt}')";
      $req = $BDD->prepare($sql);//Problème au niveau du num_page car il n'y a que des int
      $req->execute(array(
        'numPage' => $_POST['pageChoisie'],
        'numPageCible' => $nomPageCible,
        'numHist' => $_SESSION['id_hist'],
        'choix' => $_POST[$nom]
      ));
      $cpt++;
    }
  } 
  else {
    echo "Les données existent déja dans la base !"; ?>
    <a href="ajout_page.php">CONTINUER</a>
    <a href="index.php">RETOUR</a>
    <a href="fin_hist.php"> TERMINER L'HISTOIRE</a>
<?php
 //var_dump($ligne['nb']);
  }
}
?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php'; ?>
    <h2 class="text-center">Ajout de la page <? if(isset($_POST['pageChoisie'])){echo $_POST['pageChoisie']; } else { echo '0';} //Problème car m'affiche que 0 ?></h2>
    <div class="col-sm-4 col-sm-offset-4">
      <div>
        Liste des choix déja renseignés :
        <?php $tabPages = array();
        if(isset($_POST['para_1']) || isset($_POST['img_1'])){
          $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
          $req->execute(array(
            "numero" => $_SESSION['id_hist']
          ));
          while ($ligne = $req->fetch()) {
            array_push($tabPages, $ligne['id_page']);
          }
          foreach($tabPages as $pageRenseignee) {
            echo ($pageRenseignee . ',');
          }
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
            <select class="form-control" id="pageChoisie" name="pageChoisie" required>
                <?php if(!isset($_POST['pageChoisie'])){ ?>
                  <option value="0">0</option>
                <?php }
                $tab = array();
                pages($tab, null, 'A', 1);
                /*$pagesImpossible = array();
                if(isset($_POST['para_1']) || isset($_POST['img_1'])){
                  $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
                  $req->execute(array(
                    "numero" => $_SESSION['id_hist']
                  )); CONTINUER CA*/
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
              <input type="text" name="para_<?= $i ?>" value="" class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Image<?= $i ?></label>
            <div class="col-sm-4">
              <input type="file" name="img_<?= $i ?>" />
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