<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head><?php require_once '../static/function/script/head.php'; ?></head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<?php $isAdmin = isAdmin(); ?>
<body>
    <div class="container-fluid px-5">
        <h1 class="font-weight-bold text-md">รายชื่อแพทย์</h1>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card mb-3">
                    <ul class="nav md-pills pills-success flex-column" role="tablist">
                        <?php
                            $fol = glob("../file/people/doctor/*", GLOB_ONLYDIR);
                            for($f = 0; $f < count($fol); $f++) {
                                $folder_name = pathinfo($fol[$f], PATHINFO_FILENAME); ?>
                                <li class="nav-item">
                                    <a id="pill_<?php echo str_replace(" ", "_", pathinfo($fol[$f], PATHINFO_FILENAME)); ?>" class="nav-link text-left <?php if ($f == 0) echo 'active'; ?>" data-toggle="tab" href="#<?php echo str_replace(" ", "_", pathinfo($fol[$f], PATHINFO_FILENAME)); ?>" role="tab" onclick="window.location.hash = '<?php echo $folder_name;?>'">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <?php echo $folder_name; ?>
                                            </div>
                                            <?php if ($isAdmin) { ?>
                                            <i class="fas fa-pencil-alt mt-1 text-warning mr-1" onclick="editCategory('<?php echo $fol[$f]; ?>','<?php echo $folder_name; ?>')"></i>
                                            <i class="fas fa-trash mt-1 text-danger" onclick="myDeleteFolderFunction('<?php echo $fol[$f]; ?>');"></i>
                                            <?php } ?>
                                        </div>
                                    </a>
                                </li>      
                            <?php }
                        ?>
                        <?php if ($isAdmin) {?>
                        <li class="nav-item">
                            <a class="nav-link text-left" onclick="createNewCategory();">เพิ่มหมวดหมู่ใหม่ <i class="fas fa-plus ml-auto"></i></a>
                            <script>
                                function createNewCategory() {
                                    var folderName = prompt("กรุณาระบุชื่อหมวดหมู่ ห้ามใช้อักขระดังต่อไปนี้ \\ / : * ? \" < > |");
                                    if (folderName != null && folderName != "") {
                                        window.location = "../endpoint/people_IO.php?function=create&top=doctor&mkdir=" + folderName;
                                    }
                                }
                                function editCategory(targetFolder, tempOldName) {
                                    var folderName = prompt("กรุณาระบุชื่อหมวดหมู่ใหม่ ห้ามใช้อักขระดังต่อไปนี้ \\ / : * ? \" < > |", tempOldName);
                                    if (folderName != null && folderName != "") {
                                        window.location = "../endpoint/people_IO.php?function=rename&old=" + targetFolder + "&new=" + folderName;
                                    }
                                }
                                function myDeleteFileFunction(f) {
                                    swal({
                                        title: "ลบรูปนี้หรือไม่",
                                        text: "หลังจากที่ลบแล้ว จะไม่สามารถกู้คืนได้!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true
                                    }).then((willDelete) => {
                                        if (willDelete) {
                                            window.location = "../endpoint/people_IO.php?function=delete&method=file&name=" + f;
                                        }
                                    });
                                }
                                function myDeleteFolderFunction(f) {
                                    swal({
                                        title: "ลบหมวดหมู่นี้หรือไม่",
                                        text: "หลังจากที่ลบแล้ว จะไม่สามารถกู้คืนได้!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true
                                    }).then((willDelete) => {
                                        if (willDelete) {
                                            window.location = "../endpoint/people_IO.php?function=delete&method=dir&name=" + f;
                                        }
                                    });
                                }
                                function myEditFileFunction(targetFile, tempDisplayName) {
                                    var folderName = prompt("กรุณาระบุชื่อรูป ห้ามใช้ \\ / : * ? \" < > |", tempDisplayName);
                                    if (folderName != null && folderName != "") {
                                        window.location = "../endpoint/people_IO.php?function=rename&old=" + targetFile + "&new=" + folderName;
                                    }
                                }
                                function myEditFolderFunction(targetFile, tempDisplayName) {
                                    var folderName = prompt("กรุณาระบุชื่อหมวดหมู่ ห้ามใช้ \\ / : * ? \" < > |", tempDisplayName);
                                    if (folderName != null && folderName != "") {
                                        window.location = "../endpoint/people_IO.php?function=rename&old=" + targetFile + "&new=" + folderName;
                                    }
                                }
                                function editField(targetEditZone) {
                                    document.getElementById("targetZone_" + targetEditZone).style.display = "none";
                                    document.getElementById("targetEditZone_" + targetEditZone).style.display = "block";
                                }
                                function myEditLinkFunction(targetFolder, tempDisplayName) {
                                    var folderName = prompt("กรุณาระบุลิงก์", tempDisplayName);
                                    if (folderName != null && folderName != "") {
                                        window.location = "../endpoint/people_IO.php?function=link&folder="+targetFolder+"&link="+folderName;
                                    }
                                }
                            </script>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Tab panels -->
                <div class="tab-content vertical">
                    <?php for($f = 0; $f < count($fol); $f++) {
                        $folder_name = pathinfo($fol[$f], PATHINFO_FILENAME); ?>
                        <div class="tab-pane fade in show <?php if ($f == 0) echo 'active'; ?>" id="<?php echo str_replace(" ", "_", pathinfo($fol[$f], PATHINFO_FILENAME)); ?>" role="tabpanel">
                            <?php $hotlink = "";
                            if (file_exists("../file/people/doctor/$folder_name/link.txt")) {
                                $link = "";
                                foreach(readTxt("../file/people/doctor/$folder_name/link.txt") as $l) {
                                    $link .= $l;
                                }
                                if (!empty($link) || isAdmin()) 
                                    $hotlink = "<a class=\"md\" ".(isAdmin() ? "href=\"#\" onclick='myEditLinkFunction(\"../file/people/doctor/$folder_name\",\"".$link."\");'" : "href=\"".$link."\"")."><i class=\"fa-solid fa-link\"></i></a>";
                            } else if (isAdmin()) {
                                $hotlink = "<a class=\"md\" href=\"#\" onclick=\"myEditLinkFunction('../file/people/doctor/$folder_name','');\"><i class=\"fa-solid fa-link\"></i></a>";
                            }?>
                            <h4 class="font-weight-bold"><?php echo $folder_name . " " . $hotlink; ?></h4>
                            <div class="row">
                            <?php
                                $file = glob("../file/people/doctor/$folder_name/*.{jpg,png,gif,PNG,JPG,GIF,JPEG,jpeg}", GLOB_BRACE);
                                $arr = array();
                                foreach($file as $ff) {
                                    $txt = readTxt("$ff.txt");
                                    $arr[(int) explode("_", str_replace("../file/people/doctor/$folder_name/", "", $ff), 2)[0]] = array("name"=>array_shift($txt),"file"=>$ff,"text"=>$txt);
                                }
                                for($currIndex = 1; $currIndex <= count($arr); $currIndex++) {
                                    $rndid = "_".generateRandom();
                                    $a = $arr[$currIndex];
                                    $fi = $a["file"];
                                    $file_name = pathinfo($fi, PATHINFO_FILENAME).".".pathinfo($fi, PATHINFO_EXTENSION);
                                    $title = $a["name"];
                                    $description = $a["text"]; ?>
                                    <div class="col-12 col-xl-6 d-flex align-items-stretch">
                                        <div class="card mb-3 w-100">
                                            <div class="row no-gutters" id="targetZone_<?php echo $rndid;?>">
                                                <div class="col-md-5 col-12">
                                                    <img src="<?php echo $fi; ?>" class="card-img" style="min-weight: 100%; height:300px; object-fit: cover; object-position: top;"/>
                                                </div>
                                                <div class="col-md-7 col-12">
                                                    <div class="card-body">
                                                        <h5 class='font-weight-bold'><?php echo $title; ?>
                                                            <?php if ($isAdmin) { ?>
                                                            <small>
                                                                <a class="text-warning mt-0 mr-1 ml-0 mb-0 z-depth-0" style="border:0;" onclick="editField('<?php echo $rndid; ?>');"><i class="fa fa-pencil-alt"></i></a>
                                                                <a class="text-danger mt-0 mr-0 ml-0 mb-0 z-depth-0" style="border:0;" onclick="myDeleteFileFunction('<?php echo $fi; ?>');"><i class="fas fa-trash"></i></a>
                                                            </small>
                                                            <?php } ?>
                                                        </h5>
                                                        <div class="overflow-auto" style="max-height: 220px;"><?php foreach($description as $d) { echo $d."<br>"; } ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($isAdmin) { ?>
                                            <div style="display: none;" id="targetEditZone_<?php echo $rndid;?>">
                                                <form method="POST" action="../endpoint/people_IO.php?function=update&index=<?php echo $currIndex; ?>&id=<?php echo $rndid; ?>&target=<?php echo $fi; ?>" enctype="multipart/form-data">
                                                    <input type="hidden" name="path" value="../file/people/doctor/<?php echo $folder_name; ?>/">
                                                    <input type="hidden" name="pathFolder" value="<?php echo $folder_name; ?>">
                                                    <div class="row no-gutters">
                                                        <div class="col-5">
                                                            <div class="view overlay">
                                                                <input type="hidden" name="id" id="id" value="<?php echo $rndid; ?>"/>
                                                                <img src="<?php echo $fi; ?>" class="card-img-top" loading="lazy" id="demoImg_<?php echo $rndid; ?>" style="width: 100%; height:300px; object-fit: cover; object-position: top;"/>
                                                                <input type="file" style="display: none;" id="img_<?php echo $rndid; ?>" name="img_<?php echo $rndid; ?>" aria-describedby="img" accept="image/png, image/jpeg, image/gif, image/webp">
                                                                <div class="mask flex-center rgba-black-light text-white" style="cursor: pointer;" onclick="$('#img_<?php echo $rndid; ?>').click();">
                                                                    <i class="fa fa-upload"></i>
                                                                </div>
                                                                <script>
                                                                    document.getElementById("img_<?php echo $rndid; ?>").onchange = function () {
                                                                        var reader = new FileReader();
                                                                        reader.onload = function (e) { document.getElementById("demoImg_<?php echo $rndid; ?>").src = e.target.result; };
                                                                        reader.readAsDataURL(this.files[0]);
                                                                    };        
                                                                </script>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="flex-grow-1">
                                                                        <h5 class='font-weight-bold'><input type="text" placeholder="ชื่อ-สกุล" class="form-control mb-1" value="<?php echo $title; ?>" id="name_<?php echo $rndid; ?>" name="name_<?php echo $rndid; ?>" required></input></h5>
                                                                    </div>
                                                                    <div class="flex-shrink-1 ml-auto">                                                
                                                                        <button type="submit" value="update" name="method" class="btn-floating btn-sm btn-success mt-0 mb-0 z-depth-0" style="border:0;"><i class="fa fa-save"></i></button>
                                                                    </div>
                                                                </div>
                                                                <textarea rows="8" class="form-control" name="description_<?php echo $rndid; ?>" id="description_<?php echo $rndid; ?>" placeholder="คำอธิบาย" style="resize:none; max-height: 220px;"><?php for($d = 0; $d < count($description); $d++) { echo $description[$d]; } ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php 
                                }
                            ?>
                            <?php if ($isAdmin) {
                                $temp = generateRandom(8);?>
                                <div class="col-12 col-xl-6 d-flex align-items-stretch">
                                    <div class="card mb-3 w-100">
                                    <form method="POST" action="../endpoint/people_IO.php?function=create" enctype="multipart/form-data">
                                        <input type="hidden" name="path" value="../file/people/doctor/<?php echo $folder_name; ?>/">
                                        <input type="hidden" name="pathFolder" value="<?php echo $folder_name; ?>">
                                            <div class="row no-gutters">
                                                <div class="col-md-5 col-12">
                                                    <div class="view overlay">
                                                        <img src="../static/asset/people.jpg" class="card-img" id="demoImg_<?php echo $temp; ?>" style="width: 100%; height:300px; object-fit: cover;"/>
                                                        <input required type="file" style="display: none;" id="img_<?php echo $temp; ?>" name="img" aria-describedby="img" accept="image/png, image/jpeg, image/gif, image/webp">
                                                        <div class="mask flex-center rgba-black-light text-white" style="cursor: pointer;" onclick="$('#img_<?php echo $temp; ?>').click();">
                                                            <i class="fa fa-upload"></i>
                                                        </div>
                                                        <script>
                                                            document.getElementById("img_<?php echo $temp; ?>").onchange = function () {
                                                                var reader = new FileReader();
                                                                reader.onload = function (e) { document.getElementById("demoImg_<?php echo $temp; ?>").src = e.target.result; };
                                                                reader.readAsDataURL(this.files[0]);
                                                            };        
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-12">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="flex-grow-1">
                                                                <h5 class='font-weight-bold'><input type="text" placeholder="ชื่อ-สกุล" class="form-control mb-1" value="" id="name" name="name" required></input></h5>
                                                            </div>
                                                            <div class="flex-shrink-1 ml-auto">                                                
                                                                <button type="submit" value="create" name="method" class="btn-floating btn-sm btn-success mt-0 mb-0 z-depth-0" style="border:0;"><i class="fa fa-save"></i></button>
                                                            </div>
                                                        </div>
                                                        <textarea rows="8" class="form-control" name="description" id="description" placeholder="คำอธิบาย" style="resize:none; max-height: 220px;"></textarea>
                                                    </div>
                                                </div>
                                        </div>
                                    </form>
                                    </div>

                                </div>
                            <?php } ?>
                            </div>
                        </div>    
                    <?php } ?>
                </div>
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