<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <!-- jQuery DataTable -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <?php
        needAdmin();
        $category = isset($_GET['c']) ? $_GET['c'] : "~";
        $tag = isset($_GET['t']) ? $_GET['t'] : "";
    ?>
    <div class="container">
        <div class="mb-0 mt-3 d-flex justify-content-between">
            <div class="flex-grow-1">
                <?php echo generateCategoryTitle("Post Management - ".($category == "~" ? "โพสต์ทั้งหมด" : $category), $tag); ?>
            </div>
            <a href="../post/create?c=<?php echo urlencode($category);?>&t=<?php echo urlencode($tag); ?>" class="btn-floating btn-sm btn-info z-depth-0 ml-0 mr-1 mb-0"><i class='fas fa-plus'></i></a>
        </div>
        <div class="card card-body mb-3">
                <table class="table table-hover table-sm mb-3" id="postTable">
                    <thead>
                        <tr>
                            <th scope="col" class="font-weight-bold">ID</th>
                            <th scope="col" class="font-weight-bold">หัวข้อ</th>
                            <th scope="col" class="font-weight-bold">หมวดหมู่</th>
                            <th scope="col" class="font-weight-bold">อัปเดตล่าสุด</th>
                            <th scope="col" class="font-weight-bold"></th>
                        </tr>
                    </thead>
                    <tbody>        
                    <?php
                        $stmt = loadPostAll($category, $tag);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                            $properties = json_decode($row['property'], true);?>
                            <tr>
                                <th scope="row"><a href="../post/<?php echo $row['id']; ?>" class="md"><?php echo $row['id'];?></a></th>
                                <td><a href="../post/<?php echo $row['id']; ?>" class="md"><?php echo $row['title']; ?></a></td>
                                <td class="text-nowrap"><?php echo generateCategoryBadgeForced($properties['category']); ?></td>
                                <td data-order="<?php echo $properties['upload_time']; ?>" class="text-nowrap"><?php echo fromThenToNow($properties['upload_time']); ?><br><small>by <a href="../user/<?php echo $properties['author']; ?>" class="md"><?php echo getWriterDataFromID($properties['author'])->getName()."#".$properties['author']; ?></a></small></td>
                                <td class="text-nowrap">
                                    <a href="../post/edit-<?php echo $row['id']; ?>" class='z-depth-0 btn-sm btn-warning btn-floating'><i class='fa fa-edit'></i></a>
                                    <?php if ($properties['hide']) { ?>
                                    <a href="../endpoint/postIO.php?method=toggle&target=hide&id=<?php echo $row['id']; ?>" class='z-depth-0 btn-sm grey btn-floating'><i class='fa fa-eye-slash'></i></a>
                                    <?php } else { ?>
                                    <a href="../endpoint/postIO.php?method=toggle&target=hide&id=<?php echo $row['id']; ?>" class='z-depth-0 btn-sm btn-success btn-floating'><i class='fa fa-eye'></i></a>
                                    <?php } ?>
                                    <?php if ($properties['pin']) { ?>
                                    <a href="../endpoint/postIO.php?method=toggle&target=pin&id=<?php echo $row['id']; ?>" class='z-depth-0 btn-sm btn-success btn-floating'><i class='fas fa-thumbtack'></i></a>
                                    <?php } else { ?>
                                    <a href="../endpoint/postIO.php?method=toggle&target=pin&id=<?php echo $row['id']; ?>" class='z-depth-0 btn-sm grey btn-floating'><span class="fa-stack"><i class="fas fa-thumbtack fa-stack-1x"></i><i class="fas fa-slash fa-stack-2x"></i></span></a>
                                    <?php } ?>
                                    <?php if ($properties['allowDelete'] == true) { ?>
                                    <a class='z-depth-0 btn-sm btn-danger btn-floating'
                                        onclick='swal({title: "ลบข่าวหรือไม่ ?",text: "หลังจากที่ลบแล้ว ข่าวนี้จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/postIO.php?method=delete&id=<?php echo $row["id"]; ?>&category=<?php echo $properties["category"]; ?>";}});'>
                                        <i class="fas fa-trash-alt"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php }
                        } ?>
                    </tbody>
                </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#postTable').DataTable({
                "lengthMenu": [
                    [15, 30, 100, -1],
                    [15, 30, 100, "ทั้งหมด"]
                ],
                "order": [[3, 'desc']],
                'columnDefs': [{
                    'targets': [4], // column index (start from 0)
                    'orderable': false // set orderable false for selected columns
                }],
                "aoColumns": [{
                        "sWidth": "5%"
                    },
                    {
                        "sWidth": "48%"
                    },
                    {
                        "sWidth": "14%"
                    },
                    {
                        "sWidth": "13%"
                    },
                    {
                        "sWidth": "20%"
                    }

                ]
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>

</html>