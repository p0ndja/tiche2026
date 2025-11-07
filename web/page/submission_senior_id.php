<?php
    require_once '../static/function/connect.php';
    if (!isAdmin()) {
        header('Location: /');
        exit();
    }

    $submission_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM senior_submission WHERE id = ?");
    $stmt->bind_param("s", $submission_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        header('Location: /');
        exit();
    }
    $rrr = null;
    while ($r = $result->fetch_assoc()) {
        $rrr = $r;
    }
    $stmt->close();
?>
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
            <div class="d-none">
                <?php require_once '../static/function/sidetab.php'; ?>
            </div>
            <div class="col-12">
                <a onclick="window.history.back();" class="float-left"><i class="fas fa-arrow-left"></i> Back</a><br>
                <h2 class="font-weight-bold">Submission ID: <?php echo $submission_id; ?></h2>
                <div class="card">
                    <div class="card-body">
                        <?php echo str_replace("\r\n", "<br>", $rrr['data']); ?>
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