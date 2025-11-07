<?php
    require_once '../static/function/connect.php';
    if (!isAdmin()) {
        header('Location: /');
        exit();
    }

    $submission_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM submission WHERE sub_id = ?");
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
                        <h5 class="font-weight-bold mt-3 mb-0">Author Information</h5>
                        <hr>
                        <div class="form-group">
                            <label for="sub_fullName">Presenter Name</label>
                            <input type="text" class="form-control" id="sub_fullName" name="sub_fullName" readonly value="<?php echo $rrr['sub_fullName']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_affiliation">Affiliation</label>
                            <input type="text" class="form-control" id="sub_affiliation" name="sub_affiliation" readonly value="<?php echo $rrr['sub_affiliation']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_email">Email</label>
                            <input type="email" class="form-control" id="sub_email" name="sub_email" readonly value="<?php echo $rrr['sub_email']; ?>">
                        </div>
                        <h5 class="font-weight-bold mt-5 mb-0">Corresponding Author Information</h5>
                        <hr>
                        <div class="form-group">
                            <label for="sub_co_fullName">Corresponding Author Name</label>
                            <input type="text" class="form-control" id="sub_co_fullName" name="sub_co_fullName" readonly value="<?php echo $rrr['sub_co_fullName']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_co_affiliation">Affiliation</label>
                            <input type="text" class="form-control" id="sub_co_affiliation" name="sub_co_affiliation" readonly value="<?php echo $rrr['sub_co_affiliation']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_co_email">Email</label>
                            <input type="email" class="form-control" id="sub_co_email" name="sub_co_email" readonly value="<?php echo $rrr['sub_co_email']; ?>">
                        </div>
                        <h5 class="font-weight-bold mt-5 mb-0">Abstract Information</h5>
                        <hr>
                        <div class="form-group">
                            <label for="sub_title">Title</label>
                            <input type="text" class="form-control" id="sub_title" name="sub_title" readonly value="<?php echo $rrr['sub_title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_abstract">Abstract</label>
                            <textarea class="form-control" id="sub_abstract" name="sub_abstract" readonly rows="5"><?php echo $rrr['sub_abstract']; ?></textarea>
                        </div>
                        <!-- Category -->
                        <div class="form-group">
                            <label for="sub_category">Category</label>
                            <select class="form-control" id="sub_category" name="sub_category" disabled>
                                <option value="Catalysis and Reaction Engineering">Catalysis and Reaction Engineering</option>
                                <option value="Sustainable and Green Chemistry">Sustainable and Green Chemistry</option>
                                <option value="Advanced Materials and Nanotechnology">Advanced Materials and Nanotechnology</option>
                                <option value="Biochemical and Environmental Engineering">Biochemical and Environmental Engineering</option>
                                <option value="Process Engineering and Digital Technologies">Process Engineering and Digital Technologies</option>
                                <option value="Energy and Fuels">Energy and Fuels</option>
                                <option value="Industrial Applications and Case Studies">Industrial Applications and Case Studies</option>
                            </select>
                            <script>$(`#sub_category`).val(`<?php echo $rrr['sub_category']; ?>`);</script>
                        </div>
                        <div class="form-group">
                            <label for="sub_type">Type</label>
                            <select class="form-control" id="sub_type" name="sub_type" disabled>
                                <option value="Oral">Oral</option>
                                <option value="Poster">Poster</option>
                            </select>
                            <script>$(`#sub_type`).val(`<?php echo $rrr['sub_type']; ?>`);</script>
                        </div>
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