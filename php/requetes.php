<?php
  function afficherHistoireEnCours($BDD){
    $res = $BDD->prepare("SELECT * FROM hist_jouee WHERE id_user = :idUser");
    $res->execute(array(
      'idUser' => $_SESSION['id_user']
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
?>