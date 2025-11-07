<?php
    require_once '../static/function/connect.php';
    if (isAdmin() && isset($_GET['function'])) {
        $topPath = "../file/people/";
        if ($_GET['function'] == "create") {
            if (isset($_GET['mkdir'])) {
                if (isset($_GET['top'])) $topPath .= $_GET['top']."/";
                $name = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '', $_GET['mkdir']);
                $targetPath = $topPath.$name;
                make_directory($targetPath);
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "เพิ่มหมวดหมู่ $name เรียบร้อยแล้ว!");
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: ".$_SERVER['HTTP_REFERER']."#$name");
                    die();
                }
            } else if (isset($_FILES['img']) && $_FILES['img']['name'] != "") {
                if (is_uploaded_file($_FILES['img']['tmp_name'])) {
                    $path = $_POST['path'];
                    if (!file_exists("$path/")) {
                        make_directory("$path/");
                    }
                    $name_file = "";
                    if($_FILES['img']['tmp_name'] != ""){
                        $file_count = count(glob("$path/*.{jpg,png,gif,PNG,JPG,GIF,JPEG,jpeg}", GLOB_BRACE)) + 1;
                        $name_file = str_pad($file_count, 4, '0', STR_PAD_LEFT)."_".$_FILES['img']['name'];
                        $tmp_name = $_FILES['img']['tmp_name'];
                        $locate_img = "$path/";
                        while (file_exists($locate_img.$name_file)) {
                            $name_file = pathinfo($name_file, PATHINFO_FILENAME) . "_" . generateRandom(5) . "." . pathinfo($name_file, PATHINFO_EXTENSION);
                        }
                        move_uploaded_file($tmp_name,$locate_img.$name_file);
                        rename($locate_img.$name_file, $locate_img.$name_file);
                        $title = $_POST['name'];
                        $description = isset($_POST['description']) && !empty($_POST['description']) ? $_POST['description'] : "";
                        $file = fopen("$path/$name_file.txt","w");
                        if (!fwrite($file,"$title\n$description")) {
                            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                        } else {
                            fclose($file);
                            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "เพิ่ม $title เรียบร้อยแล้ว!");    
                            if (isset($_SERVER['HTTP_REFERER']) && isset($_POST['pathFolder'])) {
                                header("Location: ".$_SERVER['HTTP_REFERER']."#".$_POST['pathFolder']);
                                die();
                            }
                        }
                    }
                }
            }
        } else if ($_GET['function'] == "rename") {
            if (isset($_GET['old']) && isset($_GET['new']) && file_exists($_GET['old'])) {
                if (file_exists($_GET['new'])) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_DUPLICATE);
                } else {                  
                    $path = $_GET['old'];
                    $dir = pathinfo($path, PATHINFO_DIRNAME);
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if (!empty($dir)) $dir .= "/";
                    if (!empty($ext)) $ext = ".$ext";
                    if (rename($_GET['old'], $dir . $_GET['new'] . $ext)) {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "เปลี่ยนแปลงชื่อหมวดหมู่เป็น ".$_GET['new']." เรียบร้อยแล้ว!");  
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("Location: ".$_SERVER['HTTP_REFERER']."#".$_GET['new']);
                            die();
                        }
                    }
                }
            }
        } else if ($_GET['function'] == "delete") {
            if (isset($_GET['name']) && isset($_GET['method'])) {
                $file = $_GET['name'];
                if ($_GET['method'] == "file") {
                    unlink($file);
                    unlink($file.".txt");
                    $file_name = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบ $file_name เรียบร้อยแล้ว!");
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: ".$_SERVER['HTTP_REFERER']."#".str_replace("../file/people/doctor/", "", pathinfo($file, PATHINFO_DIRNAME)));
                        die();
                    }
                } else if ($_GET['method'] == "dir") {
                    if (remove_directory($file)) {
                        $path = pathinfo($file, PATHINFO_FILENAME);
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบหมวดหมู่ $path เรียบร้อยแล้ว!");
                    } else {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, "พบข้อมูลหลงเหลือในหมวดหมู่ โปรดลบข้อมูลภายในหมวดหมู่ที่เหลืออยู่ก่อนแล้วจึงลบหมวดหมู่นี้", SweetAlert::ERROR);
                    }
                }
            }
        } else if ($_GET['function'] == "update") {
            if (isset($_GET['id'])) {
                $index = $_GET['index'];
                $id = $_GET['id'];
                $old_file_name = $_GET['target'];
                $title = $_POST["name_$id"];
                $description = $_POST["description_$id"];
                if (isset($_FILES["img_$id"]) && $_FILES["img_$id"]['name'] != "") {
                    if (is_uploaded_file($_FILES["img_$id"]['tmp_name'])) {
                        $path = $_POST['path'];
                        if (!file_exists("$path/")) {
                            make_directory("$path/");
                        }
                        $name_file = "";
                        if($_FILES["img_$id"]['tmp_name'] != ""){
                            $name_file = str_pad($index, 4, '0', STR_PAD_LEFT)."_".$_FILES["img_$id"]['name'];
                            $tmp_name = $_FILES["img_$id"]['tmp_name'];
                            $locate_img = "$path/";
                            while (file_exists($locate_img.$name_file)) {
                                $name_file = pathinfo($name_file, PATHINFO_FILENAME) . "_" . generateRandom(5) . "." . pathinfo($name_file, PATHINFO_EXTENSION);
                            }
                            move_uploaded_file($tmp_name,$locate_img.$name_file);
                            rename($locate_img.$name_file, $locate_img.$name_file);
                            if ($old_file_name != $name_file) {
                                unlink("$old_file_name");
                                unlink("$old_file_name.txt");
                            }
                            $file = fopen("$path/$name_file.txt","w");
                            if (!fwrite($file,"$title\n$description")) {
                                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                                back();
                                die();
                            } else {
                                fclose($file);
                            }
                        }
                    }
                } else {
                    $file = fopen("$old_file_name.txt","w");
                    if (!fwrite($file,"$title\n$description")) {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                        back();
                        die();
                    } else {
                        fclose($file);
                    }
                }
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "อัปเดตข้อมูลของ $title เรียบร้อยแล้ว!");
                if (isset($_SERVER['HTTP_REFERER']) && isset($_POST['pathFolder'])) {
                    header("Location: ".$_SERVER['HTTP_REFERER']."#".$_POST['pathFolder']);
                    die();
                }
            }
        } else if ($_GET['function'] == "link") {
            $folder = $_GET['folder'];
            $link = $_GET['link'];
            $file = fopen("$folder/link.txt","w");
            if (!fwrite($file,"$link")) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO.": $folder/link.txt");
                back();
                die();
            } else {
                fclose($file);
            }
            $_SESSION['SweetAlert'] = new SweetAlert("อัปเดตข้อมูลสำเร็จ");
            back();
            die();
        }
    }
    back();
?>