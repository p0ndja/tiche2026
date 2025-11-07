<?php require_once '../static/function/connect.php'; ?>
<script>function logoutBtn() { swal({title:"ออกจากระบบ ?",text:"คุณต้องการออกจากระบบหรือไม่?",icon:"warning",buttons:true,dangerMode:true}).then((willDelete) => {if (willDelete) window.location = "../logout/";}); }</script>
<!-- <style>
    .fixed-top-image {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000; /* Ensure it stays on top of other content */
    }
</style> -->
<div class="container text-uppercase">
<img src="/static/asset/header_web.png" style="" class="fixed-top-image img-fluid"/>
</div>
<div class="mb-1 mb-md-3 d-none"></div>
<div class="container text-uppercase">
    <nav class="navbar navbar-md navbar-expand-lg navbar-light navbar-normal p-0 navbar-color-one" style="font-weight: 500;">
        <button id="navbarCollapseButton" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler mx-auto">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/">Home</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/1">Organizers</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/2">Scientific Committee</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/3">Sessions</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/5">Program</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/9">Publication Partners</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/10">Sponsors</a>
                </li>
                <li class="nav-item">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/7">Contact</a>
                </li>
                <!-- <li class="nav-item navbar-border-right dropdown">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">บุคลากร</a>
                    <ul aria-labelledby="dropdownMenu1" class="dropdown-menu dropdown-md">
                        <li><a class="dropdown-item" href="../people/doctor">คณาจารย์ปัจจุบัน</a></li>
                        <li><a class="dropdown-item" href="../people/colleague">แพทย์ใช้ทุน/แพทย์ประจำบ้าน</a></li>
                        <li><a class="dropdown-item" href="../people/colleague2">แพทย์ประจำบ้านต่อยอด</a></li>
                        <li><a class="dropdown-item" href="../people/staff">บุคลากรสายสนับสนุน</a></li>
                        <li><a class="dropdown-item" href="/post/4">อดีตคณาจารย์</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle mb-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ทำเนียบศิษย์เก่า</a>
                            <ul class="dropdown-menu dropdown-md border-0 shadow">
                                <a class="dropdown-item" href="/post/5">แพทย์ใช้ทุน/แพทย์ประจำบ้าน</a>
                                <a class="dropdown-item" href="/post/6">แพทย์ประจำบ้านต่อยอด</a>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </nav>
</div>
<div class="container text-uppercase">
    <nav class="navbar navbar-md navbar-expand-lg navbar-dark navbar-normal p-0 navbar-color-two" style="font-weight: 500;">
        <!-- <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler mx-auto">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div id="navbarContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/submission/abstract">Abstract Submission <!--<sup><span class="badge badge-danger">CLOSED</span></sup>--></a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/submission/full-paper">Full Paper Submission</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/registration/">Registration <!--<sup><span class="badge badge-danger">CLOSED</span></sup>--></a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/post/4">Presentation Guideline</a>
                </li>
                <li class="nav-item">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/download/">DOWNLOAD</a>
                </li>
                <!-- <li class="nav-item navbar-border-right dropdown">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">บุคลากร</a>
                    <ul aria-labelledby="dropdownMenu1" class="dropdown-menu dropdown-md">
                        <li><a class="dropdown-item" href="../people/doctor">คณาจารย์ปัจจุบัน</a></li>
                        <li><a class="dropdown-item" href="../people/colleague">แพทย์ใช้ทุน/แพทย์ประจำบ้าน</a></li>
                        <li><a class="dropdown-item" href="../people/colleague2">แพทย์ประจำบ้านต่อยอด</a></li>
                        <li><a class="dropdown-item" href="../people/staff">บุคลากรสายสนับสนุน</a></li>
                        <li><a class="dropdown-item" href="/post/4">อดีตคณาจารย์</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle mb-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ทำเนียบศิษย์เก่า</a>
                            <ul class="dropdown-menu dropdown-md border-0 shadow">
                                <a class="dropdown-item" href="/post/5">แพทย์ใช้ทุน/แพทย์ประจำบ้าน</a>
                                <a class="dropdown-item" href="/post/6">แพทย์ประจำบ้านต่อยอด</a>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </nav>
</div>
<div class="container">
    <nav class="navbar navbar-md navbar-expand-lg navbar-dark navbar-normal p-0 navbar-color-three" style="font-weight: 500;">
        <!-- <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler mx-auto">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div id="navbarContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/submission/senior">TIChE SENIOR PROJECT CONTEST 2026</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2" href="/submission/school">TIChE HIGH SCHOOL PROJECT CONTEST 2026</a>
                </li>
                <!-- <li class="nav-item navbar-border-right dropdown">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">บุคลากร</a>
                    <ul aria-labelledby="dropdownMenu1" class="dropdown-menu dropdown-md">
                        <li><a class="dropdown-item" href="../people/doctor">คณาจารย์ปัจจุบัน</a></li>
                        <li><a class="dropdown-item" href="../people/colleague">แพทย์ใช้ทุน/แพทย์ประจำบ้าน</a></li>
                        <li><a class="dropdown-item" href="../people/colleague2">แพทย์ประจำบ้านต่อยอด</a></li>
                        <li><a class="dropdown-item" href="../people/staff">บุคลากรสายสนับสนุน</a></li>
                        <li><a class="dropdown-item" href="/post/4">อดีตคณาจารย์</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle mb-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ทำเนียบศิษย์เก่า</a>
                            <ul class="dropdown-menu dropdown-md border-0 shadow">
                                <a class="dropdown-item" href="/post/5">แพทย์ใช้ทุน/แพทย์ประจำบ้าน</a>
                                <a class="dropdown-item" href="/post/6">แพทย์ประจำบ้านต่อยอด</a>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </nav>
</div>
<?php if (isLogin() && isAdmin()) { ?>
<div class="container text-uppercase">
    <nav class="navbar navbar-md navbar-expand-lg navbar-dark navbar-normal p-0 navbar-color-four" style="font-weight: 500;">
        <!-- <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler mx-auto">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div id="navbarContent" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" onclick='LandingModal();' data-toggle='modal' data-target='#modalPopupXL'>Pop-up</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/admin/post">Posts</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/admin/user">Users</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/submission-senior/list">Seniors</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/submission-school/list">High Schools</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/submission-abstract/list">Abstracts</a>
                </li>
                <li class="nav-item navbar-border-right">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/submission-paper/list">Full Papers</a>
                </li>
                <li class="nav-item">
                    <a style="font-size:15px!important;" class="nav-link font-weight-bold px-2 px-xl-3 py-2 text-warning" href="/registration/list">Registered</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<?php } ?>
<div class="p-3"></div>
<script>
    $(function () {
        // ------------------------------------------------------- //
        // Multi Level dropdowns
        // ------------------------------------------------------ //
        $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).siblings().toggleClass("show");
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item navbar-border-right.dropdown.show').on('hidden.bs.dropdown', function (e) {
                $('.dropdown-submenu .show').removeClass("show");
            });
        });
    });
</script>
