<?php
    require_once '../static/function/connect.php';
    if (isAdmin()) {
        if (!isset($_GET['topic']) || empty($_GET['topic'])) die(PresetMessage::UNEXPECTED_ERROR);
        $topic = $_GET['topic'];
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $link = ($id == -1) ? array("icon"=>null,"link"=>null,"text"=>null) : getDatatable($topic."Hotlink")[$id];
        if ($link['link'] == "#") $link['link'] = "";
?>
<form method="POST" action="../endpoint/admin_io.php?method=hotlink&topic=<?php echo $topic;?>&mode=edit&target=<?php echo $id; ?>" name="<?php echo $topic;?>_editor" id="<?php echo $topic;?>_editor">
    <div class="text-center"><span class="display-6 badge badge-md mb-3 z-depth-1" id="<?php echo $topic;?>_previewIcon"><?php if (!empty($link['icon'])) echo $link['icon']; else echo "<span class=\"material-symbols-outlined\">question_mark</span>"; ?></span></div>
    <script>
        function previewIcon() {
            var icon = document.getElementById('<?php echo $topic;?>_icon').value.replace(/(\r\n|\n|\r)/gm, "");
            console.log(icon);
            if (/<([A-Za-z][A-Za-z0-9]*)\b[^>]*>(.*?)<\/\1>/.test(icon)) {
                document.getElementById('<?php echo $topic;?>_icon').value = icon;
                document.getElementById('<?php echo $topic;?>_previewIcon').innerHTML = icon;
            } else {
                console.log("default");
                document.getElementById('<?php echo $topic;?>_previewIcon').innerHTML = "<span class=\"material-symbols-outlined\">question_mark</span>";
            }
        }
    </script>
    </script>
    <div class="input-group flex-nowrap">
        <div class="input-group-prepend">
            <span class="input-group-text" id="icon_addon">ไอคอน</span>
        </div>
        <textarea style="resize: none;" onchange="previewIcon()" type="text" class="form-control" placeholder="icon" aria-label="icon"name="<?php echo $topic;?>_icon" id="<?php echo $topic;?>_icon" aria-describedby="icon_addon" rows=1><?php if (!empty($link['icon'])) echo $link['icon']; ?></textarea>
        <div class="input-group-append pl-1">
            <a href="https://fonts.google.com/icons" target="_blank" class="px-2 mt-1 md"><i class="fa-solid fa-ellipsis"></i></a>
        </div>
    </div>
    <div class="input-group flex-nowrap">
        <div class="input-group-prepend">
            <span class="input-group-text" id="title_addon">ชื่อ</span>
        </div>
        <input type="text" class="form-control" placeholder="title" aria-label="title" aria-describedby="title_addon"name="<?php echo $topic;?>_title" id="title" value="<?php echo $link['text']; ?>">
    </div>
    <div class="input-group flex-nowrap">
        <div class="input-group-prepend">
            <span class="input-group-text" id="link_addon">ลิงก์</span>
        </div>
        <input type="text" class="form-control" placeholder="link" aria-label="link" aria-describedby="link_addon"name="<?php echo $topic;?>_link" id="link" value="<?php echo $link['link']; ?>">
    </div>
    <div class="text-center">
        <a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$('#<?php echo $topic;?>_editor').submit();"><i class='fas fa-save'></i></a>
        <?php if ($id != -1) { ?>
        <a class="btn-floating btn-sm btn-danger z-depth-0 ml-0 mr-1 mb-0" onclick='swal({title: "ลบลิงก์นี้หรือไม่",text: "หลังจากที่ลบแล้ว จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/admin_io.php?method=hotlink&topic=<?php echo $topic;?>&mode=delete&target=<?php echo $id; ?>";}});'><i class="fas fa-trash"></i></a>
        <?php } ?>
    </div>
</form>
<?php } ?>