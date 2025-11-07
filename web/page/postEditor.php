<?php
    require_once '../static/function/connect.php';
?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
        <!-- JQuery TagEditor -->
        <link rel="stylesheet" href="../static/library/jQuery-tagEditor-1.0.21/jquery.tag-editor.css">
        <script src="../static/library/jQuery-tagEditor-1.0.21/jquery.tag-editor.min.js" type="text/javascript"></script>
        <script src="../static/library/jQuery-tagEditor-1.0.21/jquery.caret.min.js" type="text/javascript"></script>
        <script src="../static/library/ckeditor-4.18.0/ckeditor.js"></script>
        <script src="../static/library/ckfinder-3.4.2/ckfinder.js"></script>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <?php
        $post; $id; $method = "create"; $attachment = "";
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $post = new Post($id);
            if (!empty($post)) $method = "update";
            if (file_exists("../file/post/$id/attachment/")) {
                $files_in_attachment = glob("../file/post/$id/attachment/*");
                $i = 0;
                foreach($files_in_attachment as $atm) {
                    $attachment .= str_replace("../file/post/$id/attachment/", "", $atm);
                    if (++$i != count($files_in_attachment)) $attachment .= ", ";
                }
            }
        } else {
            $post = new Post(-1);
        }
    ?>
    <body>
        <?php needAdmin(); ?>
        <div class="container-fluid px-lg-5 px-3">
            <h4><a onclick="window.history.back();" class="md float-left"><i class="fas fa-arrow-left"></i> Back</a><br></h4>
            <form method="POST" action="../endpoint/postEditorSave.php<?php if ($method == "update") echo "?news=$id"; ?>" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="method" value="<?php echo $method; ?>"/>
                <div class="md-form form-lg mt-3mb-0">
                    <input type='text' class='form-control form-control-lg font-weight-bold mt-0 mb-0' id='title' name='title' aria-label='title' required value='<?php echo $post->getTitle(); ?>'>
                    <label for="title" class="font-weight-bold text-dark">หัวข้อ</label>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-8 order-lg-1 order-2">
                        <div class="card card-body mb-3">
                            <textarea name="articleEditor"><?php echo $post->getArticle();?></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 order-1 order-lg-2">
                        <div class="card card-body mb-3">
                            <small class="font-weight-bold text-dark">ภาพหน้าปก</small>
                            <div class="md-form file-field mt-0 mb-0">
                                <div class="btn btn-primary btn-sm float-left ml-0">
                                    <span><i class="fas fa-file-upload"></i> Browse</span>
                                    <input type="file" name="cover" id="cover" class="validate" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate disabled" type="text" id="coverURL" name="coverURL"
                                        placeholder="รูปหน้าปก (Cover Image)" value="<?php echo $post->getProperty("cover"); ?>">
                                </div>
                                <img src="<?php echo empty($post->getProperty("cover")) ? "../static/asset/1280x720.jpg" : $post->getProperty("cover"); ?>" class="img-fluid w-100" loading="lazy" id="coverThumb">
                                <input type="hidden" name="real_cover" id="real_cover" value="<?php echo $post->getProperty("cover"); ?>"/>
                                <div class="text-right"><small><a href="#" class="text-danger" onclick="clearCover()">ล้างรูปหน้าปก</a></small></div>
                                <script>
                                    function clearCover() {
                                        $("#coverURL").val("");
                                        $("#real_cover").val("");
                                        $("#coverThumb").attr("src","../static/asset/1280x720.jpg");
                                    }
                                </script>
                            </div>                     
                        </div>
                        <div class="card card-body mb-3">
                            <label for="group" class="font-weight-bold text-dark">หมวดหมู่ <a class="material-tooltip-main" data-toggle="tooltip" title="หมวดหมู่จะถูกลบออกเมื่อไม่มีโพสต์ใด ๆ ในหมวดหมู่นั้น ๆ"><i class='fas fa-question-circle text-info'></i></a>
                                <a class="material-tooltip-main" data-toggle="tooltip" title="ไม่สามารถใช้ตัวอักษรต่อไปนี้: ?, #, /, \" href="#"><i class="fa-solid fa-triangle-exclamation text-danger"></i></a>
                            </label>
                            <select class="mdb-select md-form colorful-select dropdown-primary mb-0" id="group" name="group" required editable="true" searchable="🔎 พิมพ์เพื่อค้นหาหรือเพิ่มหมวดหมู่">
                                <?php foreach(listCategory() as $l) { ?>
                                <option value="<?php echo $l; ?>" <?php if (($method == "create" && isset($_GET['c']) && ($l == $_GET['c'])) || ($l == $post->getProperty("category"))) echo "selected"; ?>><?php echo $l; ?></option>
                                <?php } ?>
                            </select>
                            <small class="font-weight-bold text-dark">แท็ก</small>
                            <textarea name="tags" id="tags"><?php if ($method == "create" && isset($_GET['t'])) echo $_GET['t']; else if ($post->getProperty('tag')) { foreach($post->getProperty('tag') as $p) echo "$p,"; } ?></textarea>
                            <script>
                                $('#tags').tagEditor();
                            </script>
                            <small class="font-weight-bold text-dark mt-3">ไฟล์แนบท้าย</small>
                            <div class="md-form file-field mt-0 mb-0">
                                <div class="btn btn-c-md btn-sm float-left" id="attachmentZone">
                                    <span><i class="fas fa-file-upload"></i> Browse</span>
                                    <input type="file" name="attachment[]" id="attachment" class="validate" multiple>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate disabled" type="text" id="attachmentURL" name="attachmentURL" placeholder="ไฟล์แนบท้าย" value="<?php echo $attachment;?>">
                                </div>
                                <div class="text-right"><small><a href="#" class="text-danger" onclick="clearAttachment();">ล้างไฟล์แนบท้าย</a></small></div>
                                <script>
                                    function clearAttachment() {
                                        $("#attachmentURL").val("");
                                    }
                                </script>
                            </div>
                            <div class="md-form mb-0">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1 mr-2"><button type="submit" class="btn btn-success btn-block mt-1 font-weight-bold" value="บันทึก" name="submit">บันทึก</button></div>
                                    <?php if ($method != "create") { ?>
                                        <?php if ($post->getProperty('allowDelete') == true or true) { ?>
                                            <a class='z-depth-0 ml-0 mr-1 btn-sm btn-danger btn-floating'onclick='swal({title: "ลบข่าวหรือไม่ ?",text: "หลังจากที่ลบแล้ว ข่าวนี้จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/postIO.php?method=delete&id=<?php echo $id; ?>&category=<?php echo $post->getProperty("category"); ?>";}});'><i class="fas fa-trash-alt"></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <script>
                                var editor = CKEDITOR.replace('articleEditor');
                                CKFinder.setupCKEditor(editor);
                            </script>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.select-wrapper.md-form.md-outline input.select-dropdown').bind('focus blur', function () {
                $(this).closest('.select-outline').find('label').toggleClass('active');
                $(this).closest('.select-outline').find('.caret').toggleClass('active');
            });
        });
        document.getElementById("cover").onchange = function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("coverThumb").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        };        
    </script>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; // Footer can be hidden by full comment this line.?>
    <?php require_once '../static/function/script/footer.php'; ?>
</html>