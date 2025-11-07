<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
        <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="../static/library/ckeditor-4.18.0/ckeditor.js"></script>
        <script src="../static/library/ckfinder-3.4.2/ckfinder.js"></script>
        <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;
        }
        </style>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <div class="container">
            <h1 class="font-weight-bold text-center mb-5">ฝ่ายพัฒนาทรัพยากรบุคคล</h1>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="mb-0 mt-0 d-flex justify-content-between">
                        <div class="flex-grow-1"><h5><?php echo createHeader("ค่านิยมองค์กร \"ACTS +3S\""); ?></h5></div>
                        <?php if (isAdmin()) { ?>
                            <a class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1" onclick='HRD_CultureModal();' data-toggle='modal' data-target='#modalPopupXL'><i class='fas fa-pencil-alt'></i></a>
                        <?php } ?>
                    </div>
                    <div class="p-2"><?php echo (getDatatable("HRD"))["Culture"];?></div>
                </div>
                <!--
                <div class="col-12 col-md-6">
                    <div class="mb-0 mt-0 d-flex justify-content-between">
                        <div class="flex-grow-1"><h5><?php echo createHeader("ACTS + 3S"); ?></h5></div>
                        <?php if (isAdmin()) { ?>
                            <a class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1" onclick='HRD_ACTSModal();' data-toggle='modal' data-target='#modalPopupXL'><i class='fas fa-pencil-alt'></i></a>
                        <?php } ?>
                    </div>
                    <div class="p-2"><?php //echo (getDatatable("HRD"))["ACTS"];?></div>
                </div>
                -->
            </div>
            <div class="d-flex justify-content-between mb-0">
                <div class="flex-grow-1"><?php echo generateCategoryTitle("Srinagarind Conference"); ?></div>
                <?php if (isAdmin()) { ?>
                    <a href="../admin/post?c=Srinagarind Conference" class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-pencil-alt'></i></a>
                    <a href="../post/create" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
                <?php } ?>
            </div>
            <div class="card card-body mt-0 mb-3">
                <div class="row">
                <?php
                    $_GET['page'] = 1;
                    $_GET['category'] = "Srinagarind Conference";
                    $_GET['maximum'] = 6;
                    $_GET['LM2VA'] = true;
                    include '../endpoint/post_load.php';
                ?>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-0">
                <div class="flex-grow-1"><?php echo generateCategoryTitle("กิจกรรมพัฒนาทรัพยากรบุคคล"); ?></div>
                <?php if (isAdmin()) { ?>
                    <a href="../admin/post?c=กิจกรรมพัฒนาทรัพยากรบุคคล" class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-pencil-alt'></i></a>
                    <a href="../post/create" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
                <?php } ?>
            </div>
            <div class="card card-body mt-0 mb-3">
                <div class="row">
                <?php
                    $_GET['page'] = 1;
                    $_GET['category'] = "กิจกรรมพัฒนาทรัพยากรบุคคล";
                    $_GET['maximum'] = 6;
                    $_GET['LM2VA'] = true;
                    include '../endpoint/post_load.php';
                ?>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-0">
                <div class="flex-grow-1"><?php echo generateCategoryTitle("เรื่องราวดี ๆ ที่ต้องแชร์"); ?></div>
                <?php if (isAdmin()) { ?>
                    <a href="../admin/post?c=เรื่องราวดี ๆ ที่ต้องแชร์" class="btn-floating btn-sm btn-warning z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-pencil-alt'></i></a>
                    <a href="../post/create" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
                <?php } ?>
            </div>
            <div class="card card-body mt-0 mb-3">
                <div class="row">
                <?php
                    $_GET['page'] = 1;
                    $_GET['category'] = "เรื่องราวดี ๆ ที่ต้องแชร์";
                    $_GET['maximum'] = 6;
                    $_GET['LM2VA'] = true;
                    include '../endpoint/post_load.php';
                ?>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-0">
                <div class="flex-grow-1"><?php echo generateCategoryTitle("หน่วยงานที่เกี่ยวข้อง"); ?></div>
            </div>
            <div class="card card-body mt-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="https://hr.md.kku.ac.th/" class="text-dark">
                            <div class="card mb-1 mt-1">
                                <div class="view overlay zoom">
                                    <img src="../file/ckeditor/files/hrmdkku.jpg" class="card-img-top" loading="lazy" style="min-width: 100%; object-fit: contain; aspect-ratio: 16/9; background-color: <?php echo get_average_colour("../file/ckeditor/files/hrmdkku.jpg"); ?>;">
                                </div>
                            </div>
                            <div class="ml-1 mr-1 mt-2 mb-3 text-center">
                                <a href="https://hr.md.kku.ac.th/" class="display-8 md"><text class='font-weight-bold'>หน่วยการเจ้าหน้าที่<br>คณะแพทยศาสตร์</text></a>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="https://hr.kku.ac.th/wphrdkku" class="text-dark">
                            <div class="card mb-1 mt-1">
                                <div class="view overlay zoom">
                                    <img src="../file/ckeditor/files/kku.jpg" class="card-img-top" loading="lazy" style="min-width: 100%; object-fit: contain; aspect-ratio: 16/9; background-color: <?php echo get_average_colour("../file/ckeditor/files/kku.jpg"); ?>;">
                                </div>
                            </div>
                            <div class="ml-1 mr-1 mt-2 mb-3 text-center">
                                <a href="https://hr.kku.ac.th/wphrdkku" class="display-8 md"><text class='font-weight-bold'>กองทรัพยากรบุคคล<br>มหาวิทยาลัยขอนแก่น</text></a>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="https://www.facebook.com/kmmdkku" class="text-dark">
                            <div class="card mb-1 mt-1">
                                <div class="view overlay zoom">
                                    <img src="../file/ckeditor/files/facebook.jpg" class="card-img-top" loading="lazy" style="min-width: 100%; object-fit: contain; aspect-ratio: 16/9; background-color: <?php echo get_average_colour("../file/ckeditor/files/facebook.jpg"); ?>;">
                                </div>
                            </div>
                            <div class="ml-1 mr-1 mt-2 mb-3 text-center">
                                <a href="https://www.facebook.com/kmmdkku" class="display-8 md"><text class='font-weight-bold'>Facebook Fanpage</text></a>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; // Footer can be hidden by full comment this line.?>
    <?php require_once '../static/function/script/footer.php'; ?>
</html>