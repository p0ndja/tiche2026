<?php
require_once '../static/function/connect.php';
require_once '../api/payment/encrypt.php';
require_once '../static/function/mail/sender.php';
if (!isset($_SESSION['registration_id']) && !isset($_GET['registration_id'])) {
    header("Location: /registration/");
    die();
}
$id = (isset($_GET['registration_id'])) ? xss_clean($_GET['registration_id']) : $_SESSION['registration_id'];

$stmt = $conn->prepare("SELECT * FROM registration WHERE reg_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: /registration/");
    die();
}
$row = $result->fetch_assoc();
$price = $row['reg_payment_amount'];
$name = $row['reg_fullName'];

$paid = false;
$earlybird = ($price == 3000 || $price == 5000 || $price == 1) ? true : false;
if ($row['reg_payment_paid'] == 1)
    $paid = true;
else if (checkStatus(sprintf("%06d", $id)) == true) {
    $stmt = $conn->prepare("UPDATE registration SET reg_payment_paid = 1, reg_payment_timestamp = CURRENT_TIMESTAMP() WHERE reg_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    sendEmail(
        $row['reg_email'],
        "TIChE 2025 Registration Confirmation - $name",
        "https://tiche2026.ubu.ac.th/static/function/mail/template/registration_success.html",
        array("name"=>$name, "date"=>date("Y-m-d H:i:s", time()), "id"=>sprintf("%06d", $id)));
    $paid = true;
    header("Location: /registration/result");
    die();
}

//check if they reach this page within time? (1 April 2025, 23:59:59)
if ($earlybird && (strtotime(date("Y-m-d H:i:s")) > strtotime("2025-04-02 00:00:05"))) {
    if ($price == 3000)
        $price = 3500;
    else if ($price == 5000)
        $price = 5500;
    else if ($price == 1)
        $price = 500;
    $stmt = $conn->prepare("UPDATE registration SET reg_payment_amount = ? WHERE reg_id = ?");
    $stmt->bind_param("ss", $price, $id);
    $stmt->execute();
}
$stmt->close();

header("Location: " . sendUser($id, $price));
die();

?>