<?php 
    require_once '../static/function/connect.php';

    if (isset($_POST['real_id']) && isAdmin()) {
        $id = $_POST['real_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        if ($stmt = $conn->prepare("UPDATE `user` set name = ?, email = ?, role = ? WHERE id = ?")) {
            $stmt->bind_param('sssi', $name, $email, $role, $id);
            if (!$stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                header("Location: ../user/$id");
                die();
            }
        } else {
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
            header("Location: ../user/$id");
            die();
        }

        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $pass = md5($_POST['password']);
            if ($stmt = $conn->prepare("UPDATE `user` set password = ? WHERE id = ?")) {
                $stmt->bind_param('si', $pass, $id);
                if (!$stmt->execute()) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                    print_r($conn->error);
                    header("Location: ../user/$id");
                    die();
                }
            } else {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
                echo "Can't establish database";
                header("Location: ../user/$id");
                die();
            }
        }

        $finalFile = "";
        if(isset($_FILES['profile_upload']) && $_FILES['profile_upload']['name'] != ""){
            if ($_FILES['profile_upload']['name']) {
                if (!$_FILES['profile_upload']['error']) {
                    $name = "profile_" . generateRandom(8);
                    $ext = explode('.', $_FILES['profile_upload']['name']);
                    $filename = $name . '.' . $ext[1];
        
                    if (!file_exists('../file/profile/'. $id .'/')) {
                        make_directory('../file/profile/'. $id .'/');
                    }
        
                    $destination = '../file/profile/'. $id .'/' . $filename; //change this directory
                    $location = $_FILES["profile_upload"]["tmp_name"];
                    move_uploaded_file($location, $destination);
                    $finalFile = '../file/profile/'. $id .'/' . $filename;//change this URL

                    if ($stmt = $conn->prepare("UPDATE `user` set profilePic = ? WHERE id = ?")) {
                        $stmt->bind_param('si', $finalFile, $id);
                        if (!$stmt->execute()) {
                            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                            print_r($conn->error);
                            header("Location: ../user/$id");
                            die();
                        }
                    } else {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
                        echo "Can't establish database";
                        header("Location: ../user/$id");
                        die();
                    }
                }
            }
        }
        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "บันทึกข้อมูลของบัญชีผู้ใช้ $name#$id แล้ว!", SweetAlert::SUCCESS);
        header("Location: ../user/$id");
        die();
    }
?>