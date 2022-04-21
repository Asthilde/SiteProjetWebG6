<?php
require_once("connect.php");
?>

<!doctype html>
<html>
<?php include 'templatesHTML/head.php';?>
<body>
    <div class="container">        
        <?php include 'templatesHTML/navbar.php';
        if(isset($_GET['id']) && !empty($_GET['id'])) {
            $req = "SELECT * FROM histoire WHERE id_hist=" . $_GET['id'];
            $res = $BDD -> query($req); 
            $ligne = $res->fetch();?>
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-5 col-sm-7">
                    <img class="img-responsive movieImage" src="../images/<?php echo strtolower($ligne['illustration']); ?>" title="<?= $ligne['nom_hist']; ?>" />
                </div>
                <div class="col-md-7 col-sm-5">
                    <h2><?= $ligne['nom_hist']; ?></h2>
                    <p>Créateur : <?= $ligne['id_createur']; ?></p>
                    <p>Nombre de fois joué : <?= $ligne['nb_fois_jouee']; ?><br/>
                    Nombre de réussites : <?= $ligne['nb_reussites']; ?><br/>
                    Nombre d'échecs : <?= $ligne['nb_morts']; ?></p>
                    <p><small><?= $ligne['synopsis']; ?></small></p>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php include 'templatesHTML/footer.php'; ?>
    </div>

<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>