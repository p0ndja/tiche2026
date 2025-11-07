<?php require_once '../static/function/function.php'; ?>
<?php if (isAdmin()) { ?>
<form action="../endpoint/admin_vdo_save.php" method="post" enctype="multipart/form-data">
    <?php
    $vdo = watchVDO();
    foreach($vdo as $v) { ?> 
        <input type="text" placeholder="ใส่ลิงก์ Embedded Video ของคุณที่นี่..." class="form-control mr-sm-3 mb-1" id="vdo" name="vdo[]" value="<?php echo $v; ?>"></input>
    <?php } ?>
        <input type="text" placeholder="ใส่ลิงก์ Embedded Video ของคุณที่นี่..." class="form-control mr-sm-3 mb-1" id="vdo" name="vdo[]"></input>
    <div id="addOnVDOSection">
    </div>
    <button type="button" class="btn btn-success btn-floating" id="addButton" onclick="addVDOText();"><i class="fas fa-plus"></i></button>
    <script>
        function addVDOText() {
            $("#addOnVDOSection").append('<input type="text" placeholder="ใส่ลิงก์ Embedded Video ของคุณที่นี่..." class="form-control mr-sm-3 mb-1" id="vdo" name="vdo[]"></input>');
        }
    </script>
    <input type="submit" class="btn btn-success" value="Update!"></input>
</form>
<?php } else { echo ErrorMessage::PERMISSION_REQUIRE; }?>