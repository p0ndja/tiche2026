<?php 
    require_once '../static/function/connect.php';
    require_once '../static/function/function.php';
    require_once '../static/function/mail/sender.php';

    global $conn;
    if (isset($_POST['reset'])) {
        $email = $_POST['reset'];
        if ($stmt = $conn->prepare("SELECT `id`,`name` FROM `user` WHERE email = ?")) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 1) {
                $_SESSION['auth_error'] = "Unexpected error: Multiple users found with the same email. Please contact support.";
            } else if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $tempAuthKey = generateAuthKey($row['id']);
                    $var = array("key"=>$tempAuthKey, "email"=>$email, "name"=>$row['name']);
                    $sendMail = sendEmail($email,  $row['name'] . ", Are you trying to reset password at tiche2026.ubu.ac.th?", "https://tiche2026.ubu.ac.th/static/function/mail/template/resetpassword.html", $var);
                    // $sendMail = sendEmail($email, "สวัสดี " . $row['name'] . "! คุณได้ทำการส่งคำร้องขอรีเซ็ตรหัสผ่านเพื่อเข้าใช้งานเว็บไซต์ tiche2026.ubu.ac.th", "https://tiche2026.ubu.ac.th/static/function/mail/template/resetpassword.html", $var);
                    if ($sendMail) {
                        $_SESSION['SweetAlert'] = new SweetAlert("Success", "Please follow the instructions in your email to reset your password.", SweetAlert::SUCCESS);
                    } else {
                        $_SESSION['auth_error'] = "Unexpected Error: Internal server error. Please try again later.";
                    }
                }
            } else {
                $_SESSION['auth_error'] = "No user found with the provided email address.";
            }
            $stmt->free_result();
            $stmt->close();
        }
    }
    header("Location: ../");
?>