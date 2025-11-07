<?php
require_once '../connect.php';
require_once '../function.php';

if (isset($_POST['authLoginFormHandshake']) && isset($_POST['authLoginForm_username']) && isset($_POST['authLoginForm_password'])) {
    $credential = login($_POST['authLoginForm_username'], md5($_POST['authLoginForm_password']));
    if (!empty($credential)) {
        unset($_SESSION['auth_error']);
        unset($_SESSION['auth_attempt']);
        $_SESSION['currentActiveUser'] = $credential;
        $_SESSION['SweetAlert'] = new SweetAlert("เข้าสู่ระบบสำเร็จ", "ยินดีต้อนรับ! " . $credential->getName(), SweetAlert::SUCCESS);
        
        if (isset($_POST['referent'])) {
            header("Location: ". $_POST['referent']);
        } else {
            header("Location: ../../../");
        }

    } else {
        $_SESSION['auth_attempt'] = (isset($_SESSION['auth_attempt']) ? $_SESSION['auth_attempt']++ : 1);
        $_SESSION['auth_error'] = PresetMessage::AUTH_WRONG;
        header("Location: ../../../login/");
    }
}

if (isset($_POST['authRegForm_submit'])) {
    $pass = md5($_POST['authRegForm_password']);
    $name = $_POST['authRegForm_name'];
    $email = $_POST['authRegForm_email'];
    $role = "guest";

    $id = latestIncrement($db["table"], 'user');

    if ($stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ?")) {
        $stmt->bind_param('s', $email);
        if (!$stmt->execute()) {
            $_SESSION['auth_error'] = "พบข้อผิดพลาด: " . PresetMessage::DATABASE_QUERY . "\n" . $conn->error;
            print_r($conn->error);
            header("Location: ../../../register/");
            die();
        } else {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $_SESSION['auth_error'] = "อีเมลนี้ถูกใช้งานไปแล้ว";
                header("Location: ../../../register/");
                die();
            }
        }
    } else {
        $_SESSION['auth_error'] = "พบข้อผิดพลาด: " . PresetMessage::DATABASE_ESTABLISH . " : " . $conn->error;
        echo "Can't establish database";
        header("Location: ../../../register/");
        die();
    }

    if ($stmt = $conn->prepare("INSERT INTO `user` (password, name, email, role) VALUES (?,?,?,?)")) {
        $stmt->bind_param('ssss',$pass,$name,$email,$role);
        if (!$stmt->execute()) {
            $_SESSION['auth_error'] = "พบข้อผิดพลาด: " . PresetMessage::DATABASE_QUERY . "\n" . $conn->error;
            print_r($conn->error);
            header("Location: ../../../register/");
            die();
        } else {
            unset($_SESSION['auth_error']);
            unset($_SESSION['auth_attempt']);
            $credential = new User((int) $id);
            $_SESSION['SweetAlert'] = new SweetAlert("สมัครบัญชีผู้ใช้งานสำเร็จ!", "ยินดีต้อนรับ! " . $credential->getName());
            $_SESSION['currentActiveUser'] = $credential;
            header("Location: ../../../");
            //header("Location: ../verify/mail.php?key=" . $pass . "&email=" . $email . "&name=" . $_SESSION['name']->getName() . "&method=reg");
        }
    } else {
        $_SESSION['auth_error'] = "พบข้อผิดพลาด: " . PresetMessage::DATABASE_ESTABLISH . " : " . $conn->error;
        echo "Can't establish database";
        header("Location: ../../../register/");
        die();
    }
}

if (isset($_GET['user']) && isset($_GET['pass'])) {
    $user = $_GET['user'];
    $pass = md5($_GET['pass']);

    //Use login(username, password) function from function.php
    $credential = login($user, $pass);
    if (!empty($credential)) {
        $_SESSION['currentActiveUser'] = $credential;
        $_SESSION['SweetAlert'] = new SweetAlert("เข้าสู่ระบบสำเร็จ", "ยินดีต้อนรับ! " . $credential->getName(), SweetAlert::SUCCESS);
        
        if (isset($_GET['method'])) {
            if ($_GET['method'] == "reset") {
                $_SESSION['allowAccessResetpasswordPage'] = true;
                header("Location: ../../../resetpassword/");
            }
            else header("Location: ../../../");
        } else {
            echo "Accept";
        }
    } else {
        $_SESSION['auth_error'] = PresetMessage::AUTH_WRONG;
    }
}
?>