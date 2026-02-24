<?php
include '../static/function/connect.php';

$response = array(
    "success" => false,
    "message" => ""
);

if (!isLogin() || !isset($_POST['registration_id']) || !isset($_POST['new_billing_info'])) {
    // header("Location: /registration/");
    $response['success'] = false;
    $response['message'] = "Invalid request.";
    print_r(json_encode($response));
    die();
}

$reg_id = xss_clean($_POST['registration_id']);
$reg_billingInfo = xss_clean($_POST['new_billing_info']);
$user_id = $_SESSION['currentActiveUser']->getId();

// check permission
$stmt = $conn->prepare("SELECT * FROM registration WHERE reg_id = ?");
$stmt->bind_param("s", $reg_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $response['success'] = false;
    $response['message'] = "Registration not found.";
    print_r(json_encode($response));
    die();
}
$row = $result->fetch_assoc();
$stmt->close();

if ($row['user_id'] != $user_id && !isAdmin()) {
    $response['success'] = false;
    $response['message'] = "You do not have permission to edit this registration.";
    print_r(json_encode($response));
    die();
}

$dateBetween = (strtotime($row['reg_timestamp']) + 60 * 60 * 24 * 14) - time();
// Hard deadline = 9 June 2026, 00:00:00 GMT+7
$hardDeadline = strtotime('2026-06-09 00:00:00') - time();
if ($hardDeadline < 0) {
    $dateBetween = -1;
}
if (!isAdmin() && ($dateBetween < 0 || $row['reg_payment_paid'])) {
    $response['success'] = false;
    $response['message'] = "You are not allowed to edit billing information for this registration.";
    print_r(json_encode($response));
    die();
}

$stmt = $conn->prepare("UPDATE registration SET reg_note = ?, reg_note_confirm = 1 WHERE reg_id = ?");
$stmt->bind_param("ss", $reg_billingInfo, $reg_id);
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Billing information updated successfully.";
} else {
    $response['success'] = false;
    $response['message'] = "Failed to update billing information.";
}
$stmt->close();
print_r(json_encode($response));
die();

?>