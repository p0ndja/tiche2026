<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<?php if (isLogin()) home(); ?>
<body>
    <div class="container" id="container">
        <div class="center">
            <form id="resetForm" method="post" action="../endpoint/password_lookup.php" enctype="multipart/form-data" autocomplete="off">
                <h1 class="display-5 font-weight-bold text-center text-md">Reset Password</h1>
                <div class="card">
                    <!--Body-->
                    <div class="card-body mb-1">
                        <?php if (isset($_SESSION['auth_error'])) {echo '<div class="alert alert-danger" role="alert">'. $_SESSION['auth_error'] .'</div>'; $_SESSION['auth_error'] = null;} ?>
                        <h6 class="text-center">ส่งคำร้องรีเซ็ตรหัสผ่าน</h6>
                        <div class="md-form form-sm mb-3">
                            <i class="fas fa-users prefix"></i>
                            <input type="email" name="reset" id="reset"
                                class="form-control form-control-sm validate mb-2" required placeholder="กรุณาใส่อีเมลที่คุณใช้สมัครบัญชีผู้ใช้">
                            <label for="reset">Reset Password</label>
                        </div>
                        <div class="cf-turnstile mb-3" data-theme="light" data-sitekey="0x4AAAAAABh0HRZB4iCc89in"></div>
                        <button class="btn btn-md btn-c-md btn-block font-weight-bold" type="submit" name="resetPassword" value="รีเซ็ตรหัสผ่าน">Reset Password</button>
                        <div class="text-center text-muted mt-2">
                            <a href="../login/" class="text-md">Login</a><?php if (getConfig('allowRegister')) { ?>&nbsp;•&nbsp;<a href="../register/" class="text-md">Register</a><?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.querySelector("#resetForm").addEventListener("submit", function(event) {
            let captcha = document.querySelector('[name="cf-turnstile-response"]').value;
            if (captcha === "") { event.preventDefault(); swal("Oops","Please complete captcha!", "error"); }
        });
    </script>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>