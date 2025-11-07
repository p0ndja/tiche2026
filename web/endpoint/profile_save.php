<?php 
    require_once '../static/function/connect.php';
    if (isset($_POST['id']) && ((int) $_SESSION['currentActiveUser']->getID() == (int) $_POST['id'])) {
        $id = $_SESSION['currentActiveUser']->getID();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $real_email = $_POST['real_email']; 
        $finalProfile = $_POST['profile_final'];
        if ($stmt = $conn->prepare("UPDATE `user` set name = ?, email = ?, profilePic = ? WHERE id = ?")) {
            $stmt->bind_param('sssi', $name, $email, $finalProfile, $id);
            if (!$stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                print_r($conn->error);
                header("Location: ../profile/");
                die();
            }
        } else {
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
            echo "Can't establish database";
            header("Location: ../profile/");
            die();
        }
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $pass = md5($_POST['password']);
            if ($stmt = $conn->prepare("UPDATE `user` set password = ? WHERE id = ?")) {
                $stmt->bind_param('si', $pass, $id);
                if (!$stmt->execute()) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                    print_r($conn->error);
                    header("Location: ../profile/");
                    die();
                }
            } else {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
                echo "Can't establish database";
                header("Location: ../profile/");
                die();
            }
        }
        /*
        if(isset($_FILES['profile_upload']) && $_FILES['profile_upload']['name'] != ""){
            if ($_FILES['profile_upload']['name']) {
                if (!$_FILES['profile_upload']['error']) {
                    $name = "profile_" . generateRandom(8);
                    $ext = explode('.', $_FILES['profile_upload']['name']);
                    $filename = $name . '.' . $ext[1];
        
                    if (!file_exists('../file/profile/'. $id .'/')) {
                        mkdir('../file/profile/'. $id .'/');
                    }
        
                    $destination = '../file/profile/'. $id .'/' . $filename; //change this directory
                    $location = $_FILES["profile_upload"]["tmp_name"];
                    move_uploaded_file($location, $destination);
                    $finalFile = '../file/profile/'. $id .'/' . $filename;//change this URL
                    $r = mysqli_query($conn, "UPDATE `user` SET profilePic = '$finalFile' WHERE id = '$id'");
                    if (! $r) die("Could not set profile: " . mysqli_error($conn));
                }
            }
        }
        */
        $_SESSION['currentActiveUser']->setName($name);
        $_SESSION['currentActiveUser']->setProfile($finalProfile);
        $_SESSION['currentActiveUser']->setEmail($email);
        /*
        if ($real_email != $email) {
            header("Location: ../static/functions/verify/mail.php?key=$pass&email=$email&name=$fname&method=changeEmail");
        }
        */
        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ปรับปรุงข้อมูลสำเร็จ");
        header("Location: ../profile/");
    }
?>