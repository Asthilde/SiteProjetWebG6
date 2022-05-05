<?php
session_start();
require_once("connect.php");
?>


<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <?php include 'templatesHTML/navbar.php';

  if ($BDD) {

    if (isset($_GET['id'])) {
      $_SESSION['notreId'] = $_GET['id'];
    }

    $_SESSION['nbpv'] = 3;
    $pageHist;
    if (isset($_GET['idPageCible'])) {
      $pageHist = $_GET['idPageCible'];
      $req4 = "SELECT * FROM choix WHERE id_hist = '{$_SESSION['notreId']}' AND id_page_cible = '{$pageHist}'";
      $res4 = $BDD->prepare($req4);
      $res4->execute();
      $ligne4 = $res4->fetch();
      $_SESSION['nbpv'] += $ligne4['nb_pdv_perdu'];
    } else {
      $req3 = "SELECT * FROM hist_jouee WHERE id_hist = '{$_SESSION['notreId']}'";
      $res3 = $BDD->prepare($req3);
      $res3->execute();
      $ligne3 = $res3->fetch();
      if (isset($ligne3['choix_eff'])) {
        $pageHist = $ligne3['choix_eff'];
        $_SESSION['nbpv'] += $ligne3['nb_pts_vie'];
      } else {
        $pageHist = '0';
        $_SESSION['nbpv'] = 3;
      }
    }


    $req = "SELECT * FROM page_hist WHERE id_page = '{$pageHist}' AND id_hist = '{$_SESSION['notreId']}'";
    $res = $BDD->prepare($req);
    $res->execute();
    $ligne = $res->fetch();
    $identPage = $ligne["id_page"];
    for ($i = 1; $i <= 5; $i++) {
      $para = "para_" . $i;
      $image = "img_" . $i; ?>
      <div>
        <?= $ligne[$para]; ?>
      </div>
      <div>
        <!--remodifier le nom de la source-->
        <img src="../images/moi aussi je suis un test/<?= $ligne[$image]; ?>" alt="<?= $ligne[$image]; ?>" />
      </div>
    <?php } ?>

  <?php } ?>

  <div>
    <?php
    if ($_SESSION['nbpv'] == 0) { ?>
      <?= "Vous avez perdu."; ?>
    <?php
    }
    ?>
  </div>

  <?php

  if ($BDD) {
    $req2 = "SELECT * FROM choix WHERE id_page = '{$identPage}' AND id_hist = '{$_SESSION['notreId']}'";
    $res2 = $BDD->prepare($req2);
    $res2->execute();
    while ($ligne2 = $res2->fetch()) { ?>
      <div>
        <a href=<?= "jeu.php?idPageCible=" . $ligne2['id_page_cible']; ?> a> <?= $ligne2['id_page_cible']; ?> </a>

      </div>
      <div>
        <?php echo $_SESSION['nbpv']; ?>
      </div>
  <?php }
  } ?>

  <?php include 'templatesHTML/footer.php'; ?>

  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>