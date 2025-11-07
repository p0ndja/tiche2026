<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
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
<?php $isAdmin = isAdmin(); $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; ?>
<body>
    <div class="container">
        <h1 class="font-weight-bold text-md">คำถามที่พบบ่อย</h1><?php $category = "FAQ"; ?>
        <?php if ($id == 0) {?>
        <!--
        <div class="row">
            <div class="col-sm-12 mb-3">
                <script>
                    function mySearchBarFunction() {
                        var input, filter, cards, cardContainer, h5, title, i;
                        input = document.getElementById("mySearchFilter");
                        filter = input.value.toUpperCase();
                        cardContainer = document.getElementById("myCardItems");
                        cards = cardContainer.getElementsByClassName("card");
                        for (i = 0; i < cards.length; i++) {
                            title = cards[i].querySelector(".card-body h5.card-title");
                            if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                                cards[i].style.display = "";
                            } else {
                                cards[i].style.display = "none";
                            }
                        }
                    }
                </script>
                <input type="text" id="mySearchFilter" class="form-control" onkeyup="mySearchBarFunction()" placeholder="พิมพ์เพื่อค้นหา...">
            </div>
        </div>
        -->
        <div class="card-columns" id="myCardItems">
        <?php
            if ($stmt = $conn->prepare("SELECT `id`,`title` FROM `timetable` WHERE `category` = ?")) {
                $stmt->bind_param('s',$category);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <a href="../FAQ/<?php echo $row['id']; ?>" class="md-dark">
                            <div class="card mb-3 mt-1" style="min-height: 150px">
                                <div class="card-body align-items-center d-flex justify-content-center" style="min-height: 150px"><h5 class="card-title display-7 text-center"><?php echo $row['title']; ?></h5></div>
                            </div>
                        </a>
                    <?php }
                }
            } ?>
            <?php if ($isAdmin) {?>
                <a class="md-dark" onclick="createNewCategory();"></a>
                    <div class="card bg-md mb-3 mt-1" style="min-height: 150px" onclick="createNewCategory();">
                        <div class="card-body align-items-center d-flex justify-content-center" style="min-height: 150px"><h5 class="display-7 text-white text-center">เพิ่มหัวข้อใหม่ <i class="fas fa-plus ml-auto"></i></h5></div>
                    </div>
                </a>
                <script>
                    function createNewCategory() {
                        var folderName = prompt("กรุณาระบุชื่อหัวข้อ ห้ามใช้อักขระดังต่อไปนี้ \\ / : * ? \" < > |");
                        if (folderName != null && folderName != "") {
                            window.location = "../endpoint/timetable_IO.php?function=create&category=<?php echo $category; ?>&title=" + folderName;
                        }
                    }
                </script>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card mb-3">
                    <ul class="nav md-pills pills-success flex-column" role="tablist">
                        <?php
                            if ($stmt = $conn->prepare("SELECT `id`,`title` FROM `timetable` WHERE `category` = ?")) {
                                $stmt->bind_param('s',$category);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                                    <li class="nav-item">
                                        <a id="pill_<?php echo $category.'_'.$row['title']; ?>" class="nav-link text-left <?php if ($id == $row['id']) echo 'active'; ?>" href="../FAQ/<?php echo $row['id']; ?>">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"><?php echo $row['title']; ?></div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php }
                                }
                            } ?>
                        <?php if ($isAdmin) {?>
                        <li class="nav-item">
                            <a class="nav-link text-left" onclick="createNewCategory();">เพิ่มหัวข้อใหม่ <i class="fas fa-plus ml-auto"></i></a>
                            <script>
                                function createNewCategory() {
                                    var folderName = prompt("กรุณาระบุชื่อหัวข้อ ห้ามใช้อักขระดังต่อไปนี้ \\ / : * ? \" < > |");
                                    if (folderName != null && folderName != "") {
                                        window.location = "../endpoint/timetable_IO.php?function=create&category=<?php echo $category; ?>&title=" + folderName;
                                    }
                                }
                            </script>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <?php if ($id > 0) {
                    if ($stmt = $conn->prepare("SELECT `title`,`data` FROM `timetable` WHERE `id` = ? LIMIT 1")) {
                        $stmt->bind_param('i',$id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <h4 class="font-weight-bold">
                                    <?php echo $row['title']; ?>
                                    <?php if ($isAdmin) { ?>
                                    <a class='z-depth-0 btn-sm btn-warning btn-floating mr-0 ml-0 mb-0 mt-0'href="../FAQ/<?php echo $id; ?>-edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a class='z-depth-0 btn-sm btn-danger btn-floating mr-0 ml-0 mb-0 mt-0'
                                        onclick='swal({title: "ลบข้อมูลนี้หรือไม่ ?",text: "หลังจากที่ลบแล้ว จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/timetable_IO.php?function=delete&id=<?php echo $id; ?>";}});'>
                                        <i class="fas fa-trash-alt"></i></a>
                                    <?php } ?>
                                </h4>
                                <div class="card mb-3 w-100" id="articleRenderer">
                                    <?php
                                        $article = $row['data'];
                                        $each = explode("\n",$article); $data = array(); $title = "";
                                        $final_data = array();
                                        for($i = 0; $i < count($each); $i++) {
                                            if (preg_match("/<h[1-5].*>(.*)<\/h[1-5]>/", $each[$i], $match)) {
                                                if (!empty($data))
                                                    array_push($final_data, array("title"=>$title,"data"=>$data));
                                                $data = array();
                                                $title = $match[1];
                                            } else {
                                                array_push($data, $each[$i]);
                                            }
                                        }
                                        array_push($final_data, array("title"=>$title,"data"=>$data));
                                    ?>
                                    <?php $i = 0; foreach($final_data as $fd) { ?>
                                    <div class="accordion md-accordion" id="FAQParent" role="tablist" aria-multiselectable="true">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="FAQheading<?php echo $i;?>">
                                                <a data-toggle="collapse" data-parent="#FAQParent" href="#FAQcollapse<?php echo $i;?>" aria-expanded="true"
                                                    aria-controls="FAQcollapse<?php echo $i;?>">
                                                    <h5 class="mb-0 md"><?php echo $fd["title"]; ?> <i class="fas fa-angle-down rotate-icon"></i></h5>
                                                </a>
                                            </div>
                                            <div id="FAQcollapse<?php echo $i;?>" class="collapse" role="tabpanel" aria-labelledby="FAQheading<?php echo $i;?>"
                                                data-parent="#FAQParent">
                                                <div class="card-body">
                                                    <?php foreach($fd["data"] as $fdd) { ?>
                                                    <?php echo $fdd; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
    <script>
    if (hashtag()) {
        document.getElementById("pill_" + hashtag()).click();
        backToTop();
    }
    </script>
</body>
</html>