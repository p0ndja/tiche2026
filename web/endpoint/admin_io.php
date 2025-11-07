<?php
    require_once '../static/function/connect.php';
    if (!isAdmin()) { home(); die(); }
    $URLPath = $_SERVER["HTTP_REFERER"];
    if (isset($_GET['method'])) {
        $method = $_GET['method'];
        $mode = $_GET['mode'];
        if ($method == "hotlink") {
            $topic = $_GET['topic'];
            $data = getDatatable($topic."Hotlink");
            $id = (int) $_GET['target'];
            if ($mode == "edit") {
                $icon = $_POST[$topic.'_icon'];
                $text = $_POST[$topic.'_title'];
                $link = $_POST[$topic.'_link'];
                if (empty($link)) $link = "#";
                
                if ($id == -1) //New item case
                    array_push($data, array("text"=> $text, "icon"=> $icon, "link"=> $link));
                else
                    $data[$id] = array("text"=> $text, "icon"=> $icon, "link"=> $link);

                if (setDatatable($topic."Hotlink",$data)) {
                    $_SESSION['SweetAlert'] = new SweetAlert("ปรับปรุงข้อมูลสำเร็จ");
                } else {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::UNEXPECTED_ERROR, SweetAlert::ERROR);
                }
                header("Location: " . $URLPath);
                die();
            } else if ($mode == "delete") {
                unset($data[$id]);
                if (setDatatable($topic."Hotlink",$data)) {
                    $_SESSION['SweetAlert'] = new SweetAlert("ปรับปรุงข้อมูลสำเร็จ");
                } else {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::UNEXPECTED_ERROR, SweetAlert::ERROR);
                }
                header("Location: " . $URLPath);
                die();
            }
        } else if ($mode == "save") {
            $locate_img ="../file/$method/";
            $current_file = (isset($_GET['name'])) ? $_GET['name'] : "";
            if (isset($_FILES['carousel_file']) && $_FILES['carousel_file']['name'] != "") { //Update Image case
                $name_file = $_FILES['carousel_file']['name'];
                $tmp_name = $_FILES['carousel_file']['tmp_name'];
                if (!file_exists($locate_img)) { make_directory($locate_img); }
                if (empty($current_file)) {
                    $file_count = count(glob("../file/$method/*.{JPG,jpg,JPEG,jpeg,PNG,png,GIF,gif}", GLOB_BRACE)) + 1;
                    $name_file = str_pad($file_count, 2, '0', STR_PAD_LEFT)."_".$name_file;
                } else {
                    unlink($locate_img.$current_file);
                    unlink($locate_img.$current_file.".txt");
                    $name_file = $_GET['id']."_".$name_file;
                }
                if (!move_uploaded_file($tmp_name,$locate_img.$name_file)) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                    header("Location: " . $URLPath);
                    die();
                }
                $current_file = $name_file;
            }
            $title = $_POST['cTitle'];
            if (!empty($title)) {
                $file = fopen("../file/$method/$current_file.txt","w");
                if (!fwrite($file,"$title")) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                    header("Location: " . $URLPath);
                    die();
                }
                fclose($file);
            } else {
                if (file_exists($locate_img.$current_file.".txt") && !unlink($locate_img.$current_file.".txt")) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                    header("Location: " . $URLPath);
                    die();
                }
            }
            $_SESSION['SweetAlert'] = new SweetAlert("ปรับปรุงข้อมูลสำเร็จ");
        } else if ($mode == "delete") {
            if (isset($_GET['target']) && file_exists("../file/$method/" . $_GET['target'])) {
                $pic = $_GET['target'];
                $picName = pathinfo($pic, PATHINFO_FILENAME);
                if (unlink("../file/$method/" . $pic)) {
                    $_SESSION['SweetAlert'] = new SweetAlert("ลบรูปภาพสำเร็จ", "รูปภาพ $picName ถูกลบออกจากระบบแล้ว");
                } else {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::FILE_IO, SweetAlert::ERROR);
                }
            }
        }
        if (isset($_GET['popup'])) {
            $URLPath = str_replace("popup=".$method, "popup=$method", $URLPath);
        } else {
            if (strpos($URLPath, "?") !== false) {
                $URLPath .= "popup=".$method;
            } else {
                $URLPath .= "?popup=".$method;
            }
        }
    }
    header("Location: " . $URLPath);
    die();
?>