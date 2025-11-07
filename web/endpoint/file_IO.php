<?php 
    require_once '../static/function/connect.php';

    if (isAdmin() && isset($_GET['function'])) {
        if ($_GET['function'] == "delete") {
            if (isset($_GET['name']) && isAdmin() && isset($_GET['method'])) {
                $file = $_GET['name'];
                if ($_GET['method'] == "file") {
                    unlink($file);
                    $file_name = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบไฟล์ $file_name เรียบร้อยแล้ว!");
                } else if ($_GET['method'] == "dir") {
                    if (remove_directory($file)) {
                        $path = pathinfo($file, PATHINFO_FILENAME);
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบโฟลเดอร์ $path เรียบร้อยแล้ว!");
                    } else {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, "พบไฟล์ในโฟลเดอร์ โปรดลบไฟล์ในโฟลเดอร์ก่อนแล้วจึงลบโฟลเดอร์นี้", SweetAlert::ERROR);
                    }
                }
            }
        } else if ($_GET['function'] == "create") {
            if (isset($_GET['mkdir'])) {
                $mkdir = $_GET['mkdir'];
                $path = $_GET['path'];
                $mkdir = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '', $mkdir);
                make_directory("$path/$mkdir");
            } else if (count($_FILES['attachment']['name'])) {
                $fileTotal = count($_FILES['attachment']['name']);
                if (is_uploaded_file($_FILES['attachment']['tmp_name'][0])) {
                    $path = $_POST['path'];
                    if (!file_exists("$path/")) {
                        make_directory("$path/");
                    }
                    $name_file = "";
                    for ($i = 0; $i < $fileTotal; $i++) {
                        if($_FILES['attachment']['tmp_name'][$i] != ""){
                            $name_file = $_FILES['attachment']['name'][$i];
                            $tmp_name = $_FILES['attachment']['tmp_name'][$i];
                            $locate_img = "$path/";
                            move_uploaded_file($tmp_name,$locate_img.$name_file);
                            rename($locate_img.$name_file, $locate_img.$name_file);
                        }
                    }
                    $_SESSION['SweetAlert'] = ($fileTotal == 1) ? new SweetAlert(PresetMessage::SUCCESS, "อัปโหลดไฟล์ $name_file เรียบร้อยแล้ว!") : new SweetAlert(PresetMessage::SUCCESS, "อัปโหลดไฟล์ $name_file และอีก " . ($fileTotal - 1) . " ไฟล์เรียบร้อยแล้ว!");
                }
            }
        } else if ($_GET['function'] == "rename") {
            if (isset($_GET['old']) && isset($_GET['new']) && file_exists($_GET['old'])) {
                if (file_exists($_GET['new'])) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_DUPLICATE, SweetAlert::ERROR);
                } else {                  
                    $path = $_GET['old'];
                    $dir = pathinfo($path, PATHINFO_DIRNAME);
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if (!empty($dir)) $dir .= "/";
                    if (!empty($ext)) $ext = ".$ext";

                    rename($_GET['old'], $dir . $_GET['new'] . $ext);
                }
            }
        }
    }

    back();
?>