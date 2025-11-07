<?php 
    require_once '../static/function/connect.php';
    require_once '../static/function/mail/sender.php';
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    global $conn;
    global $db;
    //check if all required fields are filled
    if (
        empty($_POST['typeOfPaper']) ||
        empty($_POST['sub_fullName']) ||
        empty($_POST['sub_affiliation']) ||
        empty($_POST['sub_email']) ||

        empty($_POST['sub_co_fullName']) ||
        empty($_POST['sub_co_affiliation']) ||
        empty($_POST['sub_co_email']) ||

        empty($_POST['sub_title']) ||
        empty($_POST['sub_code']) ||

        empty($_FILES['sub_file'])
    ) {
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Please fill all required fields", SweetAlert::ERROR);
        header("Location: /submission/full-paper");
        die();
    }

    $currentedmyhms = date("YmdHis", time());

    $sub_typeOfPaper = xss_clean($_POST['typeOfPaper']);

    $sub_fullName = xss_clean($_POST['sub_fullName']);
    $sub_affiliation = xss_clean($_POST['sub_affiliation']);
    $sub_email = xss_clean($_POST['sub_email']);

    $sub_co_fullName = xss_clean($_POST['sub_co_fullName']);
    $sub_co_affiliation = xss_clean($_POST['sub_co_affiliation']);
    $sub_co_email = xss_clean($_POST['sub_co_email']);

    $sub_title = xss_clean($_POST['sub_title']);
    $sub_code = xss_clean($_POST['sub_code']);

    $sub_file = $_FILES['sub_file']['name'];
    $sub_file_tmp = $_FILES['sub_file']['tmp_name'];
    $sub_file_size = $_FILES['sub_file']['size'];
    $sub_file_ext = strtolower(pathinfo($sub_file, PATHINFO_EXTENSION));
    $sub_file_name = sanitizeFilename($sub_title."_".$currentedmyhms.'.'.$sub_file_ext);
    $sub_file_path = "../file/submission/paper-$sub_code-$sub_file_name";
    $sub_file_allowed = array('doc', 'docx');
    if ($_FILES['sub_file']['error'] != 0) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to upload file (File contains error: " . $phpFileUploadErrors[$_FILES['sub_file']['error']] . ")", SweetAlert::ERROR);
        header("Location: /submission/full-paper");
        die();
    }
    if (!is_dir("../file/submission/")) {
        make_directory("../file/submission/");
    }
    if (in_array($sub_file_ext, $sub_file_allowed)) {
        if (move_uploaded_file($sub_file_tmp, $sub_file_path)) {
            if ($stmt = $conn->prepare("INSERT INTO paper_submission (sub_typeOfPaper, sub_fullName, sub_affiliation, sub_email, sub_co_fullName, sub_co_affiliation, sub_co_email, sub_title, sub_code, sub_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param("ssssssssss", $sub_typeOfPaper, $sub_fullName, $sub_affiliation, $sub_email, $sub_co_fullName, $sub_co_affiliation, $sub_co_email, $sub_title, $sub_code, $sub_file_path);
                if (!$stmt->execute()) {
                    $conn->close();
                    $_SESSION['SweetAlert'] = new SweetAlert("Error", "Error: " . $conn->error, SweetAlert::ERROR);
                    header("Location: /submission/full-paper");
                    die();
                } else {
                    sendEmail(
                        $sub_email,
                        "TIChE2026 Full-paper Submit Confirmation - ID#$sub_code",
                        "https://tiche2026.ubu.ac.th/static/function/mail/template/submission_paper_success.html",
                        array("name"=>$sub_fullName, "submissionId"=>$sub_code, "date"=>date("Y-m-d H:i:s", time())));
                    sendEmail(
                        $sub_co_email,
                        "TIChE2026 Full-paper Submit Confirmation - ID#$sub_code",
                        "https://tiche2026.ubu.ac.th/static/function/mail/template/submission_paper_success.html",
                        array("name"=>$sub_co_fullName, "submissionId"=>$sub_code, "date"=>date("Y-m-d H:i:s", time())));
                    $conn->close();
                    $_SESSION['SweetAlert'] = new SweetAlert("Success", "Your submission has been recorded successfully! Submission ID #$sub_code", SweetAlert::SUCCESS);
                    header("Location: /submission/full-paper");
                    die();
                }
            }
        } else {
            $conn->close();
            $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to upload file (Unable to locate temporary file location: " . json_encode($_FILES['sub_file']) . ")", SweetAlert::ERROR);
            header("Location: /submission/full-paper");
            die();
        }
    } else {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "File type not allowed", SweetAlert::ERROR);
        header("Location: /submission/full-paper");
        die();
    }
    $conn->close();
    header("Location: /submission/full-paper");
    die();
?>