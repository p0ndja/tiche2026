<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head><?php require_once '../static/function/script/head.php'; ?></head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<?php $isAdmin = isAdmin(); ?>
<?php if ($isAdmin) { ?>
<script>
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
    
    function myEditFileFunction(targetFile, tempDisplayName) {
        var folderName = prompt("กรุณาระบุชื่อรูป ห้ามใช้ \\ / : * ? \" < > |", tempDisplayName);
        if (folderName != null && folderName != "") {
            window.location = "../endpoint/people_IO.php?function=rename&old=" + targetFile + "&new=" + folderName;
        }
    }
    
    function editField(targetEditZone) {
        document.getElementById("targetZone_" + targetEditZone).style.display = "none";
        document.getElementById("targetEditZone_" + targetEditZone).style.display = "block";
    }
</script>
<?php } ?>
<body>
    <div class="container">
    <h1 class="font-weight-bold text-center mb-3">ผู้บริหาร</h1>
        <div class="container px-lg-5">
        <?php 
            $fol = glob("../file/people/dean/*", GLOB_ONLYDIR);
            for($f = 0; $f < count($fol); $f++) {
                $folder_name = pathinfo($fol[$f], PATHINFO_FILENAME); ?>
            <div class="tab-pane fade in show <?php if ($f == 0) echo 'active'; ?>" id="<?php echo str_replace(" ", "_", pathinfo($fol[$f], PATHINFO_FILENAME)); ?>" role="tabpanel">
                <div class="row justify-content-center">
                <?php
                    $file = glob("../file/people/dean/$folder_name/*.{jpg,png,gif,PNG,JPG,GIF,JPEG,jpeg}", GLOB_BRACE);
                    $arr = array();
                    foreach($file as $ff) {
                        $txt = readTxt("$ff.txt");
                        $arr[(int) explode("_", str_replace("../file/people/dean/$folder_name/", "", $ff), 2)[0]] = array("name"=>array_shift($txt),"file"=>$ff,"text"=>$txt);
                    }
                    for($currIndex = 1; $currIndex <= count($arr); $currIndex++) {
                        $a = $arr[$currIndex];
                        $fi = $a["file"];
                        $file_name = pathinfo($fi, PATHINFO_FILENAME).".".pathinfo($fi, PATHINFO_EXTENSION);
                        $title = $a["name"];
                        $description = $a["text"]; ?>
                        <?php if ($currIndex == 1) {?><div class="col-0 col-xl-4 d-flex align-items-stretch mb-3"></div><?php }?>
                        <div class="col-12 col-sm-6 col-md-6 col-xl-4 d-flex align-items-stretch mb-3">
                            <div class="card card-cascade mb-1 w-100">
                                <div style="display: block;" id="targetZone_<?php echo $file_name;?>">
                                    <div class="view view-cascade overlay">
                                        <img src="<?php echo $fi; ?>" class="card-img-top" loading="lazy" style="min-width: 100%; height: 400px; object-fit: cover; object-position: top;"/>
                                    </div>
                                    <div class="card-body card-body-cascade">
                                        <h5 class='font-weight-bold'><?php echo $title; ?>
                                            <?php if ($isAdmin) { ?>
                                            <small>
                                                <a class="text-warning mt-0 mr-1 ml-0 mb-0 z-depth-0" style="border:0;" onclick="editField('<?php echo $file_name; ?>');"><i class="fa fa-pencil-alt"></i></a>
                                                <a class="text-danger mt-0 mr-0 ml-0 mb-0 z-depth-0" style="border:0;" onclick="myDeleteFileFunction('<?php echo $fi; ?>');"><i class="fas fa-trash"></i></a>
                                            </small>
                                            <?php } ?>
                                        </h5>
                                        <p><?php foreach($description as $d) { echo $d."<br>"; } ?></p>
                                    </div>
                                </div>
                                <?php if ($isAdmin) { ?>
                                <div style="display: none;" id="targetEditZone_<?php echo $file_name;?>">
                                    <form method="POST" action="../endpoint/people_IO.php?function=update&id=<?php echo $currIndex; ?>&target=<?php echo $fi; ?>" enctype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" name="path" value="../file/people/dean/<?php echo $folder_name; ?>/">
                                        <div class="view view-cascade overlay">
                                            <div class="view overlay">
                                                <input type="hidden" name="id" id="id" value="<?php echo $currIndex; ?>"/>
                                                <img src="<?php echo $fi; ?>" class="card-img-top" loading="lazy" id="demoImg_<?php echo $currIndex; ?>" style="min-width: 100%; height: 400px; object-fit: cover; object-position: top;"/>
                                                <input type="file" style="display: none;" id="img_<?php echo $currIndex; ?>" name="img_<?php echo $currIndex; ?>" aria-describedby="img" accept="image/png, image/jpeg, image/gif, image/webp">
                                                <div class="mask flex-center rgba-black-light text-white" style="cursor: pointer;" onclick="$('#img_<?php echo $currIndex; ?>').click();">
                                                    <i class="fa fa-upload"></i>
                                                </div>
                                                <script>
                                                    document.getElementById("img_<?php echo $currIndex; ?>").onchange = function () {
                                                        var reader = new FileReader();
                                                        reader.onload = function (e) { document.getElementById("demoImg_<?php echo $currIndex; ?>").src = e.target.result; };
                                                        reader.readAsDataURL(this.files[0]);
                                                    };        
                                                </script>
                                            </div>
                                        </div>
                                        <div class="card-body card-body-cascade">
                                            <div class="d-flex justify-content-between">
                                                <div class="flex-grow-1">
                                                    <h5 class='font-weight-bold'><input type="text" placeholder="ชื่อ-สกุล" class="form-control mb-1" value="<?php echo $title; ?>" id="name_<?php echo $currIndex; ?>" name="name_<?php echo $currIndex; ?>" required></input></h5>
                                                </div>
                                                <div class="flex-shrink-1 ml-auto">                                                
                                                    <button type="submit" value="update" name="method" class="btn-floating btn-sm btn-success mt-0 mb-0 z-depth-0" style="border:0;"><i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                            <textarea rows="3" class="form-control" name="description_<?php echo $currIndex; ?>" id="description_<?php echo $currIndex; ?>" placeholder="คำอธิบาย" style="resize:none;"><?php for($d = 0; $d < count($description); $d++) { echo $description[$d]; if ($d != count($description)-1) echo "\n";} ?></textarea>
                                        </div>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($currIndex == 1) {?><div class="col-0 col-xl-4 d-flex align-items-stretch mb-3"></div><?php }?>
                        <?php 
                    }
                ?>
                <?php if ($isAdmin) {
                    $temp = generateRandom(8);?>
                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 d-flex align-items-stretch mb-3">
                        <form method="POST" action="../endpoint/people_IO.php?function=create" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="path" value="../file/people/dean/<?php echo $folder_name; ?>/">
                            <div class="card card-cascade mb-4">
                                <div class="view view-cascade overlay">
                                    <div class="view overlay">
                                        <img src="../static/asset/people.jpg" class="card-img-top" loading="lazy" id="demoImg_<?php echo $temp; ?>" style="min-width: 100%; height: 400px; object-fit: cover;"/>
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
                                <div class="card-body card-body-cascade">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1">
                                            <h5 class='font-weight-bold'><input type="text" placeholder="ชื่อ-สกุล" class="form-control mb-1" value="" id="name" name="name" required></input></h5>
                                        </div>
                                        <div class="flex-shrink-1 ml-auto">                                                
                                            <button type="submit" value="create" name="method" class="btn-floating btn-sm btn-success mt-0 mb-0 z-depth-0" style="border:0;"><i class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                    <textarea rows="3" class="form-control" name="description" id="description" placeholder="คำอธิบาย" style="resize:none;"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
                </div>
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