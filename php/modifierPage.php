<?php
session_start();
require_once 'connect.php';?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
<div class="container">
  <?php include 'templatesHTML/navbar.php';
  if($BDD){
  if(isset($_POST['pageChoisie'])){
    $_SESSION['pageModifiee'] = $_POST['pageChoisie'];
    $req = "SELECT * FROM histoire WHERE id_hist = '{$_SESSION['id_hist']}'";
    $res = $BDD->query($req);
    $ligne = $res->fetch();
    $_SESSION['nom_hist'] = $ligne['nom_hist'];
  }
  else if(isset($_SESSION['pageModifiee'])){
<<<<<<< HEAD
    mettreAJourDonneesPage($BDD);
    $donneesChoix = afficherChoixPage($BDD, $_SESSION['pageModifiee'], $_SESSION['id_hist']);
    mettreAJourChoixPage($BDD, $donneesChoix);
=======
    for ($i = 1; $i < 6; $i++) {
      $nom = "para_" . $i;
      if (isset($_POST[$nom])) {
        $req = $BDD -> prepare("UPDATE page_hist SET {$nom}=:nomPara WHERE id_page =:nomPage  AND id_hist=:numHist"); 
        $req->execute(array(
          'nomPara' => htmlspecialchars($_POST[$nom], ENT_QUOTES, 'UTF-8', false),
          'nomPage' => $_SESSION['pageModifiee'],
          'numHist' => $_SESSION['id_hist']
        )); 
      }
    }
    for ($i = 1; $i < 6; $i++) {
      $nom = "img_" . $i;
      if (isset($_FILES[$nom]['name'])) {
        $_FILES[$nom]['name'] =  strtolower("img_{$_SESSION['id_hist']}_{$_SESSION['pageModifiee']}_{$i}" . substr($_FILES[$nom]['name'], strpos($_FILES[$nom]['name'], '.')));
        if (move_uploaded_file($_FILES[$nom]['tmp_name'], "../images/" . $_SESSION['nom_hist'] . '/' . $_FILES[$nom]['name'])) {
          $req = $BDD -> prepare("UPDATE page_hist SET {$nom} =:nomImg WHERE id_page =:nomPage  AND id_hist=:numHist"); 
          $req->execute(array(
            'nomImg' => $_FILES[$nom]['name'], //N'est pas renseigné dans la BDD
            'nomPage' => $_SESSION['pageModifiee'],
            'numHist' => $_SESSION['id_hist']
        ));
        }
      }
    }
    $req = $BDD->prepare("SELECT * FROM choix WHERE id_page='{$_SESSION['pageModifiee']}' AND id_hist = '{$_SESSION['id_hist']}'");
    $req->execute();
    $i = 1;
    while($ligne = $req->fetch()){
      $nom = "choix" . $i;
      $nomPdv = "pdv" . $i;
      if (isset($_POST[$nom])) {
        $req2 = $BDD -> prepare("UPDATE choix SET contenu =:texte WHERE id_page = '{$_SESSION['pageModifiee']}' AND id_page_cible = '{$ligne['id_page_cible']}'"); 
        $req2->execute(array(
          'texte' => htmlspecialchars($_POST[$nom], ENT_QUOTES, 'UTF-8', false)
        ));
      }
      if(isset($_POST[$nomPdv])){
        $req2 = $BDD -> prepare("UPDATE choix SET nb_pdv_perdu =:nbPdv WHERE id_page = '{$_SESSION['pageModifiee']}' AND id_page_cible = '{$ligne['id_page_cible']}'"); 
        $req2->execute(array(
          'nbPdv' => (-1*$_POST[$nomPdv])
        ));
      }
      $i++;
    }
>>>>>>> b9651dbab425bea5484d3b498dd4f211c2979ebd
    header('Location:modifier.php');
    unset($_SESSION['pageModifiee']);
  }
?>

<div class="d-flex flex-column mt-5 px-3">
  <?php 
  if(isset($_POST['pageChoisie'])){
<<<<<<< HEAD
    $page = afficherPageHistoire($BDD, $_POST['pageChoisie'], $_SESSION['id_hist']); ?>
    <div class="mb-5">
      <h2 class="text-center">Modification de la page <?= $_POST['pageChoisie'] ?></h2>
=======
      $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_page='{$_POST['pageChoisie']}' AND id_hist = '{$_SESSION['id_hist']}'");
      $req->execute();
      $ligne = $req->fetch();
  ?>
  <div class="mb-5">
    <h2 class="text-center">Modification de la page <?= $_POST['pageChoisie'] ?></h2>
  </div>
  <form class="form-horizontal" role="form" enctype="multipart/form-data" action="modifierPage.php" method="post">
    <?php for ($i = 1; $i < 6; $i++) {
      $nomPara = "para_".$i; 
      $nomImg = "img_".$i;?>
    <div class="form-group text-center mb-4">
      <div class="pb-1">
        Paragraphe <?= $i ?>
      </div>
      <input type="text" name="<?= $nomPara ?>" value="<?= $ligne[$nomPara]?>" class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?> <?php } ?> autofocus>
>>>>>>> b9651dbab425bea5484d3b498dd4f211c2979ebd
    </div>
    <div class="form-group text-center mb-4">
      <div class="pb-1">
        Image <?= $i ?>
      </div>
      <?php if (!empty($ligne[$nomImg])) { ?>
        <div class="pb-1"> 
          Image renseignée : <?= $ligne[$nomImg]?>
        </div>
      <?php } ?>   
      <input type="file" name="img_<?= $i ?>"/>
    </div>
    <?php }  //Faire une requête pour récupérer le nom des choix
    $req = $BDD->prepare("SELECT * FROM choix WHERE id_page='{$_POST['pageChoisie']}' AND id_hist = '{$_SESSION['id_hist']}'");
    $req->execute();
    $i = 1;
    while($ligne = $req->fetch()){?>
    <div id="choix<?= $i ?>" class="form-group text-center">
      <div class="d-flex flex-column mb-3">
        <div class="pb-1"> 
          Choix <?= $i ?>
        </div>
<<<<<<< HEAD
      <?php } 
      $tabChoix = afficherChoixPage($BDD, $_POST['pageChoisie'], $_SESSION['id_hist']);
      $i=1;
      foreach($tabChoix as $choix) { ?>
        <div id="choix<?= $i ?>" class="form-group text-center">
          <div class="d-flex flex-column mb-3">
            <div class="pb-1"> 
              Choix <?= $i ?>
            </div>
            <input type="text" name="choix<?= $i ?>" value="<?=$choix['contenu']?>" class="form-control" placeholder="Ecrivez le choix <?= $i ?>" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
          </div>
          <div class="d-flex flex-row justify-content-start mb-4">
            <div class="col-8 pr-2 pl-0">
              Nombre de points de vie perdus
            </div>
            <div class="d-flex flex-row pr-2">
              <?php for ($j=0; $j<4; $j++){ ?>
                <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="<?= $j ?>" class="col-3 px-1" <?php if($choix['nb_pdv_perdu'] == -1*$j){ echo "checked" ; } ?> required>
                <label class="mr-3" for="pdv<?= $i ?>"><?= $j ?></label>
              <?php } ?>
            </div>     
          </div>
=======
        <input type="text" name="choix<?= $i ?>" value="<?=$ligne['contenu']?>" class="form-control" placeholder="Ecrivez le choix <?= $i ?>" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
      </div>
      <div class="d-flex flex-row justify-content-start mb-4">
        <div class="col-8 pr-2 pl-0">
          Nombre de points de vie perdus
>>>>>>> b9651dbab425bea5484d3b498dd4f211c2979ebd
        </div>
        <div class="d-flex flex-row pr-2">
          <?php for ($j=0; $j<4; $j++){ ?>
            <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="<?= $j ?>" class="col-3 px-1" <?php if($ligne['nb_pdv_perdu'] == -1*$j){ echo "checked" ; } ?> required>
            <label class="mr-3" for="pdv<?= $i ?>"><?= $j ?></label>
          <?php } ?>
        </div>     
      </div>
    </div>
    <?php $i++; } ?>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-default btn-success m-1"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
    </div>
  </form>
  <?php } 
  }?>
  <?php include 'templatesHTML/footer.php'; ?>
</div>

<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>