<?php include_once("requetes.php"); ?>
<h2 class="text-center">Ajout d'une page</h2>
<div class="d-flex flex-column justify-content-center mt-5 px-5">
  <div class="row text-align-center m-auto">
    Liste des choix déja renseignés :
    <?php
    $tabPages = afficherPagesRenseignees($BDD);
    foreach ($tabPages as $pageRenseignee) {
      echo ($pageRenseignee . ', ');
    }
    ?>
  </div>
  <div class="row text-align-center m-auto">
    <a href="fin_hist.php" class="btn btn-default btn-success mt-3"> Terminer l'histoire</a>
  </div>
</div>