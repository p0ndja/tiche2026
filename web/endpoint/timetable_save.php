<?php
    require_once '../static/function/connect.php';
    if (isAdmin()) {
        $title = $_POST['articleTitle'];
        $data = $_POST['articleEditor'];
        $category = $_GET['category'];
        $id = (int) $_GET['id'];
        if ($stmt = $conn->prepare("UPDATE `timetable` set `title` = ?, `data` = ? WHERE id = ?")) {
            $stmt->bind_param('ssi', $title, $data, $id);
            if (!$stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                back();
                die();
            }
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "อัปเดตข้อมูล $title เรียบร้อยแล้ว!");
        }
    }
    header("Location: " . str_replace("-edit","",$_SERVER["HTTP_REFERER"]));
    die();
?>