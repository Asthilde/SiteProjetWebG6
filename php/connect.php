<?php
$host = "localhost";
$dbname = "projet_histoire_arjo_pellegrin";
$username = "noemine";
$password = "patioPalmierChat200522";

try { 
    $BDD = new PDO( "mysql:host=". $host .";dbname=". $dbname .";charset=utf8",
        $username,
        $password, 
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
    die('Erreur fatale : ' . $e->getMessage());
}
?>