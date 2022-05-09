<?php session_start();
require_once("connect.php");
if($BDD){
  $req = $BDD->prepare("DELETE FROM hist_jouee WHERE id_hist=:idHist AND id_user=:idUser");
  $req->execute(array(
    'idHist' => $_SESSION['id_hist'],
    'idUser' => $_SESSION['id_user']
  ));
  $req = $BDD->prepare("SELECT * FROM histoire WHERE id_hist=:idHist");
  $req->execute(array(
    'idHist' => $_SESSION['id_hist']
  ));
  $ligne = $req -> fetch();
  $req2 = $BDD -> prepare("UPDATE histoire SET nb_fois_jouee=:nbJeu WHERE id_hist=:idHist"); 
  $req2->execute(array(
    'nbJeu' => ($ligne['nb_fois_jouee']+1),
    'idHist' => $_SESSION['id_hist']
  )); 
  $req2 = $BDD -> prepare("UPDATE histoire SET nb_reussites=:nbGagne WHERE id_hist=:idHist"); 
  $req2->execute(array(
    'nbGagne' => ($ligne['nb_reussites']+1),
    'idHist' => $_SESSION['id_hist']
  )); 
}
unset($_SESSION['id_hist']);
unset($_SESSION['nbpv']);
$urlAccueil = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'],'php/perdu')).'index.php';
header("Location:{$urlAccueil}");
?>