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
                <h2 class="font-weight-bold">Registration System</h2>
                <div class="card card-body table-responsive">
                    <table class="table table-sm table-hover w-100 d-block d-md-table text-nowrap" id="attachmentTable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="">Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($stmt = $conn->prepare('SELECT `reg_id` as `id`, `reg_fullName` as `author`, `reg_code` as `abstract`, `reg_timestamp` as `submitDate`, `reg_category` as `type`, `reg_payment_amount` as `payment`, `reg_payment_timestamp` as `paid` FROM registration ORDER BY reg_timestamp DESC')) {
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                        <tr onmouseup="window.location.href = '/registration/<?php echo $row['id']; ?>'" style="cursor: pointer">
                                        <td><a href="/registration/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
                                        <td><a href="/registration/<?php echo $row['id']; ?>"><?php echo $row['author']; ?></a></td>
                                        <td><a href="/registration/<?php echo $row['id']; ?>"><?php echo $row['type']; ?> <?php if ($row['payment'] == 3000 || $row['payment'] == 5000) echo "(Early)"; ?> <?php if ($row['type'] == "Presenter") echo " #<b>" . $row['abstract'] . "</b>"; ?></a></td>
                                        <td class="text-center"><?php echo $row['submitDate']; ?></td>
                                        <td class="text-left"><?php echo empty($row['paid']) ? "<span class='text-danger'>Unpaid</span>" : "<span>".$row['paid']."</span>"; ?></td>
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
                                // "aoColumns": [
                                //     {
                                //         "sWidth": "5%"
                                //     },
                                //     {
                                //         "sWidth": "50%"
                                //     },
                                //     {
                                //         "sWidth": "15%"
                                //     },
                                //     {
                                //         "sWidth": "20%"
                                //     }
                                // ],
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