<?php
    require_once '../static/function/connect.php';
    
    $registration_id = xss_clean($_GET['id']);

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
    if (!isAdmin() && (!isLogin() || $rrr['user_id'] != getUser()->getID())) {
        header('Location: /');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
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
                <?php if (!$rrr['reg_payment_paid'] && $rrr['user_id'] == getUser()->getID()) { ?>
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading font-weight-bold">Payment Pending</h4>
                        <p>Your registration is currently pending payment. Please complete the payment to confirm your registration.</p>
                        <a href="/registration/proceed-<?php echo $registration_id; ?>" class="btn btn-primary btn-block">Proceed to Payment</a>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-body">
                        <!-- Category -->
                        <div class="form-group">
                            <label for="reg_date">Date of Registration</label>
                            <input type="text" class="form-control" id="reg_date" name="reg_timestamp" readonly value="<?php echo $rrr['reg_timestamp']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="reg_category">Type of Registration</label>
                            <select class="form-control" id="reg_category" name="reg_category" readonly disabled>
                                    <option value="Presenter">Presenter</option>
                                    <option value="Participant">Participant</option>
                                    <option value="Senior">TIChE Senior Project Contest 2026 Attendee</option>
                                    <option value="High-School">TIChE High-School Project Contest 2026 Attendee</option>
                                </select>
                            <script>$(`#reg_category`).val(`<?php echo $rrr['reg_category']; ?>`);</script>
                        </div>
                        <div class="form-group">
                            <label for="reg_code">Abstract Code</label>
                            <input type="text" class="form-control" id="reg_code" name="reg_code" readonly value="<?php echo $rrr['reg_code']; ?>">
                        </div>
                        <hr>
                        <?php if ($rrr['reg_category'] == 'Presenter' || $rrr['reg_category'] == 'Participant') { ?>
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
                            <?php 
                            $dateBetween = (strtotime($rrr['reg_timestamp']) + 60 * 60 * 24 * 14) - time();
                            // Hard deadline = 9 June 2026, 00:00:00 GMT+7
                            $hardDeadline = strtotime('2026-06-09 00:00:00') - time();
                            if ($hardDeadline < 0) {
                                $dateBetween = -1;
                            }
                            ?>
                            <?php if (($rrr['user_id'] == getUser()->getID() && ($dateBetween > 0) && !$rrr['reg_note_confirm']) || isAdmin()) { ?>
                            <div id="billingEditBtnContainer">
                                <small class="form-text text-muted <?php if (isAdmin()) echo 'd-none';?>">You can edit this information <u class="text-danger">ONLY ONCE</u> within 14 days of registration and not after the conference has started.</small>
                                <a href="#edit" class="btn btn-secondary mt-2" onclick="editBillingInfo(<?php echo $rrr['reg_id']; ?>)">Edit Billing Information</a>
                            </div>
                            <div id="billingEditInfoContainer" style="display:none">
                                <a href="#edit" class="btn btn-success mt-2" onclick="submitEditedBillingInfo(<?php echo $rrr['reg_id']; ?>)">Update</a>
                                <a href="#edit" class="btn btn-danger mt-2" onclick="cancelEditBillingInfo()">Discard</a>
                            </div>
                            <?php } ?>
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
                        <?php } else if ($rrr['reg_category'] == 'Senior') { ?>
                            <div class="form-group">
                                <label for="reg_seniorProject_projectName">Project Name</label>
                                <input type="text" class="form-control" id="reg_seniorProject_projectName" name="reg_seniorProject_projectName" readonly value="<?php echo $rrr['reg_note']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="reg_seniorProject_primaryContactName">Name of Primary Contact</label>
                                <input type="text" class="form-control" id="reg_seniorProject_primaryContactName" name="reg_seniorProject_primaryContactName" readonly value="<?php echo $rrr['reg_fullName']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="reg_seniorProject_primaryContactEmail">Email of Primary Contact</label>
                                <input type="email" class="form-control" id="reg_seniorProject_primaryContactEmail" name="reg_seniorProject_primaryContactEmail" readonly value="<?php echo $rrr['reg_email']; ?>">
                            </div>
                        <?php } else if ($rrr['reg_category'] == 'High-School') { ?>
                            <div class="form-group">
                                <label for="reg_seniorProject_projectName">Project Name</label>
                                <input type="text" class="form-control" id="reg_seniorProject_projectName" name="reg_seniorProject_projectName" readonly value="<?php echo $rrr['reg_note']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="reg_seniorProject_primaryContactName">Name of Primary Contact</label>
                                <input type="text" class="form-control" id="reg_seniorProject_primaryContactName" name="reg_seniorProject_primaryContactName" readonly value="<?php echo $rrr['reg_fullName']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="reg_seniorProject_primaryContactEmail">Email of Primary Contact</label>
                                <input type="email" class="form-control" id="reg_seniorProject_primaryContactEmail" name="reg_seniorProject_primaryContactEmail" readonly value="<?php echo $rrr['reg_email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="reg_highSchoolAttendee_number">Number of Extra Participants <small>(e.g. teachers, excluding students who attend the TIChE High School Project Contest 2026)</small></label>
                                <select class="form-control" id="reg_highSchoolAttendee_number" name="reg_highSchoolAttendee_number" required disabled>
                                    <option value="0">No extra participants</option>
                                    <option value="1">1 person</option>
                                    <option value="2">2 people</option>
                                    <option value="3">3 people</option>
                                </select>
                                <small class="form-text text-muted">For any extra participants, excluding up to 3 students who attend the TIChE High School Project Contest 2026, have to pay an extra 1250 THB/person)</small>
                                <script>$(`#reg_highSchoolAttendee_number`).val(`<?php echo $rrr['reg_phone']; ?>`);</script>
                            </div>
                            <div class="form-group">
                                <label for="reg_note">Receipt Information (Billing Address)</label>
                                <textarea class="form-control" id="reg_note" name="reg_note" readonly rows="5"><?php echo $rrr['reg_note']; ?></textarea>
                                <?php 
                                $dateBetween = (strtotime($rrr['reg_timestamp']) + 60 * 60 * 24 * 14) - time();
                                // Hard deadline = 9 June 2026, 00:00:00 GMT+7
                                $hardDeadline = strtotime('2026-06-09 00:00:00') - time();
                                if ($hardDeadline < 0) {
                                    $dateBetween = -1;
                                }
                                ?>
                                <?php if (($rrr['user_id'] == getUser()->getID() && ($dateBetween > 0) && !$rrr['reg_note_confirm']) || isAdmin()) { ?>
                                <div id="billingEditBtnContainer">
                                    <small class="form-text text-muted <?php if (isAdmin()) echo 'd-none';?>">You can edit this information <u class="text-danger">ONLY ONCE</u> within 14 days of registration and not after the conference has started.</small>
                                    <a href="#edit" class="btn btn-secondary mt-2" onclick="editBillingInfo(<?php echo $rrr['reg_id']; ?>)">Edit Billing Information</a>
                                </div>
                                <div id="billingEditInfoContainer" style="display:none">
                                    <a href="#edit" class="btn btn-success mt-2" onclick="submitEditedBillingInfo(<?php echo $rrr['reg_id']; ?>)">Update</a>
                                    <a href="#edit" class="btn btn-danger mt-2" onclick="cancelEditBillingInfo()">Discard</a>
                                </div>
                                <?php } ?>
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
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let originalBillingInfo = $("#reg_note").val();
        function editBillingInfo(registrationId) {
            swal({
                title: 'Edit Billing Information',
                text: '<?php if (isAdmin()) { echo "You are editing this registration as an administrator. Please make sure to input the correct billing information."; } else { echo "You can only edit your billing information once. Are you sure you want to edit it?"; } ?>',
                icon: 'warning',
                buttons: ['Cancel', 'Edit'],
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    $("#reg_note").removeAttr("readonly").focus();
                    $("#billingEditBtnContainer").hide();
                    $("#billingEditInfoContainer").show();
                }
            });
        }
        function cancelEditBillingInfo() {
            $("#reg_note").val(originalBillingInfo);
            $("#reg_note").attr("readonly", "readonly");
            $("#billingEditBtnContainer").show();
            $("#billingEditInfoContainer").hide();
        }

        function submitEditedBillingInfo(registrationId) {
            swal({
                title: 'Update Billing Information',
                text: 'Are you sure you want to update your billing information? This action cannot be undone.',
                icon: 'warning',
                buttons: ['Cancel', 'Update'],
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    $.post('/endpoint/registration_billingInfoEdit.php', { registration_id: registrationId, new_billing_info: $("#reg_note").val() }, function(response) {
                        if (response.success) {
                            swal('Success', 'Your billing information has been updated.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            swal('Error', response.message, 'error');
                        }
                    }, 'json');
                }
            });
        }
    </script>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>