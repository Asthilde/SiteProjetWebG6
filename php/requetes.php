<?php
  function afficherHistoireEnCours($BDD, $idUser){
    $res = $BDD->prepare("SELECT * FROM hist_jouee WHERE id_user = :idUser");
    $res->execute(array(
      'idUser' => $idUser
    ));
    return $res->fetchAll();
  }

  function afficherInfosHistoire($BDD, $idHist){
    $res = $BDD->prepare("SELECT * FROM histoire WHERE id_hist = :idHist");
    $res->execute(array(
      'idHist' => $idHist
    ));
    return $res->fetch();
  }

  function afficherPseudoUser($BDD, $idCrea){
    $res = $BDD->prepare("SELECT pseudo FROM user WHERE id_user = :idCrea");
    $res->execute(array(
      'idCrea' => (int) $idCrea
    ));
    $tab = $res->fetch();
    return $tab['pseudo'];
  }

  function afficherHistoires($BDD){
    $res = $BDD->query("SELECT * FROM histoire ORDER BY nom_hist");
    return $res->fetchAll();
  }

  function recupererPDVPerdus($BDD, $pageHist){
    $res = $BDD->prepare("SELECT nb_pdv_perdu FROM choix WHERE id_hist = :idHist AND id_page_cible = :idPageCible");
    $res->execute(array(
      'idHist' => $_SESSION['id_hist'],
      'idPageCible' => $pageHist
    ));
    $ligne = $res->fetch();
    return $ligne['nb_pdv_perdu'];
  }

  function afficherPageHistoire($BDD, $pageHist){
    $res = $BDD->prepare("SELECT * FROM page_hist WHERE id_page = :idPage AND id_hist = :idHist");
    $res->execute(array(
      'idPage' => $pageHist,
      'idHist' => $_SESSION['id_hist']
    ));
    return $res->fetch();
  }

  function afficherChoixPage($BDD, $pageHist){
    $res = $BDD->prepare("SELECT * FROM choix WHERE id_page = :idPage AND id_hist = :idHist");
    $res->execute(array(
      'idPage' => $pageHist,
      'idHist' => $_SESSION['id_hist']
    ));
    return $res->fetchAll();
  }

  function insererDebuterHistoire($BDD, $pageHist){
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

  function mettreAJourDonneesHistoireEnCours($BDD, $pageChoisie){
    $req = $BDD->prepare("UPDATE hist_jouee SET choix_eff =:choix WHERE id_hist = :idHist AND id_user = :idUser");
    $req->execute(array(
      'choix' => $pageChoisie,
      'idHist' => $_SESSION['id_hist'],
      'idUser' => $_SESSION['id_user']
    ));
    $req2 = $BDD->prepare("UPDATE hist_jouee SET nb_pts_vie =:nbPV WHERE id_hist = :idHist AND id_user = :idUser");
    $req2->execute(array(
      'nbPV' => $_SESSION['nbpv'],
      'idHist' => $_SESSION['id_hist'],
      'idUser' => $_SESSION['id_user']
    ));
  }
?>