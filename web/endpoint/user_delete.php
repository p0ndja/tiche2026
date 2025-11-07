<?php require_once '../static/function/connect.php';
    if ((isset($_GET['id']) && isAdmin()) || (isLogin() && (isset($_GET['id']) && (int) $_GET['id'] == (int) $_SESSION['currentActiveUser']->getID()))) {
        $id = (int) $_GET['id'];
        global $conn;
        if ($stmt = $conn->prepare("DELETE FROM `user` WHERE id = ?")) {
            $stmt->bind_param('i', $id);
            if (!$stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . "\n" . $conn->error, SweetAlert::ERROR);
                header("Location: ../user/$id");
                die();
            } else {
                remove_directory("../file/profile/$id");
                if (isAdmin()) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบบัญชีผู้ใช้ #$id แล้ว!", SweetAlert::SUCCESS);
                    header("Location: ../user/");
                } else {
                    header("Location: ../logout/");
                }
                die();
            }
        } else {
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . "\n" . $conn->error, SweetAlert::ERROR);
            header("Location: ../user/$id");
            die();
        }
    }
    header("Location: ../");
    die();
?>