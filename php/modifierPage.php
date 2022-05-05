<?php
session_start();
require_once 'connect.php';?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
<div class="container">
  <?php include 'templatesHTML/navbar.php';
  if(isset($_POST['pageChoisie'])){
    $_SESSION['pageModifiee'] = $_POST['pageChoisie'];
    $req = "SELECT * FROM histoire WHERE id_hist = '{$_SESSION['id_hist']}'";
    $res = $BDD->query($req);
    $ligne = $res->fetch();
    $_SESSION['nom_hist'] = $ligne['nom_hist'];
  }
  else if(isset($_SESSION['pageModifiee'])){
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
        $_FILES[$nom]['name'] =  strtolower("img_{$_SESSION['id_hist']}_{$_POST['pageChoisie']}_{$cpt}" . substr($_FILES[$nom]['name'], strpos($_FILES[$nom]['name'], '.')));
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
  }
?>

  <div class="well">
    <?php 
    if(isset($_POST['pageChoisie'])){
       $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_page='{$_POST['pageChoisie']}' AND id_hist = '{$_SESSION['id_hist']}'");
       $req->execute();
       $ligne = $req->fetch();
    ?>
    <h2 class="text-center">Modification de la page <?= $_POST['pageChoisie'] ?></h2>
    <form class="form-horizontal" role="form" action="modifierPage.php" method="post">
      <input type="hidden" name="id" value="">
      <?php for ($i = 1; $i < 6; $i++) {
        $nomPara = "para_".$i; 
        $nomImg = "img_".$i;?>
      <div class="form-group">
        <label class="col-sm-4 control-label">Paragraphe <?= $i ?></label>
        <div class="col-sm-6">
          <input type="text" name="<?= $nomPara ?>" value="<?= $ligne[$nomPara]?>" class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?> <?php } ?> autofocus>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Image <?= $i ?></label>
        <div class="col-sm-4"> 
          <p>Image renseignée : <?= $ligne[$nomImg]?></p><!--Afficher le nom de l'image -->
          <input type="file" name="img_<?= $i ?>"/>
        </div>
      </div>
      <?php }  //Faire une requête pour récupérer le nom des choix
      $req = $BDD->prepare("SELECT * FROM choix WHERE id_page='{$_POST['pageChoisie']}' AND id_hist = '{$_SESSION['id_hist']}'");
      $req->execute();
      $i = 1;
      while($ligne = $req->fetch()){?>
      <div id="choix<?= $i ?>" class="form-group">
        <label class="col-sm-4 control-label">Choix <?= $i ?></label>
        <div class="col-sm-6">
          <input type="text" name="choix<?= $i ?>" value="<?=$ligne['contenu']?>" class="form-control" placeholder="Ecrivez le choix <?= $i ?>" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
        </div>
        <div class="col-sm-6">
          Nombre de points de vie perdus :
          <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="0" class="form-control" required <?php if ($ligne['nb_pdv_perdu'] == '0'){ echo 'checked' ; }?>>
          <label for="pdv<?= $i ?>">0</label>   
          <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="1" class="form-control" <?php if ($ligne['nb_pdv_perdu'] == -1){ echo 'checked' ; }?>>
          <label for="pdv<?= $i ?>">1</label> 
          <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="2" class="form-control" <?php if ($ligne['nb_pdv_perdu'] == -2){ echo 'checked' ; }?>>
          <label for="pdv<?= $i ?>">2</label> 
          <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="3" class="form-control" <?php if ($ligne['nb_pdv_perdu'] == -3){ echo 'checked' ; }?>>
          <label for="pdv<?= $i ?>">3</label>        
        </div>
      </div>
      <?php $i++; } ?>
      <div class="form-group">
        <div class="col-sm-4 col-sm-offset-4">
          <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
        </div>
      </div>
    </form>
  <?php } 
  else{
    header('Location:modifier.php');
    unset($_SESSION['pageModifiee']);
  }?>
  <?php include 'templatesHTML/footer.php'; ?>
</div>

<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>