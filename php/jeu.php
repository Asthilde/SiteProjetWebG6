<?php
session_start();
require_once("connect.php");
?>

<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class ="container">
  <?php include 'templatesHTML/navbar.php';

  if ($BDD) {
    $_SESSION['nbpv'] = 3;
    $pageHist;
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $_SESSION['idHist'] = htmlspecialchars($_GET['id'],ENT_QUOTES, 'UTF-8', false);
    }
    if (isset($_GET['idPageCible']) && !empty($_GET['idPageCible'])) {
      $pageHist = htmlspecialchars($_GET['idPageCible'],ENT_QUOTES, 'UTF-8', false);
      $req4 = "SELECT * FROM choix WHERE id_hist = {$_SESSION['idHist']} AND id_page_cible = '{$pageHist}'";
      $res4 = $BDD->prepare($req4);
      $res4->execute();
      $ligne4 = $res4->fetch();
      $_SESSION['nbpv'] += $ligne4['nb_pdv_perdu'];
      $req2 = $BDD -> prepare("UPDATE hist_jouee SET choix_eff =:choix WHERE id_hist = :idHist AND id_user = idUser"); 
      $req2->execute(array(
        'choix' => htmlspecialchars($_GET['idPageCible'], ENT_QUOTES, 'UTF-8', false),
        'idHist' => $_SESSION['idHist'],
        'idUser' => $_SESSION['']
      ));
    } 
    else if(isset($_GET['pageDebut'])){
      $pageHist = htmlspecialchars($_GET['pageDebut'],ENT_QUOTES, 'UTF-8', false);
      $_SESSION['nbpv'] = 3;
    }
    else{
      echo "<div class='row align-items-end'>
      <p class='col'>Le numéro d'histoire ou de page n'est pas renseigné, veuillez recommencer.</p>
      <a href='../index.php' class='btn btn-default btn-primary'>Retour accueil</a>
    </div>";
    }
    /*else {
      $req3 = "SELECT * FROM hist_jouee WHERE id_hist = {$_SESSION['idHist']}";
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
    }*/
    if(isset($_SESSION['idHist']) && isset($pageHist)){
      $req = "SELECT * FROM page_hist WHERE id_page = '{$pageHist}' AND id_hist = {$_SESSION['idHist']}";
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
      <div>
      <?php
      if ($_SESSION['nbpv'] == 0) { ?>
        <?= "Vous avez perdu."; ?>
      <?php
      }
      ?>
      </div>
      <?php
      $req2 = "SELECT * FROM choix WHERE id_page = '{$identPage}' AND id_hist = {$_SESSION['idHist']}";
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
    }
  } ?>

  <?php include 'templatesHTML/footer.php'; ?>
  </div>
  <!-- jQuery -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <!-- JavaScript Boostrap plugin -->
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>