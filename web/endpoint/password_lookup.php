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
                $_SESSION['auth_error'] = "ไม่สามารถรีเซ็ตรหัสผ่านได้: พบการใช้อีเมลซ้ำมากกว่า 1 ผู้ใช้งาน โปรดติดต่อผู้ดูแลระบบ";
            } else if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $tempAuthKey = generateAuthKey($row['id']);
                    $var = array("key"=>$tempAuthKey, "email"=>$email, "name"=>$row['name']);
                    $sendMail = sendEmail($email, "สวัสดี " . $row['name'] . "! คุณได้ทำการส่งคำร้องขอรีเซ็ตรหัสผ่านเพื่อเข้าใช้งานเว็บไซต์ tiche2026.ubu.ac.th", "https://tiche2026.ubu.ac.th/static/function/mail/template/resetpassword.html", $var);
                    if ($sendMail) {
                        $_SESSION['SweetAlert'] = new SweetAlert("รีเซ็ตรหัสผ่านสำเร็จ", "กรุณาตรวจสอบที่อีเมลของท่านเพื่อดำเนินการต่อ", SweetAlert::SUCCESS);
                    } else {
                        $_SESSION['auth_error'] = "ไม่สามารถรีเซ็ตรหัสผ่านได้: ข้อผิดพลาดภายใน";
                    }
                }
            } else {
                $_SESSION['auth_error'] = "ไม่พบอีเมลนี้ในฐานข้อมูล";
            }
            $stmt->free_result();
            $stmt->close();
        }
    }
    header("Location: ../");
?>