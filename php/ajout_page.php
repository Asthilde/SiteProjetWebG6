<?php
session_start();
require_once("connect.php");
if ($BDD) {
  if (!isset($_POST['pageChoisie']) || isset($_SESSION['num_page'])) {
    $req2 = "SELECT * FROM histoire WHERE nom_hist = '{$_SESSION['nom_hist']}'";
    $res2 = $BDD->query($req2);
    $idHist = $res2->fetch();
    $_SESSION['id_hist'] = $idHist['id_hist'];
    unset($_SESSION['num_page']);
  } else {
    //echo $_SESSION['id_hist'];
    $req = $BDD->prepare("SELECT COUNT(*) as nb FROM page_hist WHERE id_page='{$_POST['pageChoisie']}' AND id_hist = '{$_SESSION['id_hist']}'");
    $req->execute();
    $ligne = $req->fetch();
    if ($ligne['nb'] == 0) {
      $cpt = 1;
      $tab = array(
        'numero' => $_POST['pageChoisie'],
        'numHist' => (int)$_SESSION['id_hist'],
        'para_1' => '',
        'para_2' => '',
        'para_3' => '',
        'para_4' => '',
        'para_5' => '',
        'img_1' => '',
        'img_2' => '',
        'img_3' => '',
        'img_4' => '',
        'img_5' => ''
      );
      for ($i = 1; $i < 6; $i++) {
        $nom = "para_" . $i;
        if (isset($_POST[$nom])) {
          $tab[$nom] = htmlspecialchars($_POST[$nom], ENT_QUOTES, 'UTF-8', false);
        }
      }
      for ($i = 1; $i < 6; $i++) {
        $nom = "img_" . $i;
        if (isset($_FILES[$nom])) {
          $_FILES[$nom]['name'] =  strtolower("img_{$_SESSION['id_hist']}_{$_POST['pageChoisie']}_{$cpt}" . substr($_FILES[$nom]['name'], strpos($_FILES[$nom]['name'], '.')));
          if (move_uploaded_file($_FILES[$nom]['tmp_name'], "../images/" . $_SESSION['nom_hist'] . '/' . $_FILES[$nom]['name'])) {
            $tab[$nom] = $_FILES[$nom]['name'];
          }
        }
      }
      $sql = "INSERT INTO page_hist (id_page, id_hist, para_1, para_2, para_3, para_4, para_5, img_1, img_2, img_3, img_4, img_5) VALUES (:numero, :numHist, :para_1, :para_2, :para_3, :para_4, :para_5, :img_1, :img_2, :img_3, :img_4, :img_5)";
      $req = $BDD->prepare($sql);
      $req->execute($tab);

      $req2 = $BDD->prepare("SELECT COUNT(*) as nb FROM choix WHERE id_page='{$_POST['pageChoisie']}' AND id_page_cible ='FIN' AND id_hist = '{$_SESSION['id_hist']}'");
      $req2->execute();
      $ligne2 = $req2->fetch();
      if ($ligne2['nb'] == 0) {
        echo "Je rentre ici";
        for ($i = 1; $i < 4; $i++) {
          $nom = "choix" . $i;
          if ($_POST['pageChoisie'] == '0') {
            $nivSuiv = 'A';
            $nomPageCible = 'A' . $i;
          } else {
            $nivSuiv = chr(ord(substr($_POST['pageChoisie'], -2, 1)) + 1);
            $nomPageCible = $_POST['pageChoisie'] . $nivSuiv . $i;
          }
          $nomPdv = "pdv" . $i;
          $nomChoix = "fin" . $i;
          $sql = "INSERT INTO choix (id_page, id_page_cible, id_hist, contenu, nb_pdv_perdu) VALUES (:numPage, :numPageCible, :numHist, :choix, :nbPdv)";
          $req = $BDD->prepare($sql);
          $req->execute(array(
            'numPage' => $_POST['pageChoisie'],
            'numPageCible' => $nomPageCible,
            'numHist' => $_SESSION['id_hist'],
            'choix' => $_POST[$nom],
            'nbPdv' => (-1 * $_POST[$nomPdv])
          ));
          if (isset($_POST[$nomChoix]) || strlen($nomPageCible) == 8) {
            $req = $BDD->prepare($sql);
            $req->execute(array(
              'numPage' => $nomPageCible,
              'numPageCible' => 'FIN',
              'numHist' => $_SESSION['id_hist'],
              'choix' => '',
              'nbPdv' => 0
            ));
          } else {
            echo "Je ne rentre pas pour les choix";
          }
        }
      }
    } else {
      echo "Les données existent déja dans la base !"; ?>
      <a href="ajout_page.php">CONTINUER</a>
      <a href="fin_hist.php">TERMINER L'HISTOIRE</a>
<?php
    }
  }
}
?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
  <div class="container">
    <?php include 'templatesHTML/navbar.php'; ?>
    <h2 class="text-center">Ajout d'une page</h2>
    <div class="d-flex flex-column justify-content-center mt-5 px-5">
      <div class="row text-align-center m-auto">
        Liste des choix déja renseignés :
        <?php $tabPages = array();
        if ($BDD) {
          $req = $BDD->prepare("SELECT * FROM page_hist WHERE id_hist=:numero");
          $req->execute(array(
            "numero" => $_SESSION['id_hist']
          ));
          while ($ligne = $req->fetch()) {
            array_push($tabPages, $ligne['id_page']);
          }
          foreach ($tabPages as $pageRenseignee) {
            echo ($pageRenseignee . ', ');
          }
        } ?>
      </div>
      <div class="row text-align-center m-auto">
        <a href="fin_hist.php" class="btn btn-default btn-success m-1"> Terminer l'histoire</a>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-5 px-5">
      <form class="form-horizontal w-75" role="form" enctype="multipart/form-data" action="ajout_page.php" method="post">
        <div class="form-group">
          Page à remplir</br>
          <select class="form-control w-25" id="pageChoisie" name="pageChoisie" required>
            <?php if (count($tabPages) == 0) { ?>
              <option value="0">0</option>
              <?php }
            $pagesARenseigner = array(
              "A1", "A2", "A3",
              "A1B1", "A1B2", "A1B3", "A2B1", "A2B2", "A2B3", "A3B1", "A3B2", "A3B3",
              "A1B1C1", "A1B1C2", "A1B1C3", "A1B2C1", "A1B2C2", "A1B2C3", "A1B3C1", "A1B3C2", "A1B3C3",
              "A2B1C1", "A2B1C2", "A2B1C3", "A2B2C1", "A2B2C2", "A2B2C3", "A2B3C1", "A2B3C2", "A2B3C3",
              "A3B1C1", "A3B1C2", "A3B1C3", "A3B2C1", "A3B2C2", "A3B2C3", "A3B3C1", "A3B3C2", "A3B3C3",
              "A1B1C1D1", "A1B1C1D2", "A1B1C1D3", "A1B1C2D1", "A1B1C2D2", "A1B1C2D3", "A1B1C3D1", "A1B1C3D2", "A1B1C3D3",
              "A1B2C1D1", "A1B2C1D2", "A1B2C1D3", "A1B2C2D1", "A1B2C2D2", "A1B2C2D3", "A1B2C3D1", "A1B2C3D2", "A1B2C3D3",
              "A1B3C1D1", "A1B3C1D2", "A1B3C1D3", "A1B3C2D1", "A1B3C2D2", "A1B3C2D3", "A1B3C3D1", "A1B3C3D2", "A1B3C3D3",
              "A2B1C1D1", "A2B1C1D2", "A2B1C1D3", "A2B1C2D1", "A2B1C2D2", "A2B1C2D3", "A2B1C3D1", "A2B1C3D2", "A2B1C3D3",
              "A2B2C1D1", "A2B2C1D2", "A2B2C1D3", "A2B2C2D1", "A2B2C2D2", "A2B2C2D3", "A2B2C3D1", "A2B2C3D2", "A2B2C3D3",
              "A3B3C1D1", "A3B3C1D2", "A3B3C1D3", "A3B3C2D1", "A3B3C2D2", "A3B3C2D3", "A3B3C3D1", "A3B3C3D2", "A3B3C3D3",
            );
            $pagesImpossibles = array();
            if ($BDD) {
              if (count($tabPages) > 0) {
                $req = $BDD->prepare("SELECT * FROM choix WHERE id_hist=:numero");
                $req->execute(array(
                  "numero" => $_SESSION['id_hist']
                ));
                while ($ligne = $req->fetch()) {
                  if ($ligne['id_page_cible'] == "FIN") {
                    foreach ($pagesARenseigner as $pagesPossibles) {
                      if ((strpos($pagesPossibles, $ligne['id_page']) !== false && strlen($pagesPossibles) > strlen($ligne['id_page'])))
                        array_push($pagesImpossibles, $pagesPossibles);
                    }
                  }
                }
                $pagesARenseigner = array_diff($pagesARenseigner, $pagesImpossibles);
              }
            }
            foreach ($pagesARenseigner as $page) {
              $dejaRenseigne = false;
              foreach ($tabPages as $pageRenseignee) {
                if ($page == $pageRenseignee) {
                  $dejaRenseigne = true;
                  break;
                }
              }
              if (!$dejaRenseigne) { ?>
                <option value="<?= $page ?>"><?= $page ?></option>
            <?php }
            }
            ?>
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
        <?php } //Trouver un moyen de gérer l'affichage si on a rentré tous les choix possibles
        ?>
        <div class="d-flex flex-column mt-3 mb-3">
          <?php for ($i = 1; $i < 4; $i++) { ?>
            <div class="d-flex flex-row mb-3">
              <div id="choix<?= $i ?>" class="col pr-5 pl-0">
                Choix <?= $i ?></br>
                <input type="text" name="choix<?= $i ?>" value="" class="form-control" placeholder="Ecrivez le choix <?= $i ?>" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
              </div>
              <div class="d-flex flex-row pt-3">
                <input type="checkbox" id="fin<?= $i ?>" name="fin<?= $i ?>" value="<?= $i ?>" class="col-2">
                <label for="fin<?= $i ?>" class="col-8">Fin de l'histoire ?</label>
              </div>
            </div>
            <div class="d-flex flex-row mb-4">
              <div id="choix<?= $i ?>" class="col-7 pr-2 pl-0">
                Nombre de points de vie perdus
              </div>
              <!--Voir si on fait des div pour réunir le radio avec le label-->
              <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="0" class="col pl-3" required>
              <label for="pdv<?= $i ?>">0</label>
              <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="1" class="col pl-3">
              <label for="pdv<?= $i ?>">1</label>
              <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="2" class="col pl-3">
              <label for="pdv<?= $i ?>">2</label>
              <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="3" class="col pl-3">
              <label for="pdv<?= $i ?>">3</label>
            </div>
          <?php } ?>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-default btn-success m-1"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
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