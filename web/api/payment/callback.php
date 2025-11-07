<?php
include 'config.php';
global $accessKey;

function xss_clean($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['status']) && isset($_GET['order'])) {
    $status = xss_clean($_GET['status']);
    $order = xss_clean($_GET['order']);
    if ($status == "done") {
        header("Location: /registration/result");
        die();
    }
}
header("Location: /registration/");
?>