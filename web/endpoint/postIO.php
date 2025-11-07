<?php
    require_once '../static/function/connect.php';
    if (isset($_GET['id']) && isAdmin() && isset($_GET['method'])) {
        $id = (int) $_GET['id'];
        $method = $_GET['method'];
        $post = new Post($id);
        if ($method == "delete") {
            if ($post->getProperty('allowDelete') == true) {
                if ($stmt = $conn->prepare("DELETE FROM `post` WHERE id = ?")) {
                    $stmt->bind_param('i', $id);
                    if (!$stmt->execute()) {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                    } else {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบโพสต์ข่าว #$id แล้ว!");
                    }
                } else {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
                }
            } else {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, "ไม่สามารถลบโพสต์ข่าว #$id ได้! เนื่องจากเป็นโพสต์ในรายการห้ามลบ", SweetAlert::ERROR);
            }
            header("Location: ../post/");
            die();
        } else if ($method == "toggle" && isset($_GET['target'])) {
            $target = $_GET['target'];        
            if ($target == "hide") {
                $post->setProperty('hide', !($post->getProperty('hide')));
            } else if ($target == "pin") {
                $post->setProperty('pin', !($post->getProperty('pin')));
            }
            $property = json_encode($post->properties());
            if ($stmt = $conn -> prepare("UPDATE `post` SET property=? WHERE id=?")) {
                $stmt->bind_param('si', $property,$id);
                if (!$stmt->execute()) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                } else {
                    if ($target == "hide") {
                        $_SESSION['SweetAlert'] = ($post->getProperty('hide')) ? new SweetAlert(PresetMessage::SUCCESS, "ซ่อนโพสต์ #$id แล้ว!") : new SweetAlert(PresetMessage::SUCCESS, "แสดงโพสต์ #$id แล้ว!");
                    } else if ($target == "pin") {
                        $_SESSION['SweetAlert'] = ($post->getProperty('pin')) ? new SweetAlert(PresetMessage::SUCCESS, "ปักหมุดโพสต์ #$id แล้ว!") : new SweetAlert(PresetMessage::SUCCESS, "ยกเลิกปักหมุดโพสต์ #$id แล้ว!");
                    } else {
                        $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS);
                    }
                }
            } else {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
            }
            back();
            die();
        }
    }
    home();
    die();
?>