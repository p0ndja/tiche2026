<?php $carousel_file = glob("../file/landing/*", GLOB_BRACE); if (count($carousel_file)) { ?>
<div class="modal animated fade" id="landingIMGModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img class="imagepreview img img-fluid w-100 mt-2" loading="lazy" src="<?php echo $carousel_file[0]; ?>">
                <div class="text-center"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger display-8 font-weight-bold">ปิดหน้าต่าง <span aria-hidden="true">&times;</span></button></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Modal -->
<div class="modal fade" id="picPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img class="imagepreview img img-fluid w-100" loading="lazy" src="">
            </div>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopupVisit" name="modalPopupVisit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เปิด Visit ออนไลน์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <img class="imagepreview img img-fluid w-100 mt-2" src="https://srinagarind.md.kku.ac.th/file/ckeditor/files/279643422_405721934495963_2302249171119158472_n.png" loading="lazy">
                <div class="text-center"><a href="https://line.me/ti/p/@mrd-kku" class="btn btn-c-md font-weight-bold" target="_blank">ไปยังเว็บไซต์</a></div>
            </div>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopupSPR" name="modalPopupSPR" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-md">
                <h5 class="modal-title">รายละเอียดห้องพิเศษ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <img class="imagepreview img img-fluid w-100 mt-2" src="https://srinagarind.md.kku.ac.th/file/ckeditor/files/312239676_451381173788100_8651897068370721767_n.jpg" loading="lazy">
            </div>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopupReg" name="modalPopupReg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลงทะเบียนผู้ป่วยใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <img class="imagepreview img img-fluid w-100 mt-2" src="https://srinagarind.md.kku.ac.th/file/ckeditor/files/281169293_380395077440763_3492258568254715880_n.jpg" loading="lazy">
                <div class="text-center"><a href="https://regist.md.kku.ac.th" class="btn btn-c-md font-weight-bold" target="_blank">ไปยังเว็บไซต์</a></div>
            </div>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopup" name="modalPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="modalBodyBody"><div id="modalBody"></div></div>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopupXL" name="modalPopupXL" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-md modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleXL"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="modalBodyBodyXL"><div id="modalBodyXL"></div></div>
        </div>
    </div>
</div>
<!-- Webstats Modal -->
<div class="modal animated fade" id="webstatsModal" name="webstatsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-md modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">สถิติเว็บไซต์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"><?php include '../static/function/stats/counter.php'; ?></div>
        </div>
    </div>
</div>
<?php if (isAdmin()) { ?>
<script>
    function CarouselModal() {$('#modalTitleXL').html('แก้ไขรูปแบนเนอร์');$('#modalBodyXL').html('');$.ajax({type: 'GET',url: '../endpoint/admin_carousel_query.php',success: function (data) {$('#modalBodyXL').html(data);}});}
    function HRD_CultureModal() {$('#modalTitleXL').html('HRD - ค่านิยมองค์กร');$('#modalBodyXL').html('');$.ajax({type: 'GET',url: '../endpoint/admin_HRD_query.php',success: function (data) {$('#modalBodyXL').html(data);}});}
    /*function HRD_ACTSModal() {$('#modalTitleXL').html('HRD - ACTS+3S');$('#modalBodyXL').html('<form method="POST" action="../endpoint/admin_HRD_save.php?target=ACTS" id="HRDDataForm"><textarea name="HRDarticleEditor" id="HRDarticleEditor"><?php echo (getDatatable("HRD"))["ACTS"];?></textarea><div class="text-center"><a class="btn-floating btn-sm btn-success z-depth-0 ml-0 mr-1 mb-0" onclick="$(\'#HRDDataForm\').submit();"><i class=\'fas fa-save\'></i></a></div></form>');CKFinder.setupCKEditor(CKEDITOR.replace('HRDarticleEditor'));}*/
    function LandingModal() {$('#modalTitleXL').html('Set Pop-up Announcement');$('#modalBodyXL').html('');$.ajax({type: 'GET',url: '../endpoint/admin_landing_query.php',success: function (data) {$('#modalBodyXL').html(data);}});}
    function HotlinkModal(topic,id) {$('#modalTitle').html('แก้ไขลิงก์');$('#modalBody').html('');$.ajax({type: 'GET',url: '../endpoint/admin_hotlink_query.php?id='+id+"&topic="+topic,success: function (data) {$('#modalBody').html(data);}});}
    function VDOModal() {$('#modalTitle').html('แก้ไขรายการวิดีโอแนะนำ');$('#modalBody').html('');$.ajax({type: 'GET',url: '../endpoint/admin_vdo_query.php',success: function (data) {$('#modalBody').html(data);}});}
</script>
<?php } ?>
<?php if (isLogin()) { ?>
<div class="modal fade right" id="futureCpanel" tabindex="-1" role="dialog" aria-labelledby="cpanelTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-full-width modal-right modal-sm" role="document">
        <div class="modal-content-full-width modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cpanelTitle">สวัสดี!
                    <?php echo $_SESSION['currentActiveUser']->getName().'#'.$_SESSION['currentActiveUser']->getID(); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a class="dropdown-item md-dark" href="../profile/"> แก้ไขข้อมูลส่วนตัว <i class="fas fa-user-tie"></i></a>
                <?php if (isAdmin()) { ?>
                <hr>
                <a class="dropdown-item md-dark" href="../admin/post"> จัดการโพสต์ <i class="fas fa-book"></i></a>
                <a class="dropdown-item md-dark" href="../user/"> จัดการบัญชีผู้ใช้งาน <i class="fas fa-user-tie"></i></a>
                <a class="dropdown-item md-dark" href="#" onclick='CarouselModal();' data-toggle='modal' data-target='#modalPopupXL' data-dismiss="modal" aria-label="Close"> แก้ไขรูปแบนเนอร์ <i class="fa-solid fa-images"></i></a>
                <a class="dropdown-item md-dark" href="#" onclick='LandingModal();' data-toggle='modal' data-target='#modalPopupXL' data-dismiss="modal" aria-label="Close"> แก้ไขรูปประชาสัมพันธ์ <i class="fa-solid fa-bullhorn"></i></a>
                <?php } ?>
                <hr>
                <a class="dropdown-item text-danger" href="../logout/">ออกจากระบบ <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if (isset($_SESSION['SweetAlert'])) $_SESSION['SweetAlert']->show(); ?>
<?php if (isset($_GET['popup'])) {if ($_GET['popup'] == "carousel") { ?><script>CarouselModal();$("#modalPopupXL").modal("show");window.history.replaceState(null, null, window.location.pathname);</script><?php } if ($_GET['popup'] == "landing") { ?><script>LandingModal();$("#modalPopupXL").modal("show");window.history.replaceState(null, null, window.location.pathname);</script><?php } if ($_GET['popup'] == "HRD") { ?><script>HRDCarouselModal();$("#modalPopupXL").modal("show");window.history.replaceState(null, null, window.location.pathname);</script><?php }}?>
<?php if (!isset($_SESSION['announcementPopup']) && count(glob("../file/landing/*", GLOB_BRACE))) { $_SESSION['announcementPopup'] = true; ?><script>$("#landingIMGModal").modal("show");</script><?php } ?>