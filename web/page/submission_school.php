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
                <h3 class="font-weight-bold">TIChE HIGH SCHOOL PROJECT CONTEST 2025</h3>
                <hr>
                <p>TIChE High School Project Contest 2025 is a highlight of TIChE2026, providing a dedicated platform to inspire young scientific minds at the high school level. This <b>poster competition</b> fosters curiosity, creativity, and innovation in chemical sciences and engineering, encouraging students to showcase their research and apply their scientific knowledge in impactful ways.</p>
                <p>
                <b>Project Requirements:</b>
                <ul>
                    <li>The project should align with research in chemical engineering, chemical science, or applied chemistry and demonstrate the application of scientific knowledge in research development.</li>
                    <li>The project should showcase innovation or a development approach that utilizes scientific knowledge for further advancement and societal benefit.</li>
                </ul>
                </p>
                <p>
                <b>Project Submission:</b>
                <ul>
                <li>A total of 40 projects will be accepted for the competition.</li>
                <li>School is responsible for selecting the students and project title for submission. Each project team should consist of no more than 3 students.</li>
                <li>All projects must prepare an A0-size English poster and deliver a Thai-language presentation to the committee.</li>
                </ul>
                </p>
                <p>
                <b>Submission Deadlines and Competition Date:</b>
                <ul>
                <li>Schools must submit the student names, project title, supervising teacher’s name, and project description (in English, not exceeding 250 words) by <b>April 30, 2025.</b></li>
                <li>Announcement of selected projects for the competition will be made by <b>May 7, 2025.</b></li>
                <li>TIChE High School Project Contest 2025 will take place on <b>May 21, 2025</b>, at Dusit Thani Hotel, Pattaya, Chonburi.</li>
                </ul>
                </p>
                <p><b>Additional Information (in Thai):</b></p>
                <p>
                    Participants can access important materials, including competition guidelines, evaluation criteria, and event schedules. These materials will help ensure that high school projects meet the required standards and that all participants are well-prepared for the competition.
                </p>
                <p>
                    <b>Download materials here:</b> <a href="/static/asset/upload/TIChE%20High%20School%20Project%20Contest%202025.pdf" target="_blank">TIChE High School Project Contest 2025</a><br>
                    <b>Download template here:</b> <a href="/static/asset/upload/TIChE2026%20Abstract%20Template.docx" target="_blank">Abstract Template</a>
                </p>

                <h3 class="font-weight-bold mt-5">ONLINE SUBMISSION</h3>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <form action="../endpoint/submission_school_submit.php" method="post" enctype="multipart/form-data">
                            <small class="text-danger">* Required</small>
                            <div class="form-group">
                                <label for="sub_school">School<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_school" name="sub_school" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_province">Province<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_province" name="sub_province" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_name">Project Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sub_proj_name" name="sub_proj_name" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_abstract">Project Abstract (Maximum 250 words)<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="sub_proj_abstract" name="sub_proj_abstract" required rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std1_name_th">Name of Student 1 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_std1_name_th" name="sub_proj_std1_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std1_name_en">Name of Student 1 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_std1_name_en" name="sub_proj_std1_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std1_name_contact">Email / Telephone Number of Student 1</label>
                                <input type="text" class="form-control" id="sub_proj_std1_name_contact" name="sub_proj_std1_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std2_name_th">Name of Student 2 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_std2_name_th" name="sub_proj_std2_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std2_name_en">Name of Student 2 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_std2_name_en" name="sub_proj_std2_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std2_name_contact">Email / Telephone Number of Student 2</label>
                                <input type="text" class="form-control" id="sub_proj_std2_name_contact" name="sub_proj_std2_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std3_name_th">Name of Student 3 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_std3_name_th" name="sub_proj_std3_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std3_name_en">Name of Student 3 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_std3_name_en" name="sub_proj_std3_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std3_name_contact">Email / Telephone Number of Student 3</label>
                                <input type="text" class="form-control" id="sub_proj_std3_name_contact" name="sub_proj_std3_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std4_name_th">Name of Student 4 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_std4_name_th" name="sub_proj_std4_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std4_name_en">Name of Student 4 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_std4_name_en" name="sub_proj_std4_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std4_name_contact">Email / Telephone Number of Student 4</label>
                                <input type="text" class="form-control" id="sub_proj_std4_name_contact" name="sub_proj_std4_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std5_name_th">Name of Student 5 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_std5_name_th" name="sub_proj_std5_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std5_name_en">Name of Student 5 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_std5_name_en" name="sub_proj_std5_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_std5_name_contact">Email / Telephone Number of Student 5</label>
                                <input type="text" class="form-control" id="sub_proj_std5_name_contact" name="sub_proj_std5_name_contact">
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="sub_proj_adv1_name_th">Name of Supervising Teacher 1 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_adv1_name_th" name="sub_proj_adv1_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_adv1_name_en">Name of Supervising Teacher 1 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_adv1_name_en" name="sub_proj_adv1_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_adv1_name_contact">Email / Telephone Number of Supervising Teacher 1</label>
                                <input type="text" class="form-control" id="sub_proj_adv1_name_contact" name="sub_proj_adv1_name_contact">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_adv2_name_th">Name of Supervising Teacher 2 (in Thai)</label>
                                <input type="text" class="form-control" id="sub_proj_adv2_name_th" name="sub_proj_adv2_name_th">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_adv2_name_en">Name of Supervising Teacher 2 (in English)</label>
                                <input type="text" class="form-control" id="sub_proj_adv2_name_en" name="sub_proj_adv2_name_en">
                            </div>
                            <div class="form-group">
                                <label for="sub_proj_adv2_name_contact">Email / Telephone Number of Supervising Teacher 2</label>
                                <input type="text" class="form-control" id="sub_proj_adv2_name_contact" name="sub_proj_adv2_name_contact">
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