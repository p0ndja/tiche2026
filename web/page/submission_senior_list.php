<?php require_once '../static/function/connect.php'; ?>
<?php if (!isAdmin()) {
    header('Location: /');
    exit();
} ?>
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
                <h2 class="font-weight-bold">Senior Project Contest Submission</h2>
                <div class="card card-body table-responsive">
                    <table class="table table-sm table-hover w-100 d-block d-md-table text-nowrap" id="attachmentTable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Submit Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($stmt = $conn->prepare('SELECT * FROM senior_submission ORDER BY sub_timestamp DESC')) {
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                        <tr onmouseup="window.location.href = '/submission-senior/<?php echo $row['id']; ?>'" style="cursor: pointer">
                                        <td class="text-center"><a href="/submission-senior/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
                                        <td class="text-center"><?php echo $row['sub_timestamp']; ?></td>
                                        </tr>
                                    <?php }
                                    }
                                    $stmt->close();
                                }
                            ?>
                    </table>
                    <script>
                        $(document).ready(function () {
                            $('#attachmentTable').DataTable({
                                "order": [[0, "asc"]],
                                "pageLength": 25,
                                "lengthMenu": [25, 50, 100],
                                "language": {
                                    "lengthMenu": "Display _MENU_ records per page",
                                    "zeroRecords": "Nothing found",
                                    "info": "Showing page _PAGE_ of _PAGES_",
                                    "infoEmpty": "No records available",
                                    "infoFiltered": "(filtered from _MAX_ total records)",
                                    "search": "Search:"
                                }
                            });
                        });
        $('.dataTables_length').addClass('bs-select');
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>