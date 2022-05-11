<?php
session_start();
require_once("connect.php");
require_once("requetes.php");
require_once("listerPagesARemplir.php");
if ($BDD) {
  if (!isset($_POST['pageChoisie']) || isset($_SESSION['num_page'])) {
    $_SESSION['id_hist'] = recupererIdHistoire($BDD);
    unset($_SESSION['num_page']);
  } 
  else {
    if (verifierPresenceHistoire($BDD) == 0) {
      insererDonneesPage($BDD);
      if (verifierPresenceChoix($BDD) == 0) {
        insererChoixPage($BDD);
      }
    } 
  }
} ?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>
<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php'; 
    $tabPages = array();
    if($BDD) {
      include 'listerPagesRenseignees.php';
      $tabPages = afficherPagesRenseignees($BDD); ?>
    <div class="d-flex justify-content-center mt-5 px-5">
      <form class="form-horizontal w-75" role="form" enctype="multipart/form-data" action="ajout_page.php" method="post">
        <div class="form-group">
          Page à remplir</br>
          <select class="form-control w-50" id="pageChoisie" name="pageChoisie" required>
            <?php if (count($tabPages) == 0) { ?>
              <option value="0">0</option>
              <?php }
              $pagesARenseigner = afficherPagesARenseigner($BDD, $tabPages);
              foreach($pagesARenseigner as $page) { ?>
                <option value="<?= $page ?>"><?= $page ?></option>
            <?php } ?>
          </select>
        </div>
        <?php
        for ($i = 1; $i < 6; $i++) { ?>
          <div class="form-group mb-4">
            Paragraphe <?= $i ?></br>
            <input type="text" name="para_<?= $i ?>" value=" " class="form-control" placeholder="Ecrivez votre paragraphe" <?php if ($i == 1) { ?> <?php } ?> autofocus>
          </div>
          <div class="form-group mb-4">
            Image <?= $i ?></br>
            <input type="file" name="img_<?= $i ?>" />
          </div>
        <?php }
        ?>
        <div class="d-flex flex-column mt-3 mb-3">
          <?php for ($i = 1; $i < 4; $i++) { ?>
            <div class="d-flex flex-row mb-3">
              <div id="choix<?= $i ?>" class="col pr-5 pl-0">
                Choix <?= $i ?></br>
                <input type="text" name="choix<?= $i ?>" value="" class="form-control" placeholder="Ecrivez le choix <?= $i ?>" required autofocus>
              </div>
              <div class="d-flex flex-row pt-3">
                <input type="checkbox" id="fin<?= $i ?>" name="fin<?= $i ?>" value="<?= $i ?>" class="col-2">
                <label for="fin<?= $i ?>" class="col-8">Fin de l'histoire ?</label>
              </div>
            </div>
            <div class="d-flex flex-row mb-4">
              <div id="choix<?= $i ?>" class="col pr-2 pl-0">
                Nombre de points de vie perdus
              </div>
              <div class="d-flex flex-row pr-2">
                <?php for ($j=0; $j<4; $j++){ ?>
                  <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="<?= $j ?>" class="col-3 px-1" required autofocus>
                  <label class="mr-3" for="pdv<?= $i ?>"><?= $j ?></label>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-default btn-success m-1"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
        </div>
      </form>
    </div>
    <?php }
    include 'templatesHTML/footer.php'; ?>
  </div>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>