<?php
session_start();
require_once 'connect.php';
require_once 'requetes.php'; ?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>
<body>
<div class="container">
  <?php include 'templatesHTML/navbar.php';
  if($BDD){
  if(isset($_POST['pageChoisie'])){
    $_SESSION['pageModifiee'] = $_POST['pageChoisie'];
    $histoire = afficherInfosHistoire($BDD, $_SESSION['id_hist']);
    $_SESSION['nom_hist'] = $histoire['nom_hist'];
  }
  else if(isset($_SESSION['pageModifiee'])){
    mettreAJourDonneesPage($BDD);
    $donneesChoix = afficherChoixPage($BDD, $_SESSION['pageModifiee']);
    mettreAJourChoixPage($BDD, $donneesChoix);
    header('Location:modifier.php');
    unset($_SESSION['pageModifiee']);
  }
?>
<div class="d-flex flex-column mt-5 px-3">
  <?php 
  if(isset($_POST['pageChoisie'])){
    $page = afficherPageHistoire($BDD, $_POST['pageChoisie']); ?>
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
          <input type="text" name="<?= $nomPara ?>" value="<?= $page[$nomPara]?>" class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?> <?php } ?> autofocus>
        </div>
        <div class="form-group text-center mb-4">
          <div class="pb-1">
            Image <?= $i ?>
          </div>
          <?php if (!empty($page[$nomImg])) { ?>
            <div class="pb-1"> 
              Image renseignée : <?= $page[$nomImg]?>
            </div>
          <?php } ?>   
          <input type="file" name="img_<?= $i ?>"/>
        </div>
      <?php } 
      $tabChoix = afficherChoixPage($BDD, $_POST['pageChoisie']);
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
        </div>
        <?php $i++; 
      } ?>
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