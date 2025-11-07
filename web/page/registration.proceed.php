<?php
require_once '../static/function/connect.php';
if (isset($_GET['registration_id'])) {
    $registration_id = xss_clean($_GET['registration_id']);
    $registration = $conn->query("SELECT * FROM registration WHERE reg_id = $registration_id")->fetch_assoc();
    if ($registration) {
        $_SESSION['registration_id'] = $registration_id;
        header("Location: /registration/result");
        die();
    }
}
header("Location: /");
die();
?>