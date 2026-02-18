<?php
require_once '../static/function/connect.php';
require_once '../api/payment/encrypt.php';
require_once '../static/function/mail/sender.php';
needLogin();
if (!isset($_SESSION['registration_id']) && !isset($_GET['registration_id'])) {
    header("Location: /registration/");
    die();
}
$isClose = getDatatable("closeRegistration")["value"];
if ($isClose) {
    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, 'Registration is now closed', SweetAlert::ERROR);
    header("Location: /");
    die();
}

$id = (isset($_GET['registration_id'])) ? xss_clean($_GET['registration_id']) : $_SESSION['registration_id'];
$format_id = sprintf("%06d", $id);
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
$user_id = $row['user_id'];
if ($user_id != $_SESSION['currentActiveUser']->getId()) {
    header("Location: /");
    $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, 'You are not allowed to view this registration due to user mismatch.', SweetAlert::ERROR);
    die();
}

$paid = false;
$earlybird = ($price == 3000 || $price == 5000 || $price == 1) ? true : false;
if ($row['reg_payment_paid'] == 1)
    $paid = true;
else if (checkStatus($format_id) == true) {
    $stmt = $conn->prepare("UPDATE registration SET reg_payment_paid = 1, reg_payment_timestamp = CURRENT_TIMESTAMP() WHERE reg_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    sendEmail(
        $row['reg_email'],
        "TIChE 2026 Registration Confirmation - $name",
        "https://tiche2026.ubu.ac.th/static/function/mail/template/registration_success.html",
        array("name"=>$name, "date"=>date("Y-m-d H:i:s", time()), "id"=>$format_id));
    $paid = true;
}

$stmt->close();

?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <div class="container mb-3">
        <div class="row">
            <div class="col-12 col-lg-3">
                <?php require_once '../static/function/sidetab.php'; ?>
            </div>
            <div class="col-12 col-lg-9">
                <h2 class="font-weight-bold">CONFERENCE REGISTRATION FOR TIChE2026</h2>
                <hr>
                <div class="text-center">
                    <div>
                    <?php if (!$paid) { ?>
                        <div class="alert alert-warning">
                            <strong>Payment pending!</strong> Your registration is not yet completed.
                        </div>
                        <?php if ($earlybird && strtotime(date("Y-m-d H:i:s")) < strtotime("2026-04-01 23:59:59")) { ?>
                        <div class="alert alert-danger text-left">
                            <span class="text-danger font-weight-bold">The payment for early registration rate must be completed by April 1, 2026 (GMT+7, Server time).</span> Otherwise the registration fee will raising to the regular registration rates.<br>
                            TIChE reserve the right not to extend the early registration deadline and rates for any reason.<br>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                <h5 class="font-weight-bold">Thank you for your registration!</h5>
                <p>Your registration has been successfully recorded.
                <p>Registration ID: <strong><?php echo $format_id; ?></strong></p>
                <p>Name: <strong><?php echo $name; ?></strong></p>
                <p>Amount: <strong>THB <?php echo number_format($price, 2); ?></strong><br>
                <?php if ($earlybird) { ?><small>(Secure your early registration rate by completing the payment before April 1, 2026 (GMT+7, Server time)</small><?php } ?>
                </p>
                <?php if (!$paid) { ?>
                <h5 class="font-weight-bold">Please proceed to payment to complete your registration.</h5>
                <?php if ($isClose) { ?>
                <a href="#/registration/proceeder" class="btn btn-danger btn-block display-1 font-weight-bold disabled" disabled>Registration is now closed</a>
                <?php } else { ?>
                <a href="/registration/proceeder" class="btn btn-primary btn-block display-1 font-weight-bold">Proceed to Payment</a>
                <?php } ?>
                <small>
                    If you have already paid, you may need to refresh this page manually.<br>
                    If it's still not updated, please <a href="/post/7">contact us</a> with your registration ID.
                </small>
                <?php } else { ?>
                <div class="alert alert-success">
                    <strong>Payment successful!</strong> Your registration has been completed.
                </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>
