<?php require_once '../static/function/connect.php'; ?>
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
    <?php needAdmin(); ?>
    <div class="container">
        <div class="card mb-3 card-body">
            <select class="mdb-select" searchable="กรุณาใส่ข้อมูล..." id="user_query" name="user_query">
                <option value="" disabled selected>กรุณาเลือก</option>
                <?php
                    if ($stmt = $conn->prepare("SELECT `id`,`name`,`profilePic` FROM `user`")) {
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id']; ?>" data-icon="<?php echo (empty($row['profilePic']) ? "../static/asset/user.svg" : $row['profilePic']); ?>" class="rounded-circle">
                                    <?php echo $row['name'].'#'.$row['id']; ?>
                                </option>
                            <?php }
                        }
                    } 
                ?>
            </select>
        </div>
        <?php
        if (isset($_GET['id'])) { 
            $id = (int) $_GET['id'];
            $user = new User($id);
            if ($user->getID() == -1) header("Location: ../user/");
        ?>
        <div class="card mb-3">
            <form method="post" action="../endpoint/admin_user_save.php?id=<?php echo $id; ?>" enctype="multipart/form-data" id="userEditForm" autocomplete="off">
                <input type="hidden" id="real_id" name="real_id" value="<?php echo $id; ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <img class="img-fluid w-100" loading="lazy" src="<?php echo $user->getProfile(); ?>" id="profile">
                            <input type="file" name="profile_upload" id="profile_upload" class="form-control-file validate mt-1 mb-1" accept="image/png, image/jpeg, image/webp">
                            <h1 class="display-4 text-center">ID: <?php echo $id; ?></h1>
                            <a class="btn btn-success btn-block btn-lg" href="javascript:{}" onclick="document.getElementById('userEditForm').submit();">บันทึกข้อมูล <i class="fas fa-save"></i></a>
                        </div>
                        <div class="col-12 col-md-8">
                            <!-- Personal Zone -->
                            <h4 class="font-weight-bold">ข้อมูลส่วนตัว - Information <i class="fas fa-info-circle"></i></h4>
                            <hr>
                            <!-- name -->
                            <div class="form-inline">
                                <div class="md-form input-group mt-0">
                                    <div class="input-group-prepend"><span class="input-group-text md-addon font-weight-bold">ชื่อ</span></div>
                                    <input type="text" class="form-control mr-sm-3" id="name" name="name" placeholder="<?php echo $user->getName(); ?>" value="<?php echo $user->getName(); ?>">
                                </div>
                            </div>
                            <!-- name -->
                            <!-- Personal Zone -->

                            <!-- Security Zone -->
                            <h4 class="mt-3 font-weight-bold">ความปลอดภัย - Security <i class="fas fa-lock"></i></h4>
                            <hr>
                            <!-- Email -->
                            <div class="md-form input-group mt-0">
                                <div class="input-group-prepend"><span class="input-group-text md-addon font-weight-bold">อีเมล</span></div>
                                <input type="text" class="form-control mr-sm-3" id="email" name="email" placeholder="<?php echo $user->getEmail(); ?>" value="<?php echo $user->getEmail(); ?>" required>
                            </div>
                            <!-- Email -->

                            <!-- Password -->
                            <div class="md-form input-group mt-0 mb-0">
                                <div class="input-group-prepend mb-0">
                                    <span class="input-group-text md-addon font-weight-bold">เปลี่ยนรหัสผ่าน</span>
                                </div>
                            </div>
                            <div class="md-form input-group mb-0 mt-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon ml-5 mb-0 mt-0">รหัสผ่านใหม่</span>
                                </div>
                                <input type="password" class="form-control mr-sm-3 mb-0 mt-0" id="password" name="password" value="" autocomplete="off" list="autocompleteOff" disabled>
                            </div>
                            <div class="text-center"><small class="text-danger mt-0" id="pwAlert"></small></div>
                            <div class="md-form input-group mb-0 mt-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon mb-0 mt-0">รหัสผ่านใหม่อีกครั้ง</span>
                                </div>
                                <input type="password" class="form-control mr-sm-3 mb-0 mt-0" id="newPassword" name="newPassword" value="" autocomplete="off" list="autocompleteOff" disabled>
                            </div>
                            <div class="text-center"><small class="text-danger mt-0" id="cfpwAlert"></small></div>
                            <!-- Password -->
                            <!-- Security Zone -->

                            <!-- Status Zone -->
                            <!-- role -->
                            <!-- Group of material radios - option 1 -->
                            <h4 class="mt-5 font-weight-bold">สถานะ - Role <i class="fas fa-user-tag"></i></h4>
                            <hr>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="admin" name="role"
                                    <?php if ($user->isAdmin()) echo "checked"; ?> value="admin">
                                <label class="form-check-label" for="admin">แอดมิน
                                    <a class="material-tooltip-main" data-html="true" data-toggle="tooltip"
                                        title="✔ เข้าถึงเมนูจัดการของแอดมิน<br>✔ แก้ไขโพสต์"><i
                                            class="fas fa-info-circle"></i></a>
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="guest" name="role"
                                    <?php if (!$user->isAdmin()) echo "checked"; ?> value="guest">
                                <label class="form-check-label" for="guest">ผู้เยี่ยมชม
                                    <a class="material-tooltip-main" data-html="true" data-toggle="tooltip"
                                        title="❌ เข้าถึงเมนูจัดการของแอดมิน<br>❌ แก้ไขโพสต์"><i
                                            class="fas fa-info-circle"></i></a>
                                </label>
                            </div>
                            <!-- role -->
                            <!-- Status Zone -->

                            <!-- Delete Zone -->
                            <h4 class="mt-5 font-weight-bold">ลบแอคเค้าท์ - Delete Account <i
                                    class="fas fa-trash-alt"></i>
                            </h4>
                            <hr>

                            <a class="btn btn-outline-danger btn-lg" href="javascript:{}"
                                onclick='swal({title: "ลบผู้ใช้นี้หรือไม่ ?",text: "การกระทำดังกล่าวจะไม่สามารถกู้คืนหรือย้อนกลับได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/user_delete.php?id=<?php echo $id; ?>";}});''>ยืนยันการลบผู้ใช้นี้ <u><b>!! ไม่สามารถกู้คืนได้ !!</b></u></a>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
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
        $("#user_query").on('change', function (e) { window.location = "../user/" + $("#user_query").val(); });
        $('#user_query <?php if (isset($_GET['id']))echo "option[value=" . $_GET['id'] .']'; ?>').attr('selected', 'selected');
        document.getElementById("profile_upload").onchange = function () {
            var reader = new FileReader();
            reader.onload = function (e) { document.getElementById("profile").src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        };
    </script>
</body>
</html>
