<?php
session_start();
require_once("connect.php");
require_once('requetes.php');
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
      //Cas ou l'utilisateur démarre une histoire
      if (isset($_GET['id']) && !empty($_GET['id'])) {
        $_SESSION['id_hist'] = (int) htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8', false);
        $infosHist = afficherInfosHistoire($BDD,  $_SESSION['id_hist']);
        $_SESSION['nom_hist'] = $infosHist['nom_hist'];
        $infosHistEnCours = afficherInfosHistEnCours($BDD, $_SESSION['id_user']);
        //Lorsqu'il reprend une histoire en cours de partie
        if(isset($infosHistEnCours) && !empty($infosHistEnCours)){
          $_SESSION['nbpv'] = (int) $infosHistEnCours['nb_pts_vie'];
          $pageHist = $infosHistEnCours['choix_eff'];
          $_SESSION['choix'] = $infosHistEnCours['choix'];
        } 
        else { //Lorsqu'il démarre une nouvelle histoire
          $pageHist = '0';
          $_SESSION['choix'] = '0';
          insererDebuterHistoire($BDD, $pageHist);
        }
      }
      //Cas où on est en train de jouer
      else if (isset($_GET['idPageCible']) && (!empty($_GET['idPageCible']) || $_GET['idPageCible'] == '0')) {
        $pageHist = htmlspecialchars($_GET['idPageCible'], ENT_QUOTES, 'UTF-8', false);
        $_SESSION['nbpv'] += recupererPDVPerdus($BDD, $pageHist);
        $_SESSION['choix'] .= ' ' . $pageHist;
        $pageChoisie = htmlspecialchars($_GET['idPageCible'], ENT_QUOTES, 'UTF-8', false);
        mettreAJourDonneesHistoireEnCours($BDD, $pageChoisie);
      } 
      else { ?>
        <div class='d-flex flex-row justify-content-center m-3'>
          <div class='col'>Le numéro d'histoire ou de page n'est pas renseigné, veuillez recommencer.</div>
          <a href='../index.php' class='btn btn-default btn-success'>Retour accueil</a>
        </div>
        <?php echo "</div>";
      }

      if (isset($_SESSION['id_hist']) && isset($pageHist) && (!empty($pageHist) || $pageHist == 0)) {
        $infosPage = afficherPageHistoire($BDD, $pageHist);
        for ($i = 1; $i <= 5; $i++) {
          $para = "para_" . $i;
          $image = "img_" . $i; 
          if ($infosPage[$para] != ' ' && !empty($infosPage[$para])) { ?>
            <div class='d-flex flex-row justify-content-center my-5 mx-2'>
              <?= $infosPage[$para]; ?>
            </div>
          <?php }
          if ($infosPage[$image] != ' ' && !empty($infosPage[$image])) { ?>
            <div class='d-flex flex-row justify-content-center m-3'>
              <img src="../images/<?= $_SESSION['nom_hist'] . '/' . $infosPage[$image]; ?>" alt="<?= "../images/" . $_SESSION['nom_hist'] . "/" . $infosPage[$image]; ?>" class="w-100" />
            </div>
          <?php }
        }
        if ($_SESSION['nbpv'] == 0) { ?>
          <div class='d-flex flex-column m-auto'>
            <div class="m-auto pb-1">
              Vous avez perdu...
            </div>
            <div class="m-auto pb-2">
              Vous avez fait les choix suivants : <?= $_SESSION['choix'] ;?>
            </div>
            <div class="m-auto">
              <a class="btn btn-default btn-success" href=<?= "fin.php" ?>>Fin de l'histoire</a>
            </div>
          </div>
        <?php } 
        else {
          $choixPage = afficherChoixPage($BDD, $pageHist);?>
          <div class='d-flex justify-content-center'>
            <?php foreach($choixPage as $choix) {
               if ($choix['id_page_cible'] == 'FIN') { 
                 $_SESSION['gagne'] = 1 ;?>
                <div class='d-flex flex-column p-2 m-auto'>
                  <div class="m-auto pb-1">
                    Vous avez gagné !
                  </div>
                  <div class="m-auto pb-2">
                    Vous avez fait les choix suivants : <?= $_SESSION['choix'] ;?>
                  </div>
                  <div class="m-auto">
                    <a class="btn btn-default btn-success p-2" href=<?= "fin.php" ?>>Fin de l'histoire</a>
                  </div>
                </div>
              <?php break;
              } 
              else { 
                if(!empty($choix['contenu'])) {?>
                  <div class='flex-row m-auto'>
                    <a class="btn btn-default btn-success p-2 m-2" href=<?= "jeu.php?idPageCible=" . $choix['id_page_cible']; ?> a> <?= $choix['contenu']; ?> </a>
                  </div>
                <?php } 
                }
            } ?>
          </div>
          <div class='flex-row text-center mt-2'>
            Il vous reste <?= $_SESSION['nbpv'] ?> points de vie.
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