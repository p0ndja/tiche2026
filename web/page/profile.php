<?php require_once '../static/function/connect.php'; ?>
<?php if (!isLogin()) header("Location: ../"); $id = $_SESSION['currentActiveUser']->getID(); ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <!-- Croppie -->
    <link rel="stylesheet" href="../static/library/Croppie-2.6.4/croppie.css">
    <script src="../static/library/Croppie-2.6.4/croppie.min.js" type="text/javascript"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <div class="container">
        <div class="card mb-3">
            <form method="post" action="../endpoint/profile_save.php" enctype="multipart/form-data" id="userEditForm" autocomplete="off">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <img class="img-fluid w-100" loading="lazy" src="<?php echo $_SESSION['currentActiveUser']->getProfile(); ?>" id="profile_preview">
                            <input type="file" name="profile_upload" id="profile_upload"
                                    class="form-control-file validate mt-1 mb-1" accept="image/png, image/jpeg, image/webp">
                            <input type="hidden" id="profile_final" name="profile_final" value="<?php echo $_SESSION['currentActiveUser']->getProfile(); ?>">
                            <button type="submit" class="btn btn-success btn-block btn-lg font-weight-bold text-dark">Update</button>
                        </div>
                        <div class="col-12 col-md-8">
                            <!-- Personal Zone -->
                            <h4 class="font-weight-bold">General Information <i
                                    class="fas fa-info-circle"></i></h4>
                            <hr>
                            <!-- name -->
                                <div class="md-form input-group mb-0 mt-0">
                                    <div class="input-group-prepend mb-0 mt-0">
                                        <span class="input-group-text md-addon font-weight-bold">Displayname</span>
                                    </div>
                                    <input type="text" class="form-control mr-sm-3" id="name"
                                        name="name"
                                        placeholder="<?php echo $_SESSION['currentActiveUser']->getName(); ?>"
                                        value="<?php echo $_SESSION['currentActiveUser']->getName(); ?>">
                                </div>
                            
                            <!-- name -->
                            <!-- Personal Zone -->

                            <!-- Security Zone -->
                            <h4 class="mt-5 font-weight-bold">Security <i class="fas fa-lock"></i>
                            </h4>
                            <hr>
                            <!-- Email -->
                            <div class="md-form input-group mt-0 mb-2">
                                <div class="input-group-prepend mt-0 mb-0">
                                    <span class="input-group-text md-addon font-weight-bold">Email</span>
                                </div>
                                <input type="hidden" id="real_email" name="real_email" value="<?php echo $_SESSION['currentActiveUser']->getEmail(); ?>">
                                <input type="text" class="form-control mr-sm-3" id="email" name="email"
                                    placeholder="<?php echo $_SESSION['currentActiveUser']->getEmail(); ?>"
                                    value="<?php echo $_SESSION['currentActiveUser']->getEmail(); ?>" required>
                            </div>
                            <!-- Email -->
                            <!-- Password -->
                            <div class="md-form input-group mt-0 mb-0">
                                <div class="input-group-prepend mb-0">
                                    <span class="input-group-text md-addon font-weight-bold">Change Password</span>
                                </div>
                            </div>
                            <div class="md-form input-group mb-0 mt-0">
                                <div class="input-group-prepend mb-0 mt-0">
                                    <span class="input-group-text md-addon mb-0 mt-0 ml-4">New Password</span>
                                </div>
                                <input type="password" class="form-control mr-sm-3" id="password" name="password" value="" autocomplete="off" list="autocompleteOff" disabled>
                            </div>
                            <div class="text-center"><small class="text-danger mt-0" id="pwAlert"></small></div>
                            <div class="md-form input-group mb-0 mt-0">
                                <div class="input-group-prepend mb-0 mt-0">
                                    <span class="input-group-text md-addon mb-0 mt-0">Confirm Password</span>
                                </div>
                                <input type="password" class="form-control mr-sm-3" id="newPassword" name="newPassword" value="" autocomplete="off" list="autocompleteOff" disabled>
                            </div>
                            <div class="text-center"><small class="text-danger mt-0" id="cfpwAlert"></small></div>
                            <!-- Password -->
                            <!-- Security Zone -->

                            <!-- Delete Zone -->
                            <h4 class="mt-5 font-weight-bold">Account Deactivation <i
                                    class="fas fa-trash-alt"></i>
                            </h4>
                            <hr>

                            <a class="btn btn-danger btn-lg" href="javascript:{}"
                                onclick='swal({title: "Deactivate this account ?",text: "This cannot be undone.",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/user_delete.php?id=<?php echo $id; ?>";}});''>Deactivate your account</a>
                            <!-- Delete Zone -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="uploadimageModal" class="modal" role="dialog">
        <div class="modal-dialog modal-notify modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload & Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            <div id="image_demo" style="width:100%; margin-top:30px"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success crop_image">Crop & Upload Image</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
    <script>
        var pw = document.getElementById("password");
        var pwc = document.getElementById("newPassword");
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
            validPassword = true;
        }
        document.querySelector("#userEditForm").addEventListener("submit", function(event) {
            if (!validPassword) {
                event.preventDefault();
                swal("Oops","โปรดตรวจสอบรหัสผ่านที่กรอกอีกครั้ง", "error");
            }
        });

        document.addEventListener("DOMContentLoaded", function(event) { 
            setTimeout(function() {
                pw.removeAttribute("disabled");
                pwc.removeAttribute("disabled");
            }, 400);
        });

    </script>
    <script>

        $(document).ready(function () {
            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 325,
                    height: 325,
                    type: 'circle' //circle
                },
                boundary: {
                    width: 333,
                    height: 333
                }
            });

            $('#profile_upload').on('change', function () {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function (event) {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (response) {
                    $.ajax({
                        url: "../endpoint/profile_upload.php",
                        type: "POST",
                        data: {
                            "userID": <?php echo $id; ?>,
                            "image": response
                        },
                        success: function (data) {
                            $('#uploadimageModal').modal('hide');
                            $('#profile_preview').attr('src',data.trim());
                            $('#profile_final').val(data.trim());
                            console.log($('#profile_final').val());
                        }
                    });
                })
            });

        });
        $("input[type=radio]").change(function () {
            if (this.id == "student") {
                $('#studentZone').css('display', 'block');
            } else {
                $('#studentZone').css('display', 'none');
            }
        });

    </script>
</body>

</html>