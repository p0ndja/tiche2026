<?php
    require_once '../static/function/connect.php'; 
    if (isAdmin()) { ?>
        <form method="POST" action="../endpoint/admin_HRD_save.php?target=Culture" id="HRDDataForm">
            <textarea name="HRDarticleEditor" id="HRDarticleEditor"><?php echo (getDatatable("HRD"))["Culture"];?></textarea>
            <div class="text-center">
                <a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$('#HRDDataForm').submit();"><i class='fas fa-save'></i></a>
            </div>
        </form>
        <script>CKFinder.setupCKEditor(CKEDITOR.replace('HRDarticleEditor'));</script>
<?php }
?>