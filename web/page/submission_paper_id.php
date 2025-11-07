<?php
    require_once '../static/function/connect.php';
    if (!isAdmin()) {
        header('Location: /');
        exit();
    }

    $submission_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM paper_submission WHERE sub_id = ?");
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
                <h2 class="font-weight-bold">Full-paper Submission ID: <?php echo $submission_id; ?> (Code: <?php echo $rrr['sub_code']; ?>)</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="font-weight-bold mt-3 mb-0">Type of Full Paper</h5>
                        <hr>
                        <div class="form-group">
                            <label for="typeOfPaper">Type of Paper <span class="text-danger">*</span></label>
                            <select id="typeOfPaper" name="typeOfPaper" class="form-control" required>
                                <option value="" disabled selected>Select Type of Paper</option>
                                <option value="TIChE2026 Conference Proceeding">TIChE2026 Conference Proceeding</option>
                                <option value="Applied Environmental Research">Applied Environmental Research</option>
                                <option value="Asia-Pacific Journal of Science and Technology">Asia-Pacific Journal of Science and Technology</option>
                            </select>
                        </div>
                        <script>
                            document.getElementById('typeOfPaper').value = "<?php echo $rrr['sub_typeOfPaper']; ?>";
                        </script>
                        <h5 class="font-weight-bold mt-3 mb-0">Paper Information</h5>
                        <hr>
                        <div class="form-group">
                            <label for="sub_code">Abstract Code</label>
                            <input type="text" class="form-control" id="sub_code" name="sub_code" readonly value="<?php echo $rrr['sub_code']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Title of Full Paper</label>
                            <input type="text" class="form-control" id="sub_title" name="sub_title" readonly value="<?php echo $rrr['sub_title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_fullName">First Author Name</label>
                            <input type="text" class="form-control" id="sub_fullName" name="sub_fullName" readonly value="<?php echo $rrr['sub_fullName']; ?>">
                        </div>
                        <div class="form-group d-none">
                            <label for="sub_affiliation">Affiliation</label>
                            <input type="text" class="form-control" id="sub_affiliation" name="sub_affiliation" readonly value="<?php echo $rrr['sub_affiliation']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_email">Email of First Author</label>
                            <input type="email" class="form-control" id="sub_email" name="sub_email" readonly value="<?php echo $rrr['sub_email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_co_fullName">Corresponding Author</label>
                            <input type="text" class="form-control" id="sub_co_fullName" name="sub_co_fullName" readonly value="<?php echo $rrr['sub_co_fullName']; ?>">
                        </div>
                        <div class="form-group d-none">
                            <label for="sub_co_affiliation">Affiliation</label>
                            <input type="text" class="form-control" id="sub_co_affiliation" name="sub_co_affiliation" readonly value="<?php echo $rrr['sub_co_affiliation']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_co_email">Email of Corresponding Author</label>
                            <input type="email" class="form-control" id="sub_co_email" name="sub_co_email" readonly value="<?php echo $rrr['sub_co_email']; ?>">
                        </div>
                        <hr>
                        <!-- Upload File -->
                        <div class="form-group">
                            <label for="sub_file">File</label>
                            <ul>
                                <li><a href="<?php echo $rrr['sub_file']; ?>" target="_blank"><?php echo str_replace("../file/submission/","",$rrr['sub_file']); ?></a></li>
                            </ul>
                        </div>
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