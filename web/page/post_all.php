<?php
    require_once '../static/function/connect.php';
    $isAdmin = isAdmin();
    $category = isset($_GET['category']) ? $_GET['category'] : "~";
    $tag = isset($_GET['tags']) ? $_GET['tags'] : "";
?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <div class="container">
        <div class="mb-0 mt-3 d-flex justify-content-between">
            <div class="flex-grow-1"><?php echo generateCategoryTitle($category, $tag); ?></div>
            <?php if ($isAdmin) { ?>
                <a href="../admin/post?c=<?php echo urlencode($category); ?>&t=<?php echo urlencode($tag); ?>" class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-pencil-alt'></i></a>
                <a href="../post/create?c=<?php echo urlencode($category);?>&t=<?php echo urlencode($tag); ?>" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
            <?php } ?>
        </div>
        <div class="card card-body mb-3">
            <?php
                $_GET['category'] = $category;
                $_GET['tags'] = $tag;
                include '../endpoint/post_load_all.php';
            ?>
        </div>
    </div>
    
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>