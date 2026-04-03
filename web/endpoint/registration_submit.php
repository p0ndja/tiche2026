<?php 
    require_once '../static/function/connect.php';
    require_once '../static/function/mail/sender.php';
    needLogin();

    $userId = getUser()->getID();

    // header("Location: /registration/"); # hard redirect to registration page

    global $conn;
    global $db;
    //check if all required fields are filled

    if (isset($_POST['reg_category']) && !in_array(xss_clean($_POST['reg_category']), array("Presenter", "Participant", "Senior", "Student"))) {
        $_SESSION['SweetAlert'] = new SweetAlert("Error", "Invalid category", SweetAlert::ERROR);
        header("Location: /registration/");
        die();
    } else {
        $reg_category = xss_clean($_POST['reg_category']);
        if ($reg_category == "Presenter" || $reg_category == "Participant") {
            
            if (
                empty($_POST['reg_fullName']) ||
                empty($_POST['reg_affiliation']) ||
                empty($_POST['reg_email']) ||
                empty($_POST['reg_phone']) ||
                empty($_POST['reg_category'])
                ) {
                $_SESSION['SweetAlert'] = new SweetAlert("Error", "Please fill all required fields", SweetAlert::ERROR);
                header("Location: /registration/");
                die();
            }

            // if date is within 31 mar 2026, 23:59:59, the price is 5000 for early bird presentor, 3500 for early bird participant
            // else the price is 6000 for presentor, 4000 for participant
            $price = 6000;
            $reg_category = xss_clean($_POST['reg_category']);

            $earlyBird = strtotime("2026-04-01 00:00:05") > time();
            if ($earlyBird) {
                if ($reg_category == "Presenter") {
                    $price = 5000;
                } else if ($reg_category == "Participant") {
                    $price = 3500;
                }
            } else {
                if ($reg_category == "Presenter") {
                    $price = 6000;
                } else if ($reg_category == "Participant") {
                    $price = 4000;
                }
            }

            $id = latestIncrement($db["table"],"registration");

            $reg_fullName = xss_clean($_POST['reg_fullName']);
            $reg_affiliation = xss_clean($_POST['reg_affiliation']);
            $reg_email = xss_clean($_POST['reg_email']);
            $reg_phone = xss_clean($_POST['reg_phone']);
            $reg_code = xss_clean($_POST['reg_code']);
            $reg_note = xss_clean($_POST['reg_note']);

            if ($stmt = $conn->prepare("INSERT INTO registration (reg_fullName, reg_affiliation, reg_email, reg_phone, reg_code, reg_category, reg_note, reg_payment_amount, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param('sssssssii', $reg_fullName, $reg_affiliation, $reg_email, $reg_phone, $reg_code, $reg_category, $reg_note, $price, $userId);
                if (!$stmt->execute()) {
                    $conn->close();
                    $_SESSION['SweetAlert'] = new SweetAlert("Error", "Error: " . $conn->error, SweetAlert::ERROR);
                    header("Location: /registration/");
                    die();
                } else {
                    sendEmail(
                        $reg_email,
                        "TIChE 2026 Registration - $reg_fullName",
                        "https://tiche2026.ubu.ac.th/static/function/mail/template/registration_payment.html",
                        array("name"=>$reg_fullName, "date"=>date("Y-m-d H:i:s", time()), "id"=>sprintf("%06d", $id)));
                    $conn->close();
                    // $_SESSION['SweetAlert'] = new SweetAlert("Success", "Your registration has been recorded successfully! registration ID #$id", SweetAlert::SUCCESS);
                    $_SESSION['registration_id'] = $id;
                    header("Location: /registration/result");
                    die();
                }
            }
        } else if ($reg_category == "Senior") {
            if (
                empty($_POST['reg_code']) ||
                empty($_POST['reg_seniorProject_projectName']) ||
                empty($_POST['reg_seniorProject_primaryContactName']) ||
                empty($_POST['reg_seniorProject_primaryContactEmail'])
                ) {
                $_SESSION['SweetAlert'] = new SweetAlert("Error", "Please fill all required fields", SweetAlert::ERROR);
                header("Location: /registration/");
                die();
            }

            $price = 0;
            
            $id = latestIncrement($db["table"],"registration");

            $reg_fullName = xss_clean($_POST['reg_seniorProject_primaryContactName']);
            $reg_affiliation = "";
            $reg_email = xss_clean($_POST['reg_seniorProject_primaryContactEmail']);
            $reg_phone = "";
            $reg_code = xss_clean($_POST['reg_code']);
            $reg_note = xss_clean($_POST['reg_seniorProject_projectName']);

            if ($stmt = $conn->prepare("INSERT INTO registration (reg_fullName, reg_affiliation, reg_email, reg_phone, reg_code, reg_category, reg_note, reg_payment_amount, reg_payment_timestamp, reg_payment_paid, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), 1, ?)")) {
                $stmt->bind_param('sssssssii', $reg_fullName, $reg_affiliation, $reg_email, $reg_phone, $reg_code, $reg_category, $reg_note, $price, $userId);
                if (!$stmt->execute()) {
                    $conn->close();
                    $_SESSION['SweetAlert'] = new SweetAlert("Error", "Error: " . $conn->error, SweetAlert::ERROR);
                    header("Location: /registration/");
                    die();
                } else {
                    sendEmail(
                        $reg_email,
                        "TIChE 2026 Registration - $reg_fullName",
                        "https://tiche2026.ubu.ac.th/static/function/mail/template/registration_success.html",
                        array("name"=>$reg_fullName, "date"=>date("Y-m-d H:i:s", time()), "id"=>sprintf("%06d", $id)));
                    $_SESSION['SweetAlert'] = new SweetAlert("Success", "Your registration has been recorded successfully! registration ID #$id", SweetAlert::SUCCESS);
                    header("Location: /registration/$id");
                    die();
                }
            }
        } else {
            // To be implemented for student category
        }
    }
    $conn->close();
    header("Location: /registration/");
    die();
?>