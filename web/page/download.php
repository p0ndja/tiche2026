<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <div class="container mb-3" id="container" >
        <div class="row">
            <div class="col-12 col-lg-3">
                <?php require_once '../static/function/sidetab.php'; ?>
            </div>
            <div class="col-12 col-lg-9">
            <h3 class="font-weight-bold">DOWNLOAD</h3>
                <?php
                    $_GET['path'] = '../file/upload/' . (isset($_GET['f']) ? urldecode($_GET['f']) : ""); 
                    $_GET['upload'] = 1;
                    include '../endpoint/file_lookup.php';
                ?>
            </div>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>