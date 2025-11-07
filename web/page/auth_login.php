<?php require_once '../static/function/connect.php';?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <?php if (isLogin()) home(); ?>
        <?php $captcha = false; if (isset($_SESSION['auth_attempt']) && (int) $_SESSION['auth_attempt'] >= 3) { $captcha = true; } ?>
        <div class="d-flex justify-content-center">
            <div class="container" id="container" style="padding-top: 20px; padding-bottom: 100px; width: 23rem;">
                <form id="loginForm" method="post" action="../static/function/auth/login.php" enctype="multipart/form-data">
                <h1 class="display-5 text-center font-weight-bold text-md">Login <i class="fas fa-sign-in-alt"></i></h1>
                    <div class="card">
                        <!--Body-->
                        <div class="card-body mb-1">
                            <?php if (isset($_SESSION['auth_error'])) {echo '<div class="alert alert-danger" role="alert">'. $_SESSION['auth_error'] .'</div>'; unset($_SESSION['auth_error']);} ?>
                            <div class="md-form form-sm mb-4">
                                <i class="fas fa-user prefix text-md"></i>
                                <input type="text" name="authLoginForm_username" id="authLoginForm_username"
                                    class="form-control form-control-sm validate" required>
                                <label for="authLoginForm_username" class="text-md">Email</label>
                            </div>
                            <div class="md-form form-sm mb-4">
                                <i class="fas fa-lock prefix text-md"></i>
                                <input type="password" name="authLoginForm_password" id="authLoginForm_password"
                                    class="form-control form-control-sm validate" required>
                                <label for="authLoginForm_password" class="text-md">Password</label>
                            </div>
                            <div class="cf-turnstile mb-4" data-theme="light" data-sitekey="0x4AAAAAABh0HRZB4iCc89in"></div>
                            <button class="btn btn-block btn-c-md font-weight-bold" type="submit" name="authLoginFormHandshake">Login</button>
                            <div class="text-center mt-2 text-muted">
                                <a href="../forgetpassword/" class="text-danger">Forget Password</a><?php if (getConfig('allowRegister')) { ?>&nbsp;•&nbsp;<a href="../register/" class="text-md">Register</a><?php } ?>
                            </div>
                            <input type="hidden" name="referent" value="<?php echo (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null); ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.querySelector("#loginForm").addEventListener("submit", function(event) {
                let captcha = document.querySelector('[name="cf-turnstile-response"]').value;
                if (captcha === "") { event.preventDefault(); swal("Oops","Please complete captcha!", "error"); }
            });
        </script>
        <?php require_once '../static/function/popup.php'; ?>
        <?php require_once '../static/function/script/footer.php'; ?>
    </body>
</html>