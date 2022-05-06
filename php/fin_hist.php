<?php
session_start();
require_once("connect.php");
unset($_SESSION['nom_hist']);
unset($_SESSION['num_page']);
unset($_SESSION['id_hist']);
header('Location: ../index.php') ;
?>