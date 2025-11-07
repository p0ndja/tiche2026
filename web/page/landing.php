<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <style>
        @media (max-width: 991.98px) {
            h1 {
                font-size: 1.75rem !important;
            }
        }

        .intro-right {
            min-height: 500px;
            background: url("../static/asset/preset/5 (2).jpg") center center no-repeat;
            background-size: cover;
        }

        .credit {
            margin-top: 3rem;
            font-size: 0.8rem;
            color: #adb5bd;
        }

        div.stretchy-wrapper {
            background-color: white;
            position: relative;
            height: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
        }

        div.stretchy-wrapper > div {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-xl-5 col-lg-6 col-md-8 p-5 p-lg-4 mx-auto d-flex align-items-center order-2 order-lg-1">
                <div>
                <p> <img src="../static/asset/logo/android-icon-192x192.png" width="120" height="120"
                    alt="Template Logo"></p>
                <h1 class="font-weight-bold display-4">Department of Anesthesiology</h1>
                <p class="font-weight-normal text-uppercase mb-3 md">Faculty of Medicine, Khon Kaen University</p>
                <h3 class="font-weight-light FC_Iconic">ภาควิชาวิสัญญีวิทยา<br>คณะแพทยศาสตร์ มหาวิทยาลัยขอนแก่น</h3>
                <a href="../" class="btn btn-success btn-lg btn-block">เข้าสู่เว็บไซด์</a>
                <p class="credit">Made with <span class="text-danger">❤</span> by <a href="https://www.pondja.com/" class="text-success">PondJaᵀᴴ</a><br>&copy; <script>document.write(new Date().getFullYear());</script> ภาควิชากุมารเวชศาสตร์ คณะแพทยศาสตร์ มหาวิทยาลัยขอนแก่น</p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-5 col-md-4 intro-right order-1 order-lg-2"></div>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>