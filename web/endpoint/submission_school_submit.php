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
        empty($_POST['sub_school']) ||
        empty($_POST['sub_province']) ||
        empty($_POST['sub_proj_name']) ||
        empty($_POST['sub_proj_abstract']) ||
        empty($_FILES['sub_file'])
    ) {
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Please fill all required fields", SweetAlert::ERROR);
        header("Location: /submission/school");
        die();
    }

    $id = latestIncrement($db["table"], "school_submission");

    $sub_file = $_FILES['sub_file']['name'];
    $sub_file_tmp = $_FILES['sub_file']['tmp_name'];
    $sub_file_size = $_FILES['sub_file']['size'];
    $sub_file_ext = strtolower(pathinfo($sub_file, PATHINFO_EXTENSION));
    $currentedmyhms = date("YmdHis");
    $sub_file_name = sanitizeFilename($currentedmyhms.'.'.$sub_file_ext);
    $sub_file_path = "../file/school-submission/abstract-$id-$sub_file_name";
    $sub_file_allowed = array('doc', 'docx');
    if ($_FILES['sub_file']['error'] != 0) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to upload file (File contains error: " . $phpFileUploadErrors[$_FILES['sub_file']['error']] . ")", SweetAlert::ERROR);
        header("Location: /submission/school");
        die();
    }
    if (!is_dir("../file/school-submission/")) {
        make_directory("../file/school-submission/");
    }
    if (!in_array($sub_file_ext, $sub_file_allowed)) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "File type not allowed (Accept: doc, docx)", SweetAlert::ERROR);
        header("Location: /submission/school");
        die();
    }
    if (!move_uploaded_file($sub_file_tmp, $sub_file_path)) {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to upload file (Unable to locate temporary file location: " . json_encode($_FILES['sub_file']) . ")", SweetAlert::ERROR);
        header("Location: /submission/school");
        die();
    }

    // Collect form data
    $formData = array(
        'School' => xss_clean($_POST['sub_school']),
        'Province' => xss_clean($_POST['sub_province']),
        'Project Name' => xss_clean($_POST['sub_proj_name']),
        'Project Abstract' => xss_clean($_POST['sub_proj_abstract']),
        'Name of Student 1 (in Thai)' => xss_clean($_POST['sub_proj_std1_name_th']),
        'Name of Student 1 (in English)' => xss_clean($_POST['sub_proj_std1_name_en']),
        'Email / Telephone Number of Student 1' => xss_clean($_POST['sub_proj_std1_name_contact']),
        'Name of Student 2 (in Thai)' => xss_clean($_POST['sub_proj_std2_name_th']),
        'Name of Student 2 (in English)' => xss_clean($_POST['sub_proj_std2_name_en']),
        'Email / Telephone Number of Student 2' => xss_clean($_POST['sub_proj_std2_name_contact']),
        'Name of Student 3 (in Thai)' => xss_clean($_POST['sub_proj_std3_name_th']),
        'Name of Student 3 (in English)' => xss_clean($_POST['sub_proj_std3_name_en']),
        'Email / Telephone Number of Student 3' => xss_clean($_POST['sub_proj_std3_name_contact']),
        'Name of Student 4 (in Thai)' => xss_clean($_POST['sub_proj_std4_name_th']),
        'Name of Student 4 (in English)' => xss_clean($_POST['sub_proj_std4_name_en']),
        'Email / Telephone Number of Student 4' => xss_clean($_POST['sub_proj_std4_name_contact']),
        'Name of Student 5 (in Thai)' => xss_clean($_POST['sub_proj_std5_name_th']),
        'Name of Student 5 (in English)' => xss_clean($_POST['sub_proj_std5_name_en']),
        'Email / Telephone Number of Student 5' => xss_clean($_POST['sub_proj_std5_name_contact']),
        'Name of Supervising Teacher 1 (in Thai)' => xss_clean($_POST['sub_proj_adv1_name_th']),
        'Name of Supervising Teacher 1 (in English)' => xss_clean($_POST['sub_proj_adv1_name_en']),
        'Email / Telephone Number of Supervising Teacher 1' => xss_clean($_POST['sub_proj_adv1_name_contact']),
        'Name of Supervising Teacher 2 (in Thai)' => xss_clean($_POST['sub_proj_adv2_name_th']),
        'Name of Supervising Teacher 2 (in English)' => xss_clean($_POST['sub_proj_adv2_name_en']),
        'Email / Telephone Number of Supervising Teacher 2' => xss_clean($_POST['sub_proj_adv2_name_contact']),
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
    if ($stmt = $conn->prepare("INSERT INTO school_submission (id, data) VALUES (?, ?)")) {
        $stmt->bind_param('is', $id, $data);
        if (!$stmt->execute()) {
            $conn->close();
            $_SESSION['SweetAlert'] = new SweetAlert("Error", "Error: " . $conn->error, SweetAlert::ERROR);
            header("Location: /submission/school");
            die();
        } else {
            $conn->close();
            $_SESSION['SweetAlert'] = new SweetAlert("Success", "Your submission has been recorded successfully! Submission ID #$id", SweetAlert::SUCCESS);
            header("Location: /submission/school");
            die();
        }
    } else {
        $conn->close();
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Failed to prepare statement", SweetAlert::ERROR);
        header("Location: /submission/school");
        die();
    }
?>