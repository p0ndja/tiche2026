<?php
    require_once '../static/function/connect.php';
    if (isAdmin() && isset($_GET['function'])) {
        $topPath = "../file/people/";
        if ($_GET['function'] == "create") {
            $category = $_GET['category'];
            $title = $_GET['title'];
            $id = latestIncrement($db["table"], 'timetable'); 
            if ($stmt = $conn->prepare("INSERT INTO `timetable` (`category`,`title`) VALUES (?,?)")) {
                $stmt->bind_param('ss', $category, $title);
                if (!$stmt->execute()) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                    back();
                    die();
                }
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "เพิ่มหัวข้อ $title เรียบร้อยแล้ว!");
                if ($category == "IPD" || $category == "OPD")
                    header("Location: ../timetable/$category-$id-edit");
                else if ($category == "FAQ")
                    header("Location: ../FAQ/$id-edit");
                else if ($category == "PG")
                    header("Location: ../patient-guideline/$id-edit");
                else
                    home();
                die();
            }
        } else if ($_GET['function'] == "delete") {
            $id = (int) $_GET['id'];
            if ($stmt = $conn->prepare("DELETE FROM `timetable` WHERE id = ?")) {
                $stmt->bind_param('i', $id);
                if (!$stmt->execute()) {
                    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                    back();
                    die();
                }
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "ลบข้อมูล $title เรียบร้อยแล้ว!");
            }
        }
    }
    back();
?>