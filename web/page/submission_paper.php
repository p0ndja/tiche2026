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
                <?php $isClose = getDatatable("closeSubmitTicheProceeding")["value"]; ?>
                <h3 class="font-weight-bold">FULL PAPER SUBMISSION</h3>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <form action="../endpoint/submission_paper_submit.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="full-paper">
                            <small class="text-danger">* Required</small><br>
                            <div class="form-group">
                                <label for="typeOfPaper">Type of Paper <span class="text-danger">*</span></label>
                                <select id="typeOfPaper" name="typeOfPaper" class="form-control" required>
                                    <option value="" disabled selected>Select Type of Paper</option>
                                    <option value="TIChE2026 Conference Proceeding" <?php if ($isClose) echo "disabled class='text-danger'"; ?>>TIChE2026 Conference Proceeding <?php if ($isClose) echo "[CLOSED]"; ?></option>
                                    <option value="Thai Environmental Engineering Journal">Thai Environmental Engineering Journal</option>
                                </select>
                            </div>
                            <div id="note"></div>
                            <div id="info" style="display:none">
                            <h5 class="font-weight-bold mt-3 mb-0">Full Paper and Authors Information</h5>
                            <hr>
                            <div class="form-group">
                                <label for="sub_code">Abstract Code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_code" name="sub_code" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_title">Title of Full Paper<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_title" name="sub_title" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_fullName">First Author Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_fullName" name="sub_fullName" required>
                            </div>
                            <div class="form-group d-none">
                                <label for="sub_affiliation">Affiliation<span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" id="sub_affiliation" name="sub_affiliation" value="-">
                            </div>
                            <div class="form-group">
                                <label for="sub_email">Email of First Author<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="sub_email" name="sub_email" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_co_fullName">Corresponding Author Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_co_fullName" name="sub_co_fullName" required>
                            </div>
                            <div class="form-group d-none">
                                <label for="sub_co_affiliation">Affiliation<span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" id="sub_co_affiliation" name="sub_co_affiliation" value="-">
                            </div>
                            <div class="form-group">
                                <label for="sub_co_email">Email of Corresponding Author<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="sub_co_email" name="sub_co_email" required>
                            </div>

                            <!-- Upload File -->
                            <div class="form-group">
                                <label for="sub_file" id="sub_file_label">Upload File<span class="text-danger">*</span>&nbsp;
                                <!-- <a href="/static/asset/upload/TIChE2026%20Abstract%20Template.docx" target="_blank">[Download Abstract Template]</a>--></label>
                                <input type="file" class="form-control-file" id="sub_file" name="sub_file" required accept=".doc,.docx">
                                <span class="text-danger">Accept: .doc, .docx</span>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" disabled>Submit</button>
                            </div>
                            <script>
                                $("#typeOfPaper").change(function() {
                                    var type = $(this).val();
                                    if (type == '') {
                                        $('#info').hide();
                                    } else {
                                        $('#info').show();
                                    }
                                    if (type == 'TIChE2026 Conference Proceeding') {
                                        $('#note').html(`
                                        <span class='text-primary'>Please note that this full paper will be published in the <b><i>TIChE2026 Conference Proceedings</i></b>.
                                        If the authors need to preceed with this publication, the submission must follow the provided template and consist of no fewer than 5 pages. </span>
                                        <span class='text-danger'>The final submission deadline is <b>April 30, 2026</b>.</span>
                                        `);
                                        $("#sub_file_label").html("Upload File<span class='text-danger'>*</span>&nbsp;<a href='/static/asset/upload/TIChE2026%20Conference%20Proceeding%20Template.docx' target='_blank'>[Download TIChE2026 Conference Proceeding Template]</a>");
                                    } else if (type == 'Thai Environmental Engineering Journal') {
                                        $('#note').html(`
                                        <span class='text-primary'>Please note that this full paper will be considered by the TIChE2026 conference committee to ensure it aligns perfectly with the journal’s aims and scope to foster academic dialogue before submission to <b><i>Thai Environmental Engineering Journal</i></b>.</span> <span class='text-danger'>Kindly submit the manuscript to the TIChE2026 conference committee as indicated below <b>by June 30, 2026</b>. Then, we will inform the author regarding submission to the journal after consideration.</span>
                                        <h5 class="font-weight-bold mt-4 mb-0">About Journal</h5>
                                        <hr>
                                        <strong>Thai Environmental Engineering Journal&nbsp;</strong><br />
                                        TCI: <b>Tier 1</b><br /><br />
                                        See <a href="https://so05.tci-thaijo.org/index.php/teej">https://so05.tci-thaijo.org/index.php/teej</a><br><br>

                                        <img alt="" src="https://so05.tci-thaijo.org/public/journals/649/cover_issue_18068_en_US.jpg" style="margin:0 !important; text-align:left !important; width:160px" class="z-depth-1"/>
                                        <div class="pb-3"></div>
                                        `);
                                        $("#sub_file_label").html("Upload Manuscript File<span class='text-danger'>*</span>");
                                    }
                                });
                            </script>
                            <script>
                                // check if all required fields are filled, enable submit button
                                $('input, textarea, select').on('input', function() {
                                    var empty = false;
                                    $('input, textarea, select').each(function() {
                                        if ($(this).prop('required') && $(this).val() == '') {
                                            empty = true;
                                        }
                                    });
                                    if (empty) {
                                        $('button').prop('disabled', true);
                                    } else {
                                        $('button').prop('disabled', false);
                                    }
                                });

                                $('#sub_email, #sub_co_email').on('input', function() {
                                    var email = $(this).val();
                                    if (email != '') {
                                        if (validateEmail(email)) {
                                            $(this).removeClass('is-invalid');
                                            $(this).addClass('is-valid');
                                        } else {
                                            $(this).removeClass('is-valid');
                                            $(this).addClass('is-invalid');
                                        }
                                    } else {
                                        $(this).removeClass('is-valid');
                                        $(this).removeClass('is-invalid');
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