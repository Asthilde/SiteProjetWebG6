<?php
  function afficherHistoireEnCours($BDD, $idUser){
    $res = $BDD->prepare("SELECT * FROM hist_jouee WHERE id_user = :idUser");
    $res->execute(array(
      'idUser' => $idUser
    ));
    return $res->fetchAll();
  }

  function afficherInfosHistEnCours($BDD, $idUser, $idHist){
    $res = $BDD->prepare("SELECT * FROM hist_jouee WHERE id_user = :idUser and id_hist = :idHist");
    $res->execute(array(
      'idUser' => $idUser,
      'idHist' =>  $idHist
    ));
    return $res->fetch();
  }

  function afficherInfosHistoire($BDD, $idHist){
    $res = $BDD->prepare("SELECT * FROM histoire WHERE id_hist = :idHist");
    $res->execute(array(
      'idHist' => $idHist
    ));
    return $res->fetch();
  }

  function obtenirUser($BDD, $nomUser){
    $req = $BDD->prepare("SELECT * FROM user WHERE pseudo=:nomUser");
    $req->execute(array(
      "nomUser" => $nomUser,
    ));
    return $req->fetch();
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

  function recupererPDVPerdus($BDD, $pageHist, $idHist){
    $res = $BDD->prepare("SELECT nb_pdv_perdu FROM choix WHERE id_hist = :idHist AND id_page_cible = :idPageCible");
    $res->execute(array(
      'idHist' => $idHist,
      'idPageCible' => $pageHist
    ));
    $ligne = $res->fetch();
    return $ligne['nb_pdv_perdu'];
  }

  function recupererIdHistoire($BDD, $nomHist){
    $res = $BDD->prepare("SELECT id_hist FROM histoire WHERE nom_hist = :nomHist");
    $res->execute(array(
      'nomHist' => $nomHist
    ));
    $ligne = $res->fetch();
    return $ligne['id_hist'];
  }

  function afficherPageHistoire($BDD, $pageHist, $idHist){
    $res = $BDD->prepare("SELECT * FROM page_hist WHERE id_page = :idPage AND id_hist = :idHist");
    $res->execute(array(
      'idPage' => $pageHist,
      'idHist' => $idHist
    ));
    return $res->fetch();
  }

  function afficherChoixPage($BDD, $pageHist, $idHist){
    $res = $BDD->prepare("SELECT * FROM choix WHERE id_page = :idPage AND id_hist = :idHist");
    $res->execute(array(
      'idPage' => $pageHist,
      'idHist' => $idHist
    ));
    return $res->fetchAll();
  }

  function afficherPagesRenseignees($BDD, $idHist){
    $tabPages = array();
    $req = $BDD->prepare("SELECT id_page FROM page_hist WHERE id_hist=:numero");
    $req->execute(array(
      "numero" => $idHist
    ));
    while ($ligne = $req->fetch()) {
      array_push($tabPages, $ligne['id_page']);
    }
    return $tabPages;
  }

  function insererDebuterHistoire($BDD, $idHist, $idUser, $pageHist){
    try {
      $sql = "INSERT INTO hist_jouee (id_hist, id_user, choix_eff, nb_pts_vie, choix) VALUES (:idHist, :idUser, :dernierchoix, :nbPV, :choix)";
      $req = $BDD->prepare($sql);
      $req->execute(array(
        'idHist' => $idHist,
        'idUser' => $idUser,
        'dernierchoix' => $pageHist,
        'nbPV' => 3,
        'choix' => ''
      ));
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  function insererHistoire($BDD) {
    $sql = "INSERT INTO histoire (nom_hist, illustration, synopsis, id_createur) VALUES (:titre, :img, :synopsis, :idUser)";
    $req = $BDD->prepare($sql);
    // On exécute la requête en lui transmettant les données qui nous interessent
    $req->execute(array(
      "titre" => htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8', false),
      "synopsis" => htmlspecialchars($_POST['resume'], ENT_QUOTES, 'UTF-8', false),
      "img" => $_FILES["image"]['name'],
      "idUser" => $_SESSION['id_user']
    ));
  }

  function insererDonneesPage($BDD){
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
      $nom = "img_" . $i;
      if (isset($_FILES[$nom])) {
        $_FILES[$nom]['name'] =  strtolower("img_{$_SESSION['id_hist']}_{$_POST['pageChoisie']}_{$i}" . substr($_FILES[$nom]['name'], strpos($_FILES[$nom]['name'], '.')));
        if (move_uploaded_file($_FILES[$nom]['tmp_name'], "../images/" . $_SESSION['nom_hist'] . '/' . $_FILES[$nom]['name'])) {
          $tab[$nom] = $_FILES[$nom]['name'];
        }
      }
    }
    $sql = "INSERT INTO page_hist (id_page, id_hist, para_1, para_2, para_3, para_4, para_5, img_1, img_2, img_3, img_4, img_5) VALUES (:numero, :numHist, :para_1, :para_2, :para_3, :para_4, :para_5, :img_1, :img_2, :img_3, :img_4, :img_5)";
    $req = $BDD->prepare($sql);
    $req->execute($tab);
  }

  function insererChoixPage($BDD) {
    for ($i = 1; $i < 4; $i++) {
      $nom = "choix" . $i;
      if(isset($_POST[$nom])){
        //On prévoit le nom de la page cible suivante.
        if ($_POST['pageChoisie'] == '0') {
          $nivSuiv = 'A';
          $nomPageCible = 'A' . $i;
        } 
        else {
          $nivSuiv = chr(ord(substr($_POST['pageChoisie'], -2, 1)) + 1);
          $nomPageCible = $_POST['pageChoisie'] . $nivSuiv . $i;
        }
        $nomPdv = "pdv" . $i;
        $nomChoix = "fin" . $i;
        $pdv = 0;
        if(isset($_POST[$nomPdv])){
          $pdv = -1 * $_POST[$nomPdv];
        }
        $sql = "INSERT INTO choix (id_page, id_page_cible, id_hist, contenu, nb_pdv_perdu) VALUES (:numPage, :numPageCible, :numHist, :choix, :nbPdv)";
        $req = $BDD->prepare($sql);
        $req->execute(array(
          'numPage' => $_POST['pageChoisie'],
          'numPageCible' => $nomPageCible,
          'numHist' => $_SESSION['id_hist'],
          'choix' => htmlspecialchars($_POST[$nom], ENT_QUOTES, 'UTF-8', false),
          'nbPdv' => $pdv
        ));
        //On rajoute dans la BDD la page cible suivante si c'est une page de fin de jeu.
        if (isset($_POST[$nomChoix]) || strlen($nomPageCible) == 8) {
          $req = $BDD->prepare($sql);
          $req->execute(array(
            'numPage' => $nomPageCible,
            'numPageCible' => 'FIN',
            'numHist' => $_SESSION['id_hist'],
            'choix' => '',
            'nbPdv' => 0
          ));
        }
      }
    }
  }

  function ajouterUser($BDD){
    $req = $BDD->prepare("INSERT INTO user(est_admin,pseudo,mdp) VALUES (?,?,?)");
    $req->execute(array(0, htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8', false), password_hash($_POST['mdp'], PASSWORD_BCRYPT)));
  }

  function cacherHistoire($BDD){
    $req = $BDD -> prepare("UPDATE histoire SET cache=:cacher WHERE id_hist=:numHist"); 
    $req->execute(array(
      'cacher' => 1,
      'numHist' => $_SESSION['id_hist']
    )); 
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
    $req3 = $BDD->prepare("UPDATE hist_jouee SET choix =:choix WHERE id_hist = :idHist AND id_user = :idUser");
    $req3->execute(array(
      'choix' => $_SESSION['choix'],
      'idHist' => $_SESSION['id_hist'],
      'idUser' => $_SESSION['id_user']
    ));
  }

  function mettreAJourDonneesPage($BDD){
    for ($i = 1; $i < 6; $i++) {
      $nom = "para_" . $i;
      if (isset($_POST[$nom])) {
        $req = $BDD -> prepare("UPDATE page_hist SET {$nom}=:nomPara WHERE id_page =:nomPage  AND id_hist=:numHist"); 
        $req->execute(array(
          'nomPara' => htmlspecialchars($_POST[$nom], ENT_QUOTES, 'UTF-8', false),
          'nomPage' => $_SESSION['pageModifiee'],
          'numHist' => $_SESSION['id_hist']
        )); 
      }
      $nom = "img_" . $i;
      if (isset($_FILES[$nom])) {
        $_FILES[$nom]['name'] =  strtolower("img_{$_SESSION['id_hist']}_{$_SESSION['pageModifiee']}_{$i}" . substr($_FILES[$nom]['name'], strpos($_FILES[$nom]['name'], '.')));
        if (move_uploaded_file($_FILES[$nom]['tmp_name'], "../images/" . $_SESSION['nom_hist'] . '/' . $_FILES[$nom]['name'])) {
          $req = $BDD->prepare("UPDATE page_hist SET {$nom} =:nomImg WHERE id_page =:nomPage  AND id_hist=:numHist"); 
          $req->execute(array(
            'nomImg' => $_FILES[$nom]['name'], //N'est pas renseigné dans la BDD
            'nomPage' => $_SESSION['pageModifiee'],
            'numHist' => $_SESSION['id_hist']
        ));
        }
      }
    }
  }

  function mettreAJourChoixPage($BDD, $donneesChoix){
    $i=1;
    foreach($donneesChoix as $choix){
      $nom = "choix" . $i;
      $nomPdv = "pdv" . $i;
      if (isset($_POST[$nom])) {
        $req2 = $BDD -> prepare("UPDATE choix SET contenu =:texte WHERE id_page = :idPage AND id_page_cible = :idPageCible"); 
        $req2->execute(array(
          'texte' => htmlspecialchars($_POST[$nom], ENT_QUOTES, 'UTF-8', false),
          'idPage' => $_SESSION['pageModifiee'],
          'idPageCible' => $choix['id_page_cible']
        ));
      }
      if(isset($_POST[$nomPdv])){
        $req2 = $BDD -> prepare("UPDATE choix SET nb_pdv_perdu =:nbPdv WHERE id_page = :idPage AND id_page_cible = :idPageCible"); 
        $req2->execute(array(
          'nbPdv' => (-1*$_POST[$nomPdv]),
          'idPage' => $_SESSION['pageModifiee'],
          'idPageCible' => $choix['id_page_cible']
        ));
      }
      $i++;
    }
  }

  function verifierPresenceHistoire($BDD) {
    $req = $BDD->prepare("SELECT COUNT(*) as nb FROM page_hist WHERE id_page=:idPage AND id_hist =:idHist");
    $req->execute(array(
      'idPage' => $_POST['pageChoisie'],
      'idHist' => $_SESSION['id_hist']
    ));
    $ligne = $req->fetch();
    return $ligne['nb'];
  }

  function verifierPresenceChoix($BDD){
    $req = $BDD->prepare("SELECT COUNT(*) as nb FROM choix WHERE id_page=:idPage AND id_page_cible ='FIN' AND id_hist =:idHist");
    $req->execute(array(
      'idPage' => $_POST['pageChoisie'],
      'idHist' => $_SESSION['id_hist']
    ));
    $ligne = $req->fetch();
    return $ligne['nb'];
  }
?>