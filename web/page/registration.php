<?php require_once '../static/function/connect.php'; ?>
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
            <?php $isClose = getDatatable("closeRegistration")["value"]; ?>
            <div class="col-12 col-lg-9">
                <h2 class="font-weight-bold">CONFERENCE REGISTRATION FOR TIChE2026</h2>
                <?php
                    if (isLogin() && !isAdmin()) {
                        $userId = (int) getUser()->getID();
                        if ($stmt = $conn->prepare("SELECT COUNT(*) FROM registration WHERE user_id = $userId")) {
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            if ($count > 0) {
                                echo '<div class="alert alert-info">You have already registered to the conference. See <a href="/registration/list">[all your registrations]</a>.</div>';
                            }
                            $stmt->close();
                        }
                    }
                ?>
                <hr>
                <div>
                    <h5 class="font-weight-bold">For Presenters and General Participants</h5>
                    <table class="table w-100 table-light table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="background-color: var(--ubu-blue); color: white; vertical-align: middle;"><b>REGISTRATION FEE</b></th>
                                <th scope="col" style="background-color: var(--ubu-blue); color: white; vertical-align: middle;"><center><b>Early Registration<br><small>until March 31, 2026</small></b></center></th>
                                <th scope="col" style="background-color: var(--ubu-blue); color: white; vertical-align: middle;"><center><b>Regular Registration</b></center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="background-color: var(--ubu-yellow); color: var(--ubu-blue); vertical-align: middle;"><b>Presenters<br><small>(One submission requires at least one registration)</small></b></td>
                                <td style="background-color: var(--ubu-pink); color: white; vertical-align: middle;"><center><b>5,000 THB</b></center></td>
                                <td style="background-color: var(--ubu-yellow); color: var(--ubu-blue); vertical-align: middle;"><center><b>6,000 THB</b></center></td>
                            </tr>
                            <tr>
                                <td style="background-color: var(--ubu-yellow); color: var(--ubu-blue); vertical-align: middle;"><b>Participants (General)</b></td>
                                <td style="background-color: var(--ubu-pink); color: white; vertical-align: middle;"><center><b>3,500 THB</b></center></td>
                                <td style="background-color: var(--ubu-yellow); color: var(--ubu-blue); vertical-align: middle;"><center><b>4,000 THB</b></center></td>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        <span class="text-danger font-weight-bold">Please note that payment for early registration rate must be completed by April 1, 2026 (GMT+7, Server time).</span> Otherwise the registration fee will raising to the regular registration rates.<br>
                        TIChE reserve the right not to extend the early registration deadline and rates for any reason.
                    </p>
                    <p>
                        <b>Registration fee includes:</b><br>
                        1. Access to all sessions including TNChE Asia 2026<br>
                        2. Conference program<br>
                        3. Abstract book (online version)<br>
                        4. TIChE2026 conference proceeding (online version)<br>
                        5. All printed material of the conference<br>
                        6. Name tag<br>
                        7. Certificate<br>
                        8. Coffee breaks<br>
                        9. Lunches<br>
                    </p>
                    <p>
                        <b>Download: <a href="/static/asset/upload/หนังสืออนุมัติเข้าร่วมประชุม%20โดยไม่ถือเป็นวันลา.pdf" target="_blank">หนังสืออนุมัติเข้าร่วมประชุม โดยไม่ถือเป็นวันลา</a></b>
                    </p>
                </div>
                <hr>
                <div>
                    <h5 class="font-weight-bold">For Senior Projects/High-school Student Attendees</h5>
                    <table class="table w-100 table-light table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="background-color: var(--ubu-gold); color: white; vertical-align: middle;"><b>REGISTRATION FEE</b></th>
                                <th scope="col" style="background-color: var(--ubu-gold); color: white; vertical-align: middle;"><center><b>Regular Registration</b></center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="background-color: var(--ubu-yellow); color: var(--ubu-blue); vertical-align: middle;"><b>TIChE Senior Project Contest 2026 Attendees</b></td>
                                <td style="background-color: var(--ubu-sub-yellow); color: var(--ubu-blue); vertical-align: middle;"><center><b>Free*</b><br><small>(*Registration required only once per each project)</small></center></td>
                            </tr>
                            <tr>
                                <td style="background-color: var(--ubu-yellow); color: var(--ubu-blue); vertical-align: middle;"><b>High-School Student Attendees<!--br><small>(3 people per project)</small--></b></td>
                                <td style="background-color: var(--ubu-sub-yellow); color: var(--ubu-blue); vertical-align: middle;"><center><i><b>to be announced</b></i></center></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                <p>
                
                </p>
                </div>
                <h3 class="font-weight-bold mt-5">ONLINE REGISTRATION</h3>
                <hr>
                <?php
                if ($isClose) { ?>
                    <div class="alert alert-danger">
                    TIChE has already ended. The Registration is now closed.</div>
                <?php } else if (!isLogin()) { ?>
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading font-weight-bold">Please Log In</h4>
                        <p>You need to log in to register for the conference. Please log in or create an account if you don't have one.</p>
                        <a href="/login/" class="btn btn-primary">Log In</a>
                    </div>
                <?php } else { ?>
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo ($isClose) ? "#" : "../endpoint/registration_submit.php"; ?>" method="post" enctype="multipart/form-data" id="regForm" autocomplete="off">
                            <small class="text-danger">* Required</small>
                            <hr>
                            <!-- Category -->
                            <div class="form-group">
                                <label for="reg_category">Type of Registration<span class="text-danger">*</span></label>
                                <select class="form-control" id="reg_category" name="reg_category" required <?php if ($isClose) echo "disabled"; ?>>
                                    <option value="Presenter">Presenter</option>
                                    <option value="Participant">Participant</option>
                                    <option value="Senior">TIChE Senior Project Contest 2026 Attendee</option>
                                    <option value="High-School Student Attendee" disabled>High-School Student Attendee</option>
                                </select>
                            </div>
                            <div class="form-group" id="reg_code_div">
                                <label for="reg_code">Abstract Code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reg_code" name="reg_code" required <?php if ($isClose) echo "disabled"; ?>>
                                <small class="form-text text-muted">Must be the code given by the conference organizers. Case and format sensitive.</small>
                            </div>
                            <script>
                                // show/hide registration code input
                                $('#reg_category').on('change', function() {
                                    if ($('#reg_category').val() == 'Presenter') {
                                        $('#reg_code_div').show();
                                        $("#reg_participant").show();
                                        $('#reg_seniorProject').hide();
                                        $('#reg_code').prop('required', true);
                                    } else if ( $('#reg_category').val() == 'Senior') {
                                        $('#reg_code_div').show();
                                        $('#reg_code').prop('required', true);
                                        $('#reg_participant').hide();
                                        $('#reg_seniorProject').show();
                                    } else {
                                        $("#reg_participant").show();
                                        $('#reg_seniorProject').hide();
                                        $('#reg_code_div').hide();
                                        $('#reg_code').prop('required', false);
                                    }
                                });
                            </script>
                            <hr>
                            <div id="reg_participant">
                                <div class="form-group">
                                    <label for="reg_fullName">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reg_fullName" name="reg_fullName" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                                <div class="form-group">
                                    <label for="reg_affiliation">Affiliation<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reg_affiliation" name="reg_affiliation" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                                <div class="form-group">
                                    <label for="reg_email">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="reg_email" name="reg_email" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                                <div class="form-group">
                                    <label for="reg_phone">Phone Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reg_phone" name="reg_phone" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                                <hr>
                                <!-- Upload File -->
                                <div class="form-group">
                                    <label for="reg_note">Receipt Information (Billing Address) <small class="text-primary">In Thai or English</small></label>
                                    <textarea class="form-control" id="reg_note" name="reg_note" rows="5" <?php if ($isClose) echo "disabled"; ?>></textarea>
                                </div>
                            </div>
                            <div id="reg_seniorProject" style="display: none;">
                                <div class="form-group">
                                    <label for="reg_seniorProject_projectName">Project Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reg_seniorProject_projectName" name="reg_seniorProject_projectName" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                                <div class="form-group">
                                    <label for="reg_seniorProject_primaryContactName">Name of Primary Contact<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reg_seniorProject_primaryContactName" name="reg_seniorProject_primaryContactName" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                                <div class="form-group">
                                    <label for="reg_seniorProject_primaryContactEmail">Email of Primary Contact<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="reg_seniorProject_primaryContactEmail" name="reg_seniorProject_primaryContactEmail" required <?php if ($isClose) echo "disabled"; ?>>
                                </div>
                            </div>
                            <div class="cf-turnstile mb-4" data-theme="light" data-sitekey="0x4AAAAAABh0HRZB4iCc89in"></div>
                            <button class="btn btn-<?php echo ($isClose) ? "danger" : "primary"; ?> btn-block" disabled <?php if ($isClose) echo "disabled"; ?> id="submitBtn"><?php echo ($isClose) ? "Registration Closed" : "Submit"; ?></button>
                            <script>
                                
                                // check if all required fields are filled, enable submit button
                                $("#submitBtn").on('click', function(e) {
                                    let captcha = document.querySelector('[name="cf-turnstile-response"]').value;
                                    if (!captcha) {
                                        e.preventDefault();
                                        swal("Oops","Please complete captcha!", "error");
                                        return false;
                                    } else {
                                        $("#regForm").submit();
                                    }
                                });
                                $('input, textarea, select').on('input', function() {
                                    var empty = false;
                                    $('input, textarea, select').each(function() {
                                        if (($(this).prop('required') && $(this).is(':visible')) && ($(this).val() == '') || $(this).hasClass('is-invalid')) {
                                            empty = true;
                                        }
                                    });
                                    if (empty) {
                                        $('#submitBtn').prop('disabled', true);
                                    } else {
                                        $('#submitBtn').prop('disabled', false);
                                    }
                                });

                                //validate on email input
                                $('#reg_email, #reg_seniorProject_primaryContactEmail').on('input', function() {
                                    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/;
                                    if (emailPattern.test($(this).val())) {
                                        $(this).removeClass('is-invalid');
                                        $(this).addClass('is-valid');
                                    } else {
                                        $(this).removeClass('is-valid');
                                        $(this).addClass('is-invalid');
                                    }
                                });

                                // validate abstract code, only when presenter is selected
                                // in format of TIChE-XX-NN, where XX is two-letter (CR, SG, AM, BE, PE, EF, IA) and NN is two-digit number
                                $('#reg_code').on('input', function() {
                                    if ($('#reg_category').val() == 'Presenter') {
                                        var code = $('#reg_code').val();
                                        var codePattern = /^TIChE-(CR|SG|AM|BE|PE|EF|IA)-\d{2}$/;
                                        if (codePattern.test(code)) {
                                            $('#reg_code').removeClass('is-invalid');
                                            $('#reg_code').addClass('is-valid');
                                        } else {
                                            $('#reg_code').removeClass('is-valid');
                                            $('#reg_code').addClass('is-invalid');
                                        }
                                    } else if ($('#reg_category').val() == 'Senior') {
                                        // in format of TIChE-SE-XNN, where NN is two-digit number, X is A for Applied and B for Basic
                                        var code = $('#reg_code').val();
                                        var codePattern = /^TIChE-SE-(A|B)\d{2}$/;
                                        if (codePattern.test(code)) {
                                            $('#reg_code').removeClass('is-invalid');
                                            $('#reg_code').addClass('is-valid');
                                        } else {
                                            $('#reg_code').removeClass('is-valid');
                                            $('#reg_code').addClass('is-invalid');
                                        }
                                    } else {
                                        $('#reg_code').removeClass('is-invalid');
                                        $('#reg_code').removeClass('is-valid');
                                    }
                                });
                            </script>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>
