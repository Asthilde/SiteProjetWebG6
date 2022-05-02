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
      <form class="form-horizontal" role="form" enctype="multipart/form-data" action="modifier.php" method="post">
        <input type="hidden" name="id" value="">
        <!--Faire du JS si possible pour afficher les éléments déja renseignés et les nouveaux à renseigner sinon faire une page accueil choix de la page et une page pour renseigner les infos -->
        <div class="form-group">
          <label class="col-sm-4 control-label">Page à modifier</label>
          <div class="col-sm-6">
            <select class="form-control" id="pageChoisie" name="pageChoisie" required>
              <?php if (isset($_GET['id']) && !empty($_GET['id'])) {
                $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
                $req->execute(array(
                  "numero" => $_GET['id']
                ));
                while ($ligne = $req->fetch()) {?>
                  <option value="<?= $ligne['id_page'] ?>"><?= $ligne['id_page'] ?></option>
                <?php }} ?>
            </select>
          </div>
        </div>
        <?php for ($i = 1; $i < 6; $i++) { ?>
        <div class="form-group">
          <label class="col-sm-4 control-label">Paragraphe <?= $i ?></label>
          <div class="col-sm-6">
            <input type="text" name="para_<?= $i ?>" value=" " class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?> <?php } ?> autofocus>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">Image <?= $i ?></label>
          <div class="col-sm-4">
            <input type="file" name="img_<?= $i ?>" />
          </div>
        </div>
        <?php } ?>
        <?php for ($i = 1; $i < 4; $i++) { ?>
        <div class="form-group">
          <label class="col-sm-4 control-label">Choix <?= $i ?> (si c'est la fin de la branche écrire FIN dans l'encadré)</label>
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