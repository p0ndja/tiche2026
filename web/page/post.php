<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
        @media (min-width: 960px) {
            .card-columns {
                -webkit-column-count: 3;
                -moz-column-count: 3;
                column-count: 3;
            }
        }
        @media (max-width: 960px) {
            .card-columns {
                -webkit-column-count: 1;
                -moz-column-count: 1;
                column-count: 1;
            }
        }
    </style>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <?php
        if (!isset($_GET['category']) || !isValidCategory($_GET['category'])) header("Location: ../category/~-1");        
        $category = $_GET['category'];
        $tag = isset($_GET['tags']) ? $_GET['tags'] : "";
        $permPost = isAdmin();
    ?>
    <div class="container mb-3" id="container">
        <div class="mb-0 mt-3 d-flex justify-content-between">
            <div class="flex-grow-1"><?php echo generateCategoryTitle($category, $tag); ?></div>
            <?php if ($permPost) { ?>
                <a href="../admin/post?c=<?php echo urlencode($_GET['category']); ?>&t=<?php echo urlencode($tag); ?>" class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-pencil-alt'></i></a>
                <a href="../post/create?c=<?php echo urlencode($_GET['category']);?>&t=<?php echo urlencode($tag); ?>" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
            <?php } ?>
        </div>
        <div class="card card-body">
            <div class='row' id="loadMoreZone">
                <?php
                    $_GET['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $_GET['category'] = $category;
                    $_GET['tags'] = $tag;
                    include '../endpoint/post_load.php';
                ?>
            </div>
            <div class="d-flex justify-content-center">
                <a onclick="loadMore();" class="btn btn-success text-center" id="loadMoreButton">Load More</a>
            </div>
        </div>
        <script>
            if ($('#EOF').length > 0) { 
                $("#loadMoreButton").remove();
            }
        </script>
        <script>
            var currentPage = 1;
            $(window).scroll(function() {
                if(($(window).scrollTop() == $(document).height() - $(window).height()) && $("#loadMoreButton").length > 0) {
                    loadMore();
                }
            });
            function loadMore() {
                $.ajax({
                type: 'GET',
                url: '../endpoint/post_load.php',
                data: {
                    'page': ++currentPage,
                    'category': "<?php echo $category; ?>",
                    "tags": "<?php echo $tag; ?>"
                },
                success: function (data) {
                    if (data.trim() == '') {
                        $("#loadMoreButton").remove();
                    } else {
                        $('#loadMoreZone').append(data);
                        if ($('#EOF').length > 0) $("#loadMoreButton").remove();
                    }
                }
            });
            }
        </script>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?></body>
</html>