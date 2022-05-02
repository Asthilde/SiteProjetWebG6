<?php
session_start();
require_once 'connect.php' ?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
<div class="container">
  <?php include 'templatesHTML/navbar.php'; ?>
  <!--Faire un form pour modifier les valeurs et faire le php pour envoyer ça -->
  <div class="well">
    <?php if(isset($_POST['pageChoisie'])){
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
            <p>Image renseignée :</p><!--Afficher le nom de l'image -->
            <input type="file" name="img_<?= $i ?>"/>
          </div>
        </div>
        <?php } ?>
        <?php //Faire une requête pour récupérer le nom des choix
        $req = $BDD->prepare("SELECT * FROM choix WHERE id_page='{$_POST['pageChoisie']}' AND id_hist = '{$_SESSION['id_hist']}'");
        $req->execute();
        $i = 1;
        while($ligne = $req->fetch()){
        ?>
        <div class="form-group">
          <label class="col-sm-4 control-label">Choix <?= $i ?></label>
          <div class="col-sm-6">
            <input type="text" name="choix<?= $i ?>" value="<?= $ligne['contenu']?>" class="form-control" placeholder="Ecrivez le choix<?= $i ?>" required autofocus>
          </div>
          <div class="col-sm-6">
            <input type="checkbox" id="fin" name="fin<?= $i ?>" value="<?= $i ?>" class="form-control">
            <label for="fin<?= $i ?>">Fin de l'histoire ?</label>
          </div>
        </div>
        <?php $i++; }?>
        <div class="form-group">
          <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
          </div>
        </div>
      </form>
      <?php } ?>
    </div>
  <?php include 'templatesHTML/footer.php'; ?>
</div>

<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>