<?php
    require_once '../static/function/connect.php';
    if (!isAdmin()) {
        header('Location: /');
        exit();
    }

    $registration_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM registration WHERE reg_id = ?");
    $stmt->bind_param("s", $registration_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        header('Location: /');
        exit();
    }
    $rrr = null;
    while ($r = $result->fetch_assoc()) {
        $rrr = $r;
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
            <div class="d-none">
                <?php require_once '../static/function/sidetab.php'; ?>
            </div>
            <div class="col-12">
                <a onclick="window.history.back();" class="float-left"><i class="fas fa-arrow-left"></i> Back</a><br>
                <h2 class="font-weight-bold">Registration ID: <?php echo $registration_id; ?></h2>
                <div class="card">
                    <div class="card-body">
                        <!-- Category -->
                        <div class="form-group">
                            <label for="reg_category">Type of Registration</label>
                            <select class="form-control" id="reg_category" name="reg_category" disabled>
                                    <option value="Presenter">Presenter</option>
                                    <option value="Participant">Participant</option>
                                </select>
                            <script>$(`#reg_category`).val(`<?php echo $rrr['reg_category']; ?>`);</script>
                        </div>
                        <div class="form-group">
                            <label for="reg_code">Abstract Code</label>
                            <input type="text" class="form-control" id="reg_code" name="reg_code" readonly value="<?php echo $rrr['reg_code']; ?>">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="reg_fullName">Full Name</label>
                            <input type="text" class="form-control" id="reg_fullName" name="reg_fullName" readonly value="<?php echo $rrr['reg_fullName']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reg_affiliation">Affiliation</label>
                            <input type="text" class="form-control" id="reg_affiliation" name="reg_affiliation" readonly value="<?php echo $rrr['reg_affiliation']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reg_email">Email</label>
                            <input type="email" class="form-control" id="reg_email" name="reg_email" readonly value="<?php echo $rrr['reg_email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reg_phone">Phone Number</label>
                            <input type="text" class="form-control" id="reg_phone" name="reg_phone" readonly value="<?php echo $rrr['reg_phone']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reg_note">Receipt Information (Billing Address)</label>
                            <textarea class="form-control" id="reg_note" name="reg_note" readonly rows="5"><?php echo $rrr['reg_note']; ?></textarea>
                        </div>
                        <h5 class="font-weight-bold mt-3 mb-0">Payment Information</h5>
                        <hr>
                        <div class="form-group">
                            <label for="reg_date">Date of Payment</label>
                            <input type="text" class="form-control" id="reg_date" name="reg_payment_date" readonly value="<?php echo $rrr['reg_payment_timestamp']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reg_amount">Amount of Payment (in THB)</label>
                            <input type="text" class="form-control" id="reg_amount" name="reg_payment_amount" readonly value="<?php echo $rrr['reg_payment_amount']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>