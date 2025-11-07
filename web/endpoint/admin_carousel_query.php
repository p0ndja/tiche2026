<?php require_once '../static/function/function.php'; if (isAdmin()) { ?>
<div class="alert alert-warning z-depth-1"><text class='font-weight-bold'>คำเตือน:</text> ข้อมูลจะถูกบันทึกทีละส่วน และจะไม่ถูกบันทึกพร้อมกันทั้งหมด</div>
<div class="mb-1">
<?php 
    $carousel_path = "../file/carousel/";

    if (!file_exists($carousel_path)) make_directory($carousel_path); //First time load carousel (In case of didn't run mkdir.php)
    
    $carousel_file = glob($carousel_path . "*.{JPG,jpg,JPEG,jpeg,PNG,png,GIF,gif}", GLOB_BRACE);
    $carousel_count = count($carousel_file);

    for ($carousel_item = 0; $carousel_item < $carousel_count; $carousel_item++) { 
        $carousel_picture_name = pathinfo($carousel_file[$carousel_item], PATHINFO_FILENAME);
        $carousel_picture_ext = pathinfo($carousel_file[$carousel_item], PATHINFO_EXTENSION);
        $carousel_picture_text = readTxt("$carousel_path$carousel_picture_name.$carousel_picture_ext.txt");
    ?>
    <form action="../endpoint/admin_io.php?method=carousel&mode=save&id=<?php echo $carousel_item;?>&name=<?php echo "$carousel_picture_name.$carousel_picture_ext";?>" method="post" enctype="multipart/form-data" id="carousel_form_<?php echo $carousel_item; ?>" name="carousel_form_<?php echo $carousel_item; ?>" autocomplete="off">
        <div class="row mb-3">
            <div class="col-12 col-md-4">
                <img loading="lazy" src="<?php echo $carousel_file[$carousel_item]; ?>" class="w-100 z-depth-1 mb-2" id="carousel_<?php echo $carousel_item; ?>" name="carousel_<?php echo $carousel_item; ?>"/>
            </div>
            <div class="col-12 col-md-8">
                <input type="file" accept="image/png, image/jpeg, image/gif" id="carousel_file_<?php echo $carousel_item;?>" name="carousel_file" class="mb-2">
                <script>
                    document.getElementById("carousel_file_<?php echo $carousel_item;?>").onchange = function () {
                        var reader = new FileReader();
                        reader.onload = function (e) { document.getElementById("carousel_<?php echo $carousel_item;?>").src = e.target.result; };
                        reader.readAsDataURL(this.files[0]);
                    };
                </script>
                <?php $carousel_picture_text_lines = "";
                    foreach($carousel_picture_text as $carousel_picture_text_each_line) {
                        $carousel_picture_text_lines .= $carousel_picture_text_each_line;
                    } ?>
                <h4 class="card-title"><input type="text" placeholder="วางลิงก์ที่นี่..." class="form-control mr-sm-3" value="<?php echo $carousel_picture_text_lines; ?>" id="carouselTitle" name="cTitle"></input></h4>
                <div class="mb-0 d-flex justify-content-between">
                    <div class="flex-grow-1"></div>
                    <a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$('#carousel_form_<?php echo $carousel_item; ?>').submit();"><i class='fas fa-save'></i></a>
                    <a class="btn-floating btn-sm btn-danger z-depth-0 ml-0 mr-1 mb-0" onclick='swal({title: "ลบรูปนี้หรือไม่",text: "หลังจากที่ลบแล้ว จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/admin_io.php?method=carousel&mode=delete&target=<?php echo "$carousel_picture_name.$carousel_picture_ext"; ?>";}});'><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
        <hr>
    </form>
    <?php } ?>
    <form action="../endpoint/admin_io.php?method=carousel&mode=save" method="post" enctype="multipart/form-data" id="carousel_form_new" name="carousel_form_new" autocomplete="off">
        <div class="row mb-3">
            <div class="col-12 col-md-4">
                <img loading="lazy" src="../static/asset/1920x1080.jpg" class="w-100 z-depth-1 mb-2" id="carousel-preview" />
            </div>
            <div class="col-12 col-md-8">
                <input type="file" accept="image/png, image/jpeg, image/gif" id="carousel_file_new" name="carousel_file" class="mb-2">
                <script>
                    document.getElementById("carousel_file_new").onchange = function () {
                        var reader = new FileReader();
                        reader.onload = function (e) { document.getElementById("carousel-preview").src = e.target.result; };
                        reader.readAsDataURL(this.files[0]);
                    };
                </script>
                <h4 class="card-title"><input type="text" placeholder="วางลิงก์ที่นี่..." class="form-control mr-sm-3" value="" id="carouselTitle" name="cTitle"></input></h4>
                <div class="mb-0 d-flex justify-content-between">
                    <div class="flex-grow-1"></div>
                    <a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$('#carousel_form_new').submit();"><i class='fas fa-save'></i></a>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>