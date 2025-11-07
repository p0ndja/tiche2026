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

    // Check if all required fields are filled
    if (
        empty($_POST['sub_university']) ||
        empty($_POST['sub_department']) ||
        empty($_POST['sub_proj1_name']) ||
        empty($_POST['sub_proj1_abstract']) ||
        empty($_POST['sub_proj2_name']) ||
        empty($_POST['sub_proj2_abstract']) ||
        empty($_FILES['sub_file'])
    ) {
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Please fill all required fields", SweetAlert::ERROR);
        header("Location: /submission/senior");
        die();
    }

    $id = latestIncrement($db["table"], "senior_submission");

    $sub_file = $_FILES['sub_file']['name'];
    $sub_file_tmp = $_FILES['sub_file']['tmp_name'];
    $sub_file_size = $_FILES['sub_file']['size'];
    $sub_file_ext = strtolower(pathinfo($sub_file, PATHINFO_EXTENSION));
    $currentedmyhms = date("YmdHis");
    $sub_file_name = sanitizeFilename($currentedmyhms.'.'.$sub_file_ext);
    $sub_file_path = "../file/senior-submission/abstract-$id-$sub_file_name";
    $sub_file_allowed = array('doc', 'docx');
    if ($_FILES['sub_file']['error'] != 0) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to upload file (File contains error: " . $phpFileUploadErrors[$_FILES['sub_file']['error']] . ")", SweetAlert::ERROR);
        header("Location: /submission/senior");
        die();
    }
    if (!is_dir("../file/senior-submission/")) {
        make_directory("../file/senior-submission/");
    }
    if (!in_array($sub_file_ext, $sub_file_allowed)) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "File type not allowed (Accept: doc, docx)", SweetAlert::ERROR);
        header("Location: /submission/senior");
        die();
    }
    if (!move_uploaded_file($sub_file_tmp, $sub_file_path)) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to upload file (Unable to locate temporary file location: " . json_encode($_FILES['sub_file']) . ")", SweetAlert::ERROR);
        header("Location: /submission/senior");
        die();
    }

    // Collect form data
    $formData = array(
        'University' => xss_clean($_POST['sub_university']),
        'Department' => xss_clean($_POST['sub_department']),
        'Name of Faculty Member (Serving as Committee)' => xss_clean($_POST['sub_facultyMember']),
        'Name of Project 1' => xss_clean($_POST['sub_proj1_name']),
        'Abstract of Project 1' => xss_clean($_POST['sub_proj1_abstract']),
        'Name of Student 1 (in Thai) - Project 1' => xss_clean($_POST['sub_proj1_std1_name_th']),
        'Name of Student 1 (in English) - Project 1' => xss_clean($_POST['sub_proj1_std1_name_en']),
        'Email / Telephone Number of Student 1 - Project 1' => xss_clean($_POST['sub_proj1_std1_name_contact']),
        'Name of Student 2 (in Thai) - Project 1' => xss_clean($_POST['sub_proj1_std2_name_th']),
        'Name of Student 2 (in English) - Project 1' => xss_clean($_POST['sub_proj1_std2_name_en']),
        'Email / Telephone Number of Student 2 - Project 1' => xss_clean($_POST['sub_proj1_std2_name_contact']),
        'Name of Advisor 1 (in Thai) - Project 1' => xss_clean($_POST['sub_proj1_adv1_name_th']),
        'Name of Advisor 1 (in English) - Project 1' => xss_clean($_POST['sub_proj1_adv1_name_en']),
        'Email / Telephone Number of Advisor 1 - Project 1' => xss_clean($_POST['sub_proj1_adv1_name_contact']),
        'Name of Advisor 2 (in Thai) - Project 1' => xss_clean($_POST['sub_proj1_adv2_name_th']),
        'Name of Advisor 2 (in English) - Project 1' => xss_clean($_POST['sub_proj1_adv2_name_en']),
        'Email / Telephone Number of Advisor 2 - Project 1' => xss_clean($_POST['sub_proj1_adv2_name_contact']),
        'Name of Project 2' => xss_clean($_POST['sub_proj2_name']),
        'Abstract of Project 2' => xss_clean($_POST['sub_proj2_abstract']),
        'Name of Student 1 (in Thai) - Project 2' => xss_clean($_POST['sub_proj2_std1_name_th']),
        'Name of Student 1 (in English) - Project 2' => xss_clean($_POST['sub_proj2_std1_name_en']),
        'Email / Telephone Number of Student 1 - Project 2' => xss_clean($_POST['sub_proj2_std1_name_contact']),
        'Name of Student 2 (in Thai) - Project 2' => xss_clean($_POST['sub_proj2_std2_name_th']),
        'Name of Student 2 (in English) - Project 2' => xss_clean($_POST['sub_proj2_std2_name_en']),
        'Email / Telephone Number of Student 2 - Project 2' => xss_clean($_POST['sub_proj2_std2_name_contact']),
        'Name of Advisor 1 (in Thai) - Project 2' => xss_clean($_POST['sub_proj2_adv1_name_th']),
        'Name of Advisor 1 (in English) - Project 2' => xss_clean($_POST['sub_proj2_adv1_name_en']),
        'Email / Telephone Number of Advisor 1 - Project 2' => xss_clean($_POST['sub_proj2_adv1_name_contact']),
        'Name of Advisor 2 (in Thai) - Project 2' => xss_clean($_POST['sub_proj2_adv2_name_th']),
        'Name of Advisor 2 (in English) - Project 2' => xss_clean($_POST['sub_proj2_adv2_name_en']),
        'Email / Telephone Number of Advisor 2 - Project 2' => xss_clean($_POST['sub_proj2_adv2_name_contact']),
        "Abstract File" => "<a href='".str_replace("../","/",$sub_file_path)."'>$sub_file_name</a>"
    );

    $data = implode("\n", array_map(
        function ($v, $k) {
            return sprintf("%s: %s\r\n", $k, $v);
        },
        $formData,
        array_keys($formData)
    ));
    
    // Insert data into the database
    if ($stmt = $conn->prepare("INSERT INTO senior_submission (id, data) VALUES (?, ?)")) {
        $stmt->bind_param('is', $id, $data);
        if (!$stmt->execute()) {
            $conn->close();
            $_SESSION['SweetAlert'] = new SweetAlert("Error", "Error: " . $conn->error, SweetAlert::ERROR);
            header("Location: /submission/senior");
            die();
        } else {
            $conn->close();
            $_SESSION['SweetAlert'] = new SweetAlert("Success", "Your submission has been recorded successfully! Submission ID #$id", SweetAlert::SUCCESS);
            header("Location: /submission/senior");
            die();
        }
    } else {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to prepare statement", SweetAlert::ERROR);
        header("Location: /submission/senior");
        die();
    }
?>