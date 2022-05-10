<?php
function afficherPagesARenseigner($BDD, $tabPages){
  //Liste de toutes les pages possibles
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
  //On regarde quelles pages sont impossibles à avoir (fin prématurée, choix non écrit, ...) avec la BDD
  $pagesImpossibles = array();
  if ($BDD) {
    //On enlève les pages déja renseignées
    $pagesARenseigner = array_diff($pagesARenseigner, $tabPages);
    if (count($tabPages) > 0) {
      //On regarde parmi les choix déja renseignés pour voir les fins prématurées ou choix non écrits
      $req = $BDD->prepare("SELECT * FROM choix WHERE id_hist=:numero");
      $req->execute(array(
        "numero" => $_SESSION['id_hist']
      ));
      while ($ligne = $req->fetch()) {
        if ($ligne['id_page_cible'] == "FIN" || (empty($ligne['contenu']) || $ligne['contenu'] == ' ')) {
          //On parcourt les pages possibles pour enlever celles impossibles
          foreach ($pagesARenseigner as $pagePossible) {
            if(strpos($pagePossible, $ligne['id_page']) !== false){
              if((empty($ligne['contenu']) || $ligne['contenu'] == '') && strlen($pagePossible) > (2*strlen($ligne['id_page'])))
                array_push($pagesImpossibles, $pagePossible);
              else if ((!empty($ligne['contenu']) && $ligne['contenu'] != ' ') && strlen($pagePossible) > strlen($ligne['id_page']))
                array_push($pagesImpossibles, $pagePossible);
            }
          }
      }
      $pagesARenseigner = array_diff($pagesARenseigner, $pagesImpossibles);
    }
  }
  }
  return $pagesARenseigner;
} ?>