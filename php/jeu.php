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
        $req = "SELECT * FROM page_hist";
        $res = $BDD->query($req);
        $ligne = $res->fetch();
        for ($i = 1; $i <= 5; $i++) {
            $para = "para_" . $i;
            $image = "img_" . $i; ?>
            <div>
                <?= $ligne[$para]; ?>
            </div>
            <div>
                <img src="../images/moi aussi je suis un test/<?= $ligne[$image]; ?>" alt="<?= $ligne[$image]; ?>" />
            </div>
        <?php } ?>
    <?php } ?>

</body>

<?php include 'templatesHTML/footer.php'; ?>


<!-- jQuery -->
<script src="../lib/jquery/jquery.min.js"></script>
<!-- JavaScript Boostrap plugin -->
<script src="../lib/bootstrap/js/bootstrap.min.js"></script>

</html>