<?php 
session_start();
require_once 'php/connect.php' ?>
<!doctype html>
<html>
<?php include 'templatesHTML/head.php';?>
<body>
    <div class="container">
        <?php
        include 'templatesHTML/navbar.php';
        if($BDD){
            $req = "SELECT * FROM histoire ORDER BY nom_hist";
            $res = $BDD -> query($req);
            while($ligne = $res->fetch()) {
        ?>
        <article> <!--Il faut vérifier ici si l'utilisateur est connecté -->
        <h3><a class="titreHistoire" href="histoires.php?id=<?= $ligne['id_hist']?>"><?php echo $ligne['nom_hist'];?></a></h3>
        <p class="contenuHistoire"><?= $ligne['synopsis'] ?></p>
        </article>
        <?php } } ?>
        <?php include 'templatesHTML/footer.php'; ?>
    </div>

    <!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script></body>

</html>