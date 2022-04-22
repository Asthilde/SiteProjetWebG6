<?php
session_start();
require_once("connect.php");


?>


<!doctype html>
<html>
<?php include 'templatesHTML/head.php'; ?>

<body>
    <?php include 'templatesHTML/navbar.php';
    if ($BDD) {
        $req = "SELECT * FROM 'page'";
        $res = $BDD->query($req);
        $ligne = $res->fetch();
        for ($i = 1; $i <= 5; $i++) {
            $para = "para_" . $i;
            $image = "img_" . $i;
            if ($ligne[$para] == null) { ?>
                ?>
                <div>
                    <?php $ligne[$para]; ?>
                </div>
            <?php } ?>
            <?php if ($ligne[$image] == null) { ?>
                <div>
                    <img src="<?php $ligne[$image]; ?>" alt="<?php $ligne[$image]; ?>" />
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>

</body>

<?php include 'templatesHTML/footer.php'; ?>


<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>

</html>