<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <script src="../static/library/ckeditor-4.18.0/ckeditor.js"></script>
    <script src="../static/library/ckfinder-3.4.2/ckfinder.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<?php needAdmin(); $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; $category = $_GET['category']; ?>
<body>
    <div class="container">
        <h1 class="font-weight-bold text-md">
            <?php
                 if ($category == "IPD") echo "ตารางแพทย์ออกตรวจในเวลา";
            else if ($category == "OPD") echo "ตารางแพทย์ออกตรวจนอกเวลา";
            else if ($category == "FAQ") echo "คำถามที่พบบ่อย";
            else if ($category == "PG")  echo "ขั้นตอนการเข้ารับบริการ";
            ?>
        </h1>
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
                                        <a id="pill_<?php echo $category.'_'.$row['title']; ?>" class="nav-link text-left <?php if ($id == $row['id']) echo 'active'; ?>" href="../timetable/<?php echo $category;?>-<?php echo $row['id']; ?>">
                                            <div class="d-flex">
                                                <div class="flex-grow-1"><?php echo $row['title']; ?></div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php }
                                }
                            } ?>
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
                            <h4><a onclick="window.history.back();" class="md float-left"><i class="fas fa-arrow-left"></i> Back</a><br></h4>
                            <form method="POST" action="../endpoint/timetable_save.php?id=<?php echo $id; ?>&category=<?php echo $category;?>" enctype="multipart/form-data" autocomplete="off">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="Titleaddon1">หัวข้อ</span>
                                            </div>
                                            <input type="text" placeholder="หัวข้อ" class="form-control" value="<?php echo $row['title']; ?>" id="articleTitle" name="articleTitle" required  aria-label="Title" aria-describedby="Titleaddon1"></input>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-1 ml-auto">                                                
                                        <button type="submit" value="create" name="submitBtn" class="btn-floating btn-sm btn-success mt-0 mb-0 z-depth-0" style="border:0;"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                                <div class="card mb-3 w-100">
                                    <div class="card-body"><textarea name="articleEditor"><?php echo $row['data'];?></textarea></div>
                                    <script>
                                        var editor = CKEDITOR.replace('articleEditor');
                                        CKFinder.setupCKEditor(editor);
                                    </script>
                                </div>
                            </form>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
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