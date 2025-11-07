<?php 
    require_once '../static/function/function.php';
    if (isAdmin()) {
        $data = getDatatable("HRD");
        $target = $_GET['target'];
        $data[$target] = $_POST['HRDarticleEditor'];
        if (setDatatable("HRD", $data)) {
            $_SESSION['SweetAlert'] = new SweetAlert("ปรับปรุงข้อมูลสำเร็จ");
            back();
            die();
        } else {
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::UNEXPECTED_ERROR, SweetAlert::ERROR);
            back();
            die();
        }
    }
    back();
    die();
?>