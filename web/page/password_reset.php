<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <?php if (!isset($_SESSION['allowAccessResetpasswordPage']) || $_SESSION['allowAccessResetpasswordPage'] == false) back(); ?>
    <div class="container" id="container">
        <div class="center">
            <form id="resetForm" method="post" action="../endpoint/password_resetpass.php" enctype="multipart/form-data" autocomplete="off">
                <h1 class="display-5 font-weight-bold text-center text-md">Setting New Password <i class="fas fa-lock"></i></h1>
                <div class="card">
                    <!--Body-->
                    <div class="card-body mb-3">
                        <?php if (isset($_SESSION['auth_error'])) {echo '<div class="alert alert-danger" role="alert">'. $_SESSION['auth_error'] .'</div>'; $_SESSION['auth_error'] = null;} ?>
                        <div class="md-form form-sm mb-3">
                            <i class="fas fa-key prefix text-md"></i>
                            <input type="password" name="setNewPassword" id="setNewPassword" class="form-control form-control-sm validate" required>
                            <label for="setNewPassword" class="text-md">รหัสผ่านใหม่</label>
                        </div>
                        <div class="cf-turnstile mb-4" data-theme="light" data-sitekey="0x4AAAAAABh0HRZB4iCc89in"></div>
                        <button class="btn btn-md btn-c-md btn-block font-weight-bold" type="submit" name="resetPassword" value="รีเซ็ต">Set New Password</button>
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