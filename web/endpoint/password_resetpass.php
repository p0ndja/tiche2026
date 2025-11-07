<?php 
    require_once '../static/function/connect.php';
    require_once '../static/function/function.php';
    if (isset($_POST['setNewPassword']) && isLogin() && isset($_SESSION['allowAccessResetpasswordPage']) && $_SESSION['allowAccessResetpasswordPage'] == true) {
        $password = $_POST['setNewPassword'];
        $md5_pass = md5($password);
        $id = $_SESSION['currentActiveUser']->getID();
        if ($stmt = $conn->prepare("UPDATE `user` SET `password` = ? WHERE id = ?")) {
            $stmt->bind_param('si', $md5_pass, $id);
            if ($stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "เปลี่ยนรหัสผ่านสำเร็จ");
                unset($_SESSION['allowAccessResetpasswordPage']);
                header("Location: ../");
                die();
            } 
        } else {
            $_SESSION['auth_error'] = PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error;
            header("Location: ../resetpassword/");
        }
    } else {
        header("Location: ../");
    }
?>