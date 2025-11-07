<?php
    require_once '../static/function/function.php';
    if (isAdmin()) {
?>
<div class="row mb-1">
<?php 
    $carousel_path = "../file/landing/";
    if (!file_exists($carousel_path)) make_directory($carousel_path); //First time load carousel (In case of didn't run mkdir.php)

    $carousel_file = glob($carousel_path . "*", GLOB_BRACE);
    $carousel_count = count($carousel_file);

    for ($carousel_item = 0; $carousel_item < $carousel_count; $carousel_item++) { 
        $carousel_picture_name = pathinfo($carousel_file[$carousel_item], PATHINFO_FILENAME);
        $carousel_picture_ext = pathinfo($carousel_file[$carousel_item], PATHINFO_EXTENSION);
    ?>
    <div class="col-12 mb-1">
        <form action="../endpoint/admin_io.php?method=landing&mode=save&name=<?php echo "$carousel_picture_name.$carousel_picture_ext";?>" method="post" enctype="multipart/form-data" id="carousel_form_<?php echo $carousel_item; ?>" name="carousel_form_<?php echo $carousel_item; ?>" autocomplete="off">
            <img loading="lazy" src="<?php echo $carousel_file[$carousel_item]; ?>" class="w-100 z-depth-1" id="carousel_<?php echo $carousel_item; ?>" name="carousel_<?php echo $carousel_item; ?>"/>
            <input type="file" accept="image/png, image/jpeg, image/gif, image/webp" id="carousel_file_<?php echo $carousel_item;?>" name="carousel_file" class="mt-1">
            <script>
                document.getElementById("carousel_file_<?php echo $carousel_item;?>").onchange = function () {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("carousel_<?php echo $carousel_item;?>").src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                };
            </script>
            <div class="d-flex justify-content-center">
                <a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$('#carousel_form_<?php echo $carousel_item; ?>').submit();"><i class='fas fa-save'></i></a>
                <a class="btn-floating btn-sm btn-danger z-depth-0 ml-0 mr-1 mb-0" onclick='swal({title: "ลบรูปนี้หรือไม่",text: "หลังจากที่ลบแล้ว จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/admin_io.php?method=landing&mode=delete&target=<?php echo "$carousel_picture_name.$carousel_picture_ext"; ?>";}});'><i class="fas fa-trash"></i></a>
            </div>
        </form>
    </div>
    <?php } ?>
    <?php if ($carousel_count == 0) { ?>
    <div class="col-12 mb-1">
        <form action="../endpoint/admin_io.php?method=landing&mode=save" method="post" enctype="multipart/form-data" id="carousel_form_new" name="carousel_form_new" autocomplete="off">
            <img loading="lazy" src="../static/asset/1920x1080.jpg" class="w-100 z-depth-1" id="carousel-preview" />
            <input type="file" accept="image/png, image/jpeg, image/gif, image/webp" id="carousel_file_new" name="carousel_file" class="mt-1">
            <script>
                document.getElementById("carousel_file_new").onchange = function () {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("carousel-preview").src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                };
            </script>
            <div class="d-flex justify-content-center">
                <a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$('#carousel_form_new').submit();"><i class='fas fa-save'></i></a>
            </div>
        </form>
    </div>
    <?php } ?>
</div>
<?php } ?>