<?php require_once '../static/function/connect.php';?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <?php if (isLogin() || !getConfig('allowRegister')) home(); ?>
        <div class="d-flex justify-content-center">
            <div class="container" id="container" style="padding-top: 20px; width: 23rem;">
                <h1 class="display-5 text-center text-md font-weight-bold">Register <i class="far fa-edit"></i></h1>
                <div class="card mb-3">
                    <form id="regForm" method="post" action="../static/function/auth/login.php" enctype="multipart/form-data" autocomplete="off">
                        <!--Body-->
                        <div class="card-body mb-1">
                            <?php if (isset($_SESSION['auth_error'])) { echo '<div class="alert alert-danger" role="alert">'.$_SESSION['auth_error'].'</div>'; $_SESSION['auth_error'] = null; } ?>
                            <div class="md-form form-sm mb-1">
                                <i class="fas fa-user prefix text-md"></i>
                                <input type="text" name="authRegForm_name" id="authRegForm_name" class="form-control form-control-sm validate" required>
                                <label for="authRegForm_name" class="text-md">Name</label>
                            </div>
                            <div class="md-form form-sm mb-1">
                                <i class="fas fa-envelope prefix text-md"></i>
                                <input type="email" name="authRegForm_email" id="authRegForm_email" class="form-control form-control-sm validate" required>
                                <label for="authRegForm_email" class="text-md">Email</label>
                            </div>
                            <div class="md-form form-sm mb-1">
                                <i class="fas fa-key prefix text-md"></i>
                                <input type="password" name="authRegForm_password" id="authRegForm_password" class="form-control form-control-sm" required>
                                <label for="authRegForm_password" class="text-md">Password</label>
                                <div class="text-center"><small class="text-danger" id="pwAlert"></small></div>
                            </div>
                            <div class="md-form form-sm mb-1">
                                <i class="fas fa-key prefix text-md"></i>
                                <input type="password" name="authRegForm_confirmpassword" id="authRegForm_confirmpassword" class="form-control form-control-sm" required>
                                <label for="authRegForm_confirmpassword" class="text-md">Confirm Password</label>
                                <div class="text-center"><small class="text-danger" id="cfpwAlert"></small></div>
                            </div>
                            <div class="cf-turnstile mb-4" data-theme="light" data-sitekey="0x4AAAAAABh0HRZB4iCc89in"></div>
                            <button class="btn btn-block btn-c-md font-weight-bold mt-3" type="submit" name="authRegForm_submit">Register</button>
                            <div class="text-center mt-2 text-muted"><a href="../forgetpassword/" class="text-danger">Forget Password</a>&nbsp;•&nbsp;<a href="../login/" class="text-md">Login</a></div>
                            <input type="hidden" name="referent" value="<?php echo (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null); ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require_once '../static/function/popup.php'; ?>
        <?php require_once '../static/function/script/footer.php'; ?>
        <script>
            document.querySelector("#regForm").addEventListener("submit", function(event) {
                let captcha = document.querySelector('[name="cf-turnstile-response"]').value;
                if (captcha === "") { event.preventDefault(); swal("Oops","Please complete captcha!", "error"); }
            });
        </script>
        <script>
            var pw = document.getElementById("authRegForm_password");
            var pwc = document.getElementById("authRegForm_confirmpassword");
            var pwAl = document.getElementById("pwAlert");
            var cfpwAl = document.getElementById("cfpwAlert");
            var validPassword = true;
            pw.addEventListener("change", passwordValidation);
            pwc.addEventListener("change", passwordValidation);

            function passwordValidation() {
                if (pw.value !== "") {
                    if (pw.value.length < 6) {
                        pwAl.innerHTML = "รหัสต้องมีความยาว 6 ตัวอักษรขึ้นไป";
                        pwinvalid();
                    } else {
                        pwvalidateclear();
                        pwAl.innerHTML = null;
                        if (pw.value != pwc.value) {
                            cfpwAl.innerHTML = "โปรดตรวจสอบความถูกต้อง";
                            pwinvalid();
                        } else {
                            cfpwAl.innerHTML = null;
                            pwvalid();
                        }
                    }
                } else {
                    cfpwAl.innerHTML = null;
                    pwvalidateclear();
                }
            }

            function pwinvalid() {
                pw.classList.add("invalid");
                pwc.classList.add("invalid");
                pw.classList.remove("valid");
                pwc.classList.remove("valid");
                validPassword = false;
            }

            function pwvalid() {
                pw.classList.add("valid");
                pwc.classList.add("valid");
                pw.classList.remove("invalid");
                pwc.classList.remove("invalid");
                validPassword = true;
            }

            function pwvalidateclear() {
                pw.classList.remove("valid");
                pwc.classList.remove("valid");
                pw.classList.remove("invalid");
                pwc.classList.remove("invalid");
                validPassword = false;
            }
            document.querySelector("#userEditForm").addEventListener("submit", function(event) {
                if (!validPassword) {
                    event.preventDefault();
                    swal("Oops","โปรดตรวจสอบรหัสผ่านที่กรอกอีกครั้ง", "error");
                }
            });
        </script>
    </body>
</html>