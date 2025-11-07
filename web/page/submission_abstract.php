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
                <h3 class="font-weight-bold">ABSTRACT SUBMISSION</h3>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <?php $isClose = getDatatable("closeSubmitAbstract")["value"]; ?>
                        <?php
                        if ($isClose) { ?>
                            <div class="alert alert-danger">Submission is now closed. Thank you for your interest.</div>
                        <?php } ?>
                        <form action="<?php if ($isClose) { echo "#"; } else { echo "../endpoint/submission_submit.php"; } ?>" method="post" enctype="multipart/form-data">
                            <small class="text-danger">* required</small>
                            <h5 class="font-weight-bold mt-3 mb-0">Author Information</h5>
                            <hr>
                            <div class="form-group">
                                <label for="sub_fullName">Presenter Name (including Title)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_fullName" name="sub_fullName" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="sub_affiliation">Affiliation<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_affiliation" name="sub_affiliation" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="sub_email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="sub_email" name="sub_email" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>

                            <h5 class="font-weight-bold mt-5 mb-0">Corresponding Author Information</h5>
                            <hr>
                            <div class="form-group">
                                <label for="sub_co_fullName">Corresponding Author Name (including Title)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_co_fullName" name="sub_co_fullName" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="sub_co_affiliation">Affiliation<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_co_affiliation" name="sub_co_affiliation" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="sub_co_email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="sub_co_email" name="sub_co_email" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            
                            <h5 class="font-weight-bold mt-5 mb-0">Abstract Information</h5>
                            <hr>
                            <div class="form-group">
                                <label for="sub_title">Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_title" name="sub_title" required <?php if ($isClose) echo "disabled"; ?>>
                            </div>
                            <div class="form-group">
                                <label for="sub_abstract">Abstract<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="sub_abstract" name="sub_abstract" required <?php if ($isClose) echo "disabled"; ?> rows="5"></textarea>
                            </div>
                            <!-- Category -->
                            <div class="form-group">
                                <label for="sub_category">Category<span class="text-danger">*</span></label>
                                <select class="form-control" id="sub_category" name="sub_category" required <?php if ($isClose) echo "disabled"; ?>>
                                    <option value="Catalysis and Reaction Engineering">Session 1: Catalysis and Reaction Engineering (CR)</option>
                                    <option value="Sustainable and Green Chemistry">Session 2: Sustainable and Green Chemistry (SG)</option>
                                    <option value="Advanced Materials and Nanotechnology">Session 3: Advanced Materials and Nanotechnology (AM)</option>
                                    <option value="Biochemical and Environmental Engineering">Session 4: Biochemical and Environmental Engineering (BE)</option>
                                    <option value="Process Engineering and Digital Technologies">Session 5: Process Engineering and Digital Technologies (PE)</option>
                                    <option value="Energy and Fuels">Session 6: Energy and Fuels (EF)</option>
                                    <option value="Industrial Applications and Case Studies">Session 7: Industrial Applications and Case Studies (IA)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sub_type">Presentation Type<span class="text-danger">*</span></label>
                                <select class="form-control" id="sub_type" name="sub_type" required <?php if ($isClose) echo "disabled"; ?>>
                                    <option value="Oral">Oral</option>
                                    <option value="Poster">Poster</option>
                                </select>
                            </div>
                            <!-- Upload File -->
                            <div class="form-group">
                                <label for="sub_file">Upload File <span class="text-danger">*</span> <a href="/static/asset/upload/TIChE2026%20Abstract%20Template.docx" target="_blank">[Download Abstract Template]</a></label>
                                <input type="file" class="form-control-file" id="sub_file" name="sub_file" required <?php if ($isClose) echo "disabled"; ?> accept=".doc,.docx">
                                <span class="text-danger">Accept: .doc, .docx</span>
                            </div>
                            <button type="submit" class="btn btn-<?php echo ($isClose) ? "danger" : "primary"; ?> btn-block" <?php if ($isClose) echo "disabled"; ?>><?php if ($isClose) { echo "Submission Closed"; } else { echo "Submit Abstract"; } ?></button>
                            <script>
                                // check if all required <?php if ($isClose) echo "disabled"; ?> fields are filled, enable submit button
                                // $('input, textarea, select').on('input', function() {
                                //     var empty = false;
                                //     $('input, textarea, select').each(function() {
                                //         if ($(this).val() == '') {
                                //             empty = true;
                                //         }
                                //     });
                                //     if (empty) {
                                //         $('button').prop('<?php if ($isClose) echo "disabled"; ?>', true);
                                //     } else {
                                //         $('button').prop('<?php if ($isClose) echo "disabled"; ?>', false);
                                //     }
                                // });

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