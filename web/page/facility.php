<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
        <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;
        }
        </style>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <div class="container font-weight-bold">
            <h1 class="font-weight-bold text-center mb-3">สิ่งอำนวยความสะดวก</h1><?php $topic = "facility"; ?>
            <div class="row justify-content-center">
            <?php
                $links = getDatatable($topic."Hotlink");
                $i = 0;
                foreach($links as $link) {
                    $icon = !empty($link['icon']) ? str_replace("<span class=\"", "<span style=\"font-size: 30px;\" class=\"p-0 ", $link['icon']) : "<span style=\"font-size: 30px;\" class=\"p-0 material-symbols-outlined\">open_in_new</span>";?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a target="_blank" href="<?php echo $link['link']; ?>" class="md-dark">
                        <div class="card mb-3" style="min-height: 180px">
                            <div class="card-body">
                                <span class="display-6 badge badge-md mb-3 z-depth-1"><?php echo $icon; ?></span><br><text class="display-8"><?php echo $link['text']; ?></text><?php if (isAdmin()) { ?><br><small><a class='md' onclick='HotlinkModal("<?php echo $topic; ?>",<?php echo $i; ?>);' data-toggle='modal' data-target='#modalPopup'>แก้ไข</a></small><?php } ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php $i++; }
                if (isAdmin()) { ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a onclick='HotlinkModal("<?php echo $topic; ?>",-1);' data-toggle='modal' data-target='#modalPopup' class="text-white">
                        <div class="card bg-md mb-3" style="min-height: 180px">
                            <div class="card-body align-items-center d-flex justify-content-center">
                                <div><span class="material-symbols-outlined" style="font-size: 30px;">add</span></div>
                                <h5>เพิ่มลิงก์ใหม่</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php }
            ?>
            </div>
        </div>
    </body>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; // Footer can be hidden by full comment this line.?>
    <?php require_once '../static/function/script/footer.php'; ?>
</html>