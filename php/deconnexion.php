<?php session_start();
session_unset();
session_destroy();
$urlAccueil = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'],'php/deconnexion')).'index.php';
header("Location:{$urlAccueil}");
?>