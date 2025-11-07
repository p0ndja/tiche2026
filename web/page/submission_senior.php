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
                <h3 class="font-weight-bold">TIChE SENIOR PROJECT CONTEST 2025</h3>
                <hr>
                <p>TIChE Senior Project Contest 2025 is one of the key events at TIChE2026, a competition showcasing outstanding undergraduate research in chemical engineering and applied chemistry across universities in Thailand. It provides students with a platform to present their innovative projects and gain recognition for their work.</p>
                <p>
                <b>Competition Categories:</b>
                <ul>
                    <li>Basic Research</li>
                    <li>Applied Research</li>
                </ul>
                </p>
                <p>
                <b>Project Submission:</b>
                <ul>
                    <li>A maximum of 40 projects will be accepted for the competition.</li>
                    <li>Department may nominate 2 projects, consisting of one project in Basic Research and one project in Applied Research.</li>
                    <li>TIChE will cover expenses for up to 4 students per department participating in the competition. Therefore, departments should nominate 4 students (or two per project).</li>
                    <li>All projects must prepare an A0-size English poster and deliver a Thai-language presentation to the committee.</li>
                </ul>
                </p>
                <p>
                <b>Submission Deadlines and Competition Date:</b>
                <ul>
                    <li>Department must submit two projects, along with a list of up to four students and the name of a faculty member serving as a committee, by <b>April 30, 2025.</b></li>
                    <li>The competition will be held on <b>May 20, 2025</b>, with sessions scheduled for both the morning and afternoon.</li>
                </ul>
                </p>
                <p><b>Additional Information (in Thai):</b></p>
                <p>
                    Participants and faculty members can access important materials, including competition guidelines, evaluation criteria, and event schedules. These materials will help ensure that projects meet the required standards and that all participants are well-prepared for the competition.
                </p>
                <p>
                    <b>Download materials here:</b> <a href="/static/asset/upload/TIChE%20Senior%20Project%20Contest%202025.pdf" target="_blank">TIChE Senior Project Contest 2025</a><br>
                    <b>Download template here:</b> <a href="/static/asset/upload/TIChE2026%20Abstract%20Template.docx" target="_blank">Abstract Template</a>
                </p>

                <h3 class="font-weight-bold mt-5">ONLINE REGISTRATION</h3>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <form action="../endpoint/submission_senior_submit.php" method="post" enctype="multipart/form-data">
                            <small class="text-danger">* Required</small>
                            <div class="form-group">
                                <label for="sub_university">University<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_university" name="sub_university" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_department">Department<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_department" name="sub_department" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_facultyMember">Name of Faculty Member (Serving as Committee)</label>
                                <input type="text" class="form-control" id="sub_facultyMember" name="sub_facultyMember">
                            </div>

                            <h5 class="font-weight-bold mt-5 mb-0">BASIC RESEARCH (PROJECT 1)</h5>
                            <hr>
                            <div class="form-group">
                                <label for="sub_proj1_name">Name of Project 1<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_proj1_name" name="sub_proj1_name" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_abstract">Abstract of Project 1 (Maximum 250 words)<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="sub_proj1_abstract" name="sub_proj1_abstract" required rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_std1_name_th">Name of Student 1 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj1_std1_name_th" name="sub_proj1_std1_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_std1_name_en">Name of Student 1 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj1_std1_name_en" name="sub_proj1_std1_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_std1_name_contact">Email / Telephone Number of Student 1</label>
                                <input type="text" class="form-control" id="sub_proj1_std1_name_contact" name="sub_proj1_std1_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_std2_name_th">Name of Student 2 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj1_std2_name_th" name="sub_proj1_std2_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_std2_name_en">Name of Student 2 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj1_std2_name_en" name="sub_proj1_std2_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_std2_name_contact">Email / Telephone Number of Student 2</label>
                                <input type="text" class="form-control" id="sub_proj1_std2_name_contact" name="sub_proj1_std2_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_adv1_name_th">Name of Advisor 1 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj1_adv1_name_th" name="sub_proj1_adv1_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_adv1_name_en">Name of Advisor 1 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj1_adv1_name_en" name="sub_proj1_adv1_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_adv1_name_contact">Email / Telephone Number of Advisor 1</label>
                                <input type="text" class="form-control" id="sub_proj1_adv1_name_contact" name="sub_proj1_adv1_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_adv2_name_th">Name of Advisor 2 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj1_adv2_name_th" name="sub_proj1_adv2_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_adv2_name_en">Name of Advisor 2 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj1_adv2_name_en" name="sub_proj1_adv2_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj1_adv2_name_contact">Email / Telephone Number of Advisor 2</label>
                                <input type="text" class="form-control" id="sub_proj1_adv2_name_contact" name="sub_proj1_adv2_name_contact">
                            </div>
                            <h5 class="font-weight-bold mt-5 mb-0">APPLIED RESEARCH (PROJECT 2)</h5>
                            <hr>
                            <div class="form-group">
                                <label for="sub_proj2_name">Name of Project 2<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_proj2_name" name="sub_proj2_name" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_abstract">Abstract of Project 2 (Maximum 250 words)<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="sub_proj2_abstract" name="sub_proj2_abstract" required rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_std1_name_th">Name of Student 1 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj2_std1_name_th" name="sub_proj2_std1_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_std1_name_en">Name of Student 1 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj2_std1_name_en" name="sub_proj2_std1_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_std1_name_contact">Email / Telephone Number of Student 1</label>
                                <input type="text" class="form-control" id="sub_proj2_std1_name_contact" name="sub_proj2_std1_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_std2_name_th">Name of Student 2 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj2_std2_name_th" name="sub_proj2_std2_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_std2_name_en">Name of Student 2 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj2_std2_name_en" name="sub_proj2_std2_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_std2_name_contact">Email / Telephone Number of Student 2</label>
                                <input type="text" class="form-control" id="sub_proj2_std2_name_contact" name="sub_proj2_std2_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_adv1_name_th">Name of Advisor 1 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj2_adv1_name_th" name="sub_proj2_adv1_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_adv1_name_en">Name of Advisor 1 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj2_adv1_name_en" name="sub_proj2_adv1_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_adv1_name_contact">Email / Telephone Number of Advisor 1</label>
                                <input type="text" class="form-control" id="sub_proj2_adv1_name_contact" name="sub_proj2_adv1_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_adv2_name_th">Name of Advisor 2 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj2_adv2_name_th" name="sub_proj2_adv2_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_adv2_name_en">Name of Advisor 2 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj2_adv2_name_en" name="sub_proj2_adv2_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj2_adv2_name_contact">Email / Telephone Number of Advisor 2</label>
                                <input type="text" class="form-control" id="sub_proj2_adv2_name_contact" name="sub_proj2_adv2_name_contact">
                            </div>

                            <!-- Upload File -->
                            <div class="form-group">
                                <label for="sub_file">Upload Abstract File<span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" id="sub_file" name="sub_file" required accept=".doc,.docx">
                                <span class="text-danger">Accept: .doc, .docx</span>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" disabled>Submit</button>
                            <script>
                                // check if all required fields are filled, enable submit button
                                $('input, textarea, select').on('input', function() {
                                    var empty = false;
                                    $('input, textarea, select').each(function() {
                                        //only check for required fields
                                        if ($(this).prop('required')) {
                                            if ($(this).val() == '') {
                                                empty = true;
                                            }
                                        }
                                    });
                                    if (empty) {
                                        $('button').prop('disabled', true);
                                    } else {
                                        $('button').prop('disabled', false);
                                    }
                                });

                                // $('#sub_email, #sub_co_email').on('input', function() {
                                //     var email = $(this).val();
                                //     if (email != '') {
                                //         if (validateEmail(email)) {
                                //             $(this).removeClass('is-invalid');
                                //             $(this).addClass('is-valid');
                                //         } else {
                                //             $(this).removeClass('is-valid');
                                //             $(this).addClass('is-invalid');
                                //         }
                                //     } else {
                                //         $(this).removeClass('is-valid');
                                //         $(this).removeClass('is-invalid');
                                //     }
                                // });
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