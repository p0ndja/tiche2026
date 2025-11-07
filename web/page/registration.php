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
            <div class="col-12 col-lg-9">
                <h2 class="font-weight-bold">REGISTRATION FOR TIChE2026</h2>
                <hr>
                <div>
                <?php 
                $isClose = getDatatable("closeRegistration")["value"];
                if ($isClose) { ?>
                    <div class="alert alert-danger">
                    TIChE has already ended. The Registration is now closed.</div>
                <?php } ?>
                <table class="table w-100 table-light table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="background-color: var(--ubu-blue); color: white; vertical-align: middle;"><b>REGISTRATION FEE</b></th>
                            <th scope="col" style="background-color: var(--ubu-blue); color: white; vertical-align: middle;"><center><b>Early Registration<br><small>until March 31, 2025</small></b></center></th>
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
                <span class="text-danger font-weight-bold">Please note that payment for early registration rate must be completed by April 1, 2025 (GMT+7, Server time).</span> Otherwise the registration fee will raising to the regular registration rates.<br>
                TIChE reserve the right not to extend the early registration deadline and rates for any reason.
                <br>
                <br><b>Download: <a href="/static/asset/upload/หนังสืออนุมัติเข้าร่วมประชุม%20โดยไม่ถือเป็นวันลา.pdf" target="_blank">หนังสืออนุมัติเข้าร่วมประชุม โดยไม่ถือเป็นวันลา</a></b>
                <br>
                <br><b>Registration fee includes:</b><br>
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
                </div>
                <h4 class="font-weight-bold mt-5">ONLINE REGISTRATION</h4>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo ($isClose) ? "#" : "../endpoint/registration_submit.php"; ?>" method="post" enctype="multipart/form-data">
                            <small class="text-danger">* Required</small>
                            <hr>
                            <!-- Category -->
                            <div class="form-group">
                                <label for="reg_category">Type of Registration<span class="text-danger">*</span></label>
                                <select class="form-control" id="reg_category" name="reg_category" required <?php if ($isClose) echo "disabled"; ?>>
                                    <option value="Presenter">Presenter</option>
                                    <option value="Participant">Participant</option>
                                </select>
                            </div>
                            <div class="form-group" id="reg_code_div">
                                <label for="reg_code">Abstract Code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reg_code" name="reg_code" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            <script>
                                // show/hide registration code input
                                $('#reg_category').on('change', function() {
                                    if ($('#reg_category').val() == 'Presenter') {
                                        $('#reg_code_div').show();
                                        $('#reg_code').prop('required', true);
                                    } else {
                                        $('#reg_code_div').hide();
                                        $('#reg_code').prop('required', false);
                                    }
                                });
                            </script>
                            <hr>
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
                            <div class="cf-turnstile mb-4" data-theme="light" data-sitekey="0x4AAAAAABh0HRZB4iCc89in"></div>
                            <button class="btn btn-<?php echo ($isClose) ? "danger" : "primary"; ?> btn-block" <?php if ($isClose) echo "disabled"; ?> id="submitBtn"><?php echo ($isClose) ? "Registration Closed" : "Submit"; ?></button>
                            <script>
                                
                                // check if all required fields are filled, enable submit button
                                $('input, textarea, select').on('input', function() {
                                    var empty = false;
                                    let captcha = document.querySelector('[name="cf-turnstile-response"]').value;
                                    $('input, textarea, select').each(function() {
                                        if (($(this).prop('required') && $(this).val() == '') || $(this).hasClass('is-invalid')) {
                                            empty = true;
                                        }
                                    });
                                    if (empty || captcha === "") {
                                        $('button').prop('disabled', true);
                                    } else {
                                        $('button').prop('disabled', false);
                                    }
                                });

                                //validate on email input
                                $('#reg_email').on('input', function() {
                                    var email = $('#reg_email').val();
                                    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/;
                                    if (emailPattern.test(email)) {
                                        $('#reg_email').removeClass('is-invalid');
                                        $('#reg_email').addClass('is-valid');
                                    } else {
                                        $('#reg_email').removeClass('is-valid');
                                        $('#reg_email').addClass('is-invalid');
                                    }
                                });
                            </script>
                        </form>
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
