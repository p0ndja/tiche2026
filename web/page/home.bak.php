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

            div.stretchy-wrapper {
                background-color: #fafafa;
                position: relative;
                width: 100%;
                padding-top: 56.25%; /* 16:9 Aspect Ratio */
            }

            div.stretchy-wrapper > div {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center center;
            }

            .carousel-control-prev-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%234a4a4a' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
            }

            .carousel-control-next-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%234a4a4a' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
            }
        </style>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <div class="container mb-4 px-lg-5">
            <!-- Main Page Carousel --><!-- TODO Implement Editable Carousel -->
            <div id="mainPageCarousel" class="px-lg-4 carousel slide" data-ride="carousel">
                <div class="stretchy-wrapper carousel-inner">
                    <?php
                    $g = glob("../file/carousel/*.{JPG,jpg,JPEG,jpeg,PNG,png,GIF,gif}", GLOB_BRACE); sort($g);
                    if (empty($g)) $g = array("../static/asset/header_16x9.png");
                    for($i = 0; $i < count($g); $i++) {
                        $url = readTxt($g[$i].".txt"); $lurl = ""; foreach($url as $u) { $lurl .= $u; } if (filter_var($lurl, FILTER_VALIDATE_URL) === FALSE) $lurl = "";?>
                    <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>" loading="lazy" style="background-image:url('<?php echo showWebP($g[$i]); ?>'); <?php if (!empty($lurl)) { ?>cursor: pointer;<?php } ?>" <?php if (!empty($lurl)) { ?>onclick="window.open('<?php echo $lurl; ?>', '_blank').focus();"<?php } ?>></div>
                    <?php } ?>
                </div>
                <a class="carousel-control-prev" href="#mainPageCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#mainPageCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="container">
            <div class="mb-0 mt-3 d-flex justify-content-between">
                <div class="flex-grow-1"><?php echo generateCategoryTitle("ข่าวประชาสัมพันธ์", "", true, "../category/ประชาสัมพันธ์-1"); ?></div>
                <?php if (isAdmin()) { ?>
                    <a href="../admin/post?c=ประชาสัมพันธ์" class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-pencil-alt'></i></a>
                    <a href="../post/create?c=ประชาสัมพันธ์" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
                <?php } ?>
            </div>
            <div class="card card-body mt-0 mb-3">
                <div class="row">
                <?php
                    $_GET['page'] = 1;
                    $_GET['category'] = "ประชาสัมพันธ์";
                    $_GET['maximum'] = 6;
                    $_GET['LM2VA'] = true;
                    include '../endpoint/post_load.php';
                ?>
                </div>
            </div>
            <div class="container mb-3">
                <div class="mb-1 mt-3 d-flex justify-content-between">
                    <div class="flex-grow-1"><?php echo createHeader("ความรู้สู่ประชาชน"); ?></div>
                    <?php if (isAdmin()) { ?>
                        <a class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1" onclick='VDOModal();' data-toggle='modal' data-target='#modalPopup'><i class='fas fa-pencil-alt'></i></a>
                    <?php } ?>
                </div>
                <div class="row" id="VDOSection">
                    <?php foreach(watchVDO() as $v) { ?>
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card mb-3">
                                <div class="card-img-top">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="<?php echo $v; ?>"
                                            allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- Your embedded video player code -->
            </div>
            <div class="container-fluid mb-2">
                <div class="d-block d-md-none text-center">
                <a href="//md.kku.ac.th" class="btn btn-floating mb-2 text-center btn-success mr-0"><img src="../static/asset/logo/md32.png" height="32" onContextMenu="return false;" class="mt-2"/></a>
                    <a href="//kku.ac.th" class="btn btn-floating mb-2 text-center btn-warning mr-0"><img src="../static/asset/logo/kku32.png" height="32" onContextMenu="return false;" class="mt-2"/></a>
                    <a href="//www.rcat.org" class="btn btn-floating mb-2 text-center btn-primary mr-0"><img src="../static/asset/logo/RCAT.png" height="32" onContextMenu="return false;" class="mt-2"/></a>
                    <!--a href="//www.khunlook.com" class="btn btn-floating mb-2 text-center btn-secondary mr-0"><img src="../static/asset/logo/khunlook32.png" height="32" onContextMenu="return false;" class="mt-2"/></a-->
                </div>
                <div class="d-none d-md-block">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <a href="//md.kku.ac.th" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-success btn-block"><img src="../static/asset/logo/md32.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;<text class="text-dark">คณะแพทยศาสตร์</text></a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="//kku.ac.th" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-warning btn-block"><img src="../static/asset/logo/kku32.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;&nbsp; <text class="text-dark">มหาวิทยาลัยขอนแก่น</text></a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="//www.rcat.org" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-primary btn-block"><img src="../static/asset/logo/RCAT.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;&nbsp; <text class="text-dark">ราชวิทยาลัยวิสัญญีแพทย์แห่งประเทศไทย</text></a>
                        </div>
                        <!--div class="col-md-6 col-xl-3">
                            <a href="//www.khunlook.com" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-secondary btn-block"><img src="../static/asset/logo/khunlook32.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;<text class="text-dark">แอปพลิเคชัน KhunLook</text></a>
                        </div-->
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; // Footer can be hidden by full comment this line.?>
    <?php require_once '../static/function/script/footer.php'; ?>
</html>
