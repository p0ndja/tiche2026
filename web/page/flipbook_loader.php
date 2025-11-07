<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <?php require_once '../static/function/script/head.php'; ?> 
    <!-- Flipbook StyleSheet -->
    <link href="../static/library/dflip/css/dflip.min.css" rel="stylesheet" type="text/css">
    <script src="../static/library/dflip/js/dflip.min.js" type="text/javascript"></script>
    <link href="../static/library/dflip/css/themify-icons.min.css" rel="stylesheet" type="text/css">
</head>
<?php
    $pdf = "";
    if (isset($_GET['file']) && file_exists($_GET['file'])) {
        $pdf = $_GET['file'];
    } else if (isset($_POST['file']) && file_exists($_POST['file'])) {
        $pdf = $_POST['file'];
    } else if (isset($_GET['post']) && file_exists("../file/post/".((int) $_GET['post'])."/attachment/")) { 
        $files_in_attachment = glob("../file/post/".((int) $_GET['post'])."/attachment/*.pdf");
        if (count($files_in_attachment) == 1)
        $pdf = $files_in_attachment[0];
    }
    if (pathinfo($pdf, PATHINFO_EXTENSION) != "pdf") $pdf = "";
    if (empty($pdf)) header("Location: ../");
?>
<body>
    <div class="_df_book" webgl="true" backgroundcolor="<?php if (isset($_GET['color'])) echo $_GET['color']; ?>" source="<?php echo $pdf; ?>" id="df_manual_book" weight="1920" height="1080"></div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>