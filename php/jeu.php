<?php
session_start();
require_once("connect.php");
?>

<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>
<!-- Faire une variable de session string avec la liste des choix !-->
<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php';
    if ($BDD) {
      $_SESSION['nbpv'] = 3;
      $pageHist;
      //Cas ou on démarre l'histoire
      if (isset($_GET['id']) && !empty($_GET['id'])) {
        $_SESSION['id_hist'] = (int) htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8', false);
        if (isset($_GET['nbPdv']) && $_GET['nbPdv'] >= 0 && $_GET['nbPdv'] <= 3 && isset($_GET['pageDebut'])) {
          $res = $BDD->prepare("SELECT * FROM histoire WHERE id_hist = :idHist");
          $res->execute(array(
            'idHist' => $_SESSION['id_hist']
          ));
          $ligne = $res->fetch();
          $_SESSION['nom_hist'] = $ligne['nom_hist'];
          $_SESSION['nbpv'] = (int) htmlspecialchars($_GET['nbPdv'], ENT_QUOTES, 'UTF-8', false);
          $pageHist = $_GET['pageDebut'];
        } else {
          $pageHist = 0;
          $_SESSION['nbpv'] = 3;
          try {
            $sql = "INSERT INTO hist_jouee (id_hist, id_user, choix_eff, nb_pts_vie, type_fin) VALUES (:idHist, :idUser, :choix, :nbPV, :fin)";
            $req = $BDD->prepare($sql);
            $req->execute(array(
              'idHist' => $_SESSION['id_hist'],
              'idUser' => $_SESSION['id_user'],
              'choix' => $pageHist,
              'nbPV' => 3,
              'fin' => ''
            ));
          } catch (Exception $e) {
            echo 'Histoire déja dans la base';
          }
        }
      }
      //Cas où on est en train de jouer
      else if (isset($_GET['idPageCible']) && (!empty($_GET['idPageCible'])) || $_GET['idPageCible'] == '0') {
        $pageHist = htmlspecialchars($_GET['idPageCible'], ENT_QUOTES, 'UTF-8', false);
        $res = $BDD->prepare("SELECT * FROM choix WHERE id_hist = :idHist AND id_page_cible = :idPageCible");
        $res->execute(array(
          'idHist' => $_SESSION['id_hist'],
          'idPageCible' => $pageHist
        ));
        $ligne = $res->fetch();
        $_SESSION['nbpv'] += $ligne['nb_pdv_perdu'];
        //Mise à jour des données dans la base de données
        $req2 = $BDD->prepare("UPDATE hist_jouee SET choix_eff =:choix WHERE id_hist = :idHist AND id_user = :idUser");
        $req2->execute(array(
          'choix' => htmlspecialchars($_GET['idPageCible'], ENT_QUOTES, 'UTF-8', false),
          'idHist' => $_SESSION['id_hist'],
          'idUser' => $_SESSION['id_user']
        ));
        $req2 = $BDD->prepare("UPDATE hist_jouee SET nb_pts_vie =:nbPV WHERE id_hist = :idHist AND id_user = :idUser");
        $req2->execute(array(
          'nbPV' => $_SESSION['nbpv'],
          'idHist' => $_SESSION['id_hist'],
          'idUser' => $_SESSION['id_user']
        ));
      } else { ?>
        <div class='d-flex flex-row justify-content-center m-3'>
          <div class='col'>Le numéro d'histoire ou de page n'est pas renseigné, veuillez recommencer.</div>
          <a href='../index.php' class='btn btn-default btn-success'>Retour accueil</a>
        </div>
        <?php echo "</div>";
      }
      if (isset($_SESSION['id_hist']) && (!empty($pageHist) || $pageHist == 0)) {
        $res = $BDD->prepare("SELECT * FROM page_hist WHERE id_page = :idPage AND id_hist = :idHist");
        $res->execute(array(
          'idPage' => $pageHist,
          'idHist' => $_SESSION['id_hist']
        ));
        $ligne = $res->fetch();
        for ($i = 1; $i <= 5; $i++) {
          $para = "para_" . $i;
          $image = "img_" . $i; ?>
          <?php if ($ligne[$para] != ' ' && !empty($ligne[$para])) { ?>
            <div class='d-flex flex-row justify-content-center my-5 mx-2'>
              <?= $ligne[$para]; ?>
            </div>
          <?php }
          if ($ligne[$image] != ' ' && !empty($ligne[$image])) { ?>
            <div class='d-flex flex-row justify-content-center m-3'>
              <img src="../images/<?= $_SESSION['nom_hist'] . '/' . $ligne[$image]; ?>" alt="<?= "../images/" . $_SESSION['nom_hist'] . "/" . $ligne[$image]; ?>" class="w-100" />
            </div>
          <?php }
        }
        if ($_SESSION['nbpv'] == 0) { ?>
          <div class='d-flex flex-column m-auto'>
            <div class="m-auto pb-2">
              Vous avez perdu...
            </div>
            <div class="m-auto">
              <a class="btn btn-default btn-success" href=<?= "perdu.php" ?>>Fin de l'histoire</a>
            </div>
          </div>
        <?php
        } else {
          $req2 = "SELECT * FROM choix WHERE id_page = '{$pageHist}' AND id_hist = {$_SESSION['id_hist']}";
          $res2 = $BDD->prepare($req2);
          $res2->execute(); ?>
          <div class='d-flex justify-content-center'>
            <?php while ($ligne2 = $res2->fetch()) { 
               if ($ligne2['id_page_cible'] == 'FIN') { ?>
                <div class='d-flex flex-column p-2 m-auto'>
                  <!--Il faudra voir comment on gère avec bootstrap -->
                  <div class="m-auto pb-2">
                    Vous avez gagné !
                  </div>
                  <div class="m-auto">
                    <a class="btn btn-default btn-success p-2" href=<?= "gagne.php" ?>>Fin de l'histoire</a>
                  </div>
                </div>
              <?php break;
              } else { ?>
                <div class='flex-row m-auto'>
                  <!--Il faudra voir comment on gère avec bootstrap -->
                  <a class="btn btn-default btn-success p-2 m-2" href=<?= "jeu.php?idPageCible=" . $ligne2['id_page_cible']; ?> a> <?= $ligne2['contenu']; ?> </a>
                </div>
            <?php }
            } ?>
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