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
    //Cas ou on démarre l'histoire
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $_SESSION['id_hist'] = (int) htmlspecialchars($_GET['id'],ENT_QUOTES, 'UTF-8', false);
      $res = $BDD->prepare("SELECT * FROM histoire WHERE id_hist = :idHist");
      $res->execute(array(
        'idHist' => $_SESSION['id_hist']
      ));
      $ligne = $res->fetch();
      $_SESSION['nom_hist'] = $ligne['nom_hist'];
    }
    if(isset($_GET['pageDebut'])){
      $pageHist = htmlspecialchars($_GET['pageDebut'],ENT_QUOTES, 'UTF-8', false);
      if($_GET['pageDebut'] === 0){
        echo $_GET['pageDebut'];
        $sql = "INSERT INTO hist_jouee (id_hist, id_user, choix_eff, nb_pts_vie, type_fin) VALUES (:idHist, :idUser, :choix, :nbPV, :fin)";
        $req = $BDD->prepare($sql);
        $req->execute(array(
          'idHist' => $_SESSION['id_hist'],
          'idUser' => $_SESSION['id_user'],
          'choix' => '0',
          'nbPV' => 3,
          'fin' => ''
        ));
      }
    }
    if(isset($_GET['nbPdv']) && $_GET['nbPdv'] >= 0 && $_GET['nbPdv'] <= 3){
      $_SESSION['nbpv'] = (int) htmlspecialchars($_GET['nbPdv'],ENT_QUOTES, 'UTF-8', false);
    }
    //Cas où on est en train de jouer
    else if (isset($_GET['idPageCible']) && !empty($_GET['idPageCible'])) {
      $pageHist = htmlspecialchars($_GET['idPageCible'],ENT_QUOTES, 'UTF-8', false);
      $res = $BDD->prepare("SELECT * FROM choix WHERE id_hist = :idHist AND id_page_cible = :idPageCible");
      $res->execute(array(
        'idHist' => $_SESSION['id_hist'],
        'idPageCible' => $pageHist
      ));
      $ligne = $res->fetch();
      $_SESSION['nbpv'] += $ligne['nb_pdv_perdu'];
      //Mise à jour des données dans la base de données
      $req2 = $BDD -> prepare("UPDATE hist_jouee SET choix_eff =:choix WHERE id_hist = :idHist AND id_user = :idUser"); 
      $req2->execute(array(
        'choix' => htmlspecialchars($_GET['idPageCible'], ENT_QUOTES, 'UTF-8', false),
        'idHist' => $_SESSION['id_hist'],
        'idUser' => $_SESSION['id_user']
      ));
      $req2 = $BDD -> prepare("UPDATE hist_jouee SET nb_pts_vie =:nbPV WHERE id_hist = :idHist AND id_user = :idUser"); 
      $req2->execute(array(
        'nbPV' => $_SESSION['nbpv'],
        'idHist' => $_SESSION['id_hist'],
        'idUser' => $_SESSION['id_user']
      ));
    } 
    else{ ?>
      <div class='row align-items-end'>
        <div class='col'>Le numéro d'histoire ou de page n'est pas renseigné, veuillez recommencer.</div>
        <a href='../index.php' class='btn btn-default btn-primary'>Retour accueil</a>
      </div>";
    <?php }
    if(isset($_SESSION['id_hist'])){
      $res = $BDD->prepare("SELECT * FROM page_hist WHERE id_page = :idPage AND id_hist = :idHist");
      $res->execute(array(
        'idPage' => $pageHist,
        'idHist' => $_SESSION['id_hist']
      ));
      $ligne = $res->fetch();
      for ($i = 1; $i <= 5; $i++) {
        $para = "para_" . $i;
        $image = "img_" . $i; ?>
        <div>
          <?= $ligne[$para]; ?>
        </div>
        <div>
          <!--remodifier le nom de la source-->
          <img src="../images/<?= $_SESSION['nom_hist']. '/'.$ligne[$image]; ?>" alt="<?= $ligne[$image]; ?>" />
        </div>
      <?php } ?>
      <div>
      <?php
      if ($_SESSION['nbpv'] == 0) {
        echo "Vous avez perdu."; 
        ?>
        <a class="btn btn-default btn-primary" href=<?="perdu.php" ?>>Fin de l'histoire</a>
        <?php
      }else{
      ?>
      </div>
      <?php
      $req2 = "SELECT * FROM choix WHERE id_page = '{$pageHist}' AND id_hist = {$_SESSION['id_hist']}";
      $res2 = $BDD->prepare($req2);
      $res2->execute();
      while ($ligne2 = $res2->fetch()) { ?>
        <div>
          <a class="btn btn-default btn-primary" href=<?= "jeu.php?idPageCible=" . $ligne2['id_page_cible']; ?> a> <?= $ligne2['id_page_cible']; ?> </a>
        </div>
      <?php }
      }
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