<?php require_once '../static/function/connect.php';
    $isAdmin = isAdmin();
?>
<table class="table table-hover table-sm mb-3" id="postTable">
    <thead>
        <tr>
            <th scope="col" class="font-weight-bold">ID</th>
            <th scope="col" class="font-weight-bold">หัวข้อ</th>
            <th scope="col" class="font-weight-bold">หมวดหมู่</th>
            <th scope="col" class="font-weight-bold">อัปเดตล่าสุด</th>
            <?php if ($isAdmin) {?><th scope="col" class="font-weight-bold"></th><?php } ?>
        </tr>
    </thead>
    <tbody>  
<?php
    $tag = isset($_GET['tags']) ? $_GET['tags'] : "";
    $category = isset($_GET['category']) ? $_GET['category'] : "~";
    
    $stmt = loadPostAll($category, $tag);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $properties = json_decode($row["property"], true);
                $properties_pin = isset($properties["pin"]) && ((int) $properties["pin"] == 1) ? '<span class="badge badge-md"><i class="fa-solid fa-thumbtack"></i></span> ' : ""; 
                $properties_link = "../post/" . $row['id']; //TODO later if post only has link, create a redirect link

                $properties_writer = getWriterDataFromID($properties['author'])->getName()."#".$properties['author']; ?>                        
        <tr onmouseup="window.location.href = '<?php echo "../post/".$row['id']; ?>'" style="cursor: pointer">
            <th scope="row"><a href="../post/<?php echo $row['id']; ?>" class="md"><?php echo $row['id'];?></a></th>
            <td><a href="../post/<?php echo $row['id']; ?>" class="md"><?php echo $properties_pin." ".$row['title']; ?></a></td>
            <td class="text-nowrap"><?php echo $properties['category']; ?></div></td>
            <td data-order="<?php echo $properties['upload_time']; ?>" class="text-nowrap"><?php echo fromThenToNow($properties['upload_time']); ?><?php if ($isAdmin) { ?><br><small>by <a href="../user/<?php echo $properties['author']; ?>" class="md"><?php echo getWriterDataFromID($properties['author'])->getName()."#".$properties['author']; ?></a></small><?php } ?></td>
            <?php if ($isAdmin) { ?>
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
            <?php } ?>
        </tr>
<?php } } ?>
    </tbody>
</table>
<script>
$(document).ready(function () {
    $('#postTable').DataTable({
        "lengthMenu": [
            [20, 50, 100, -1],
            [20, 50, 100, "ทั้งหมด"]
        ],
        "order": [[3, 'desc']],
        <?php if ($isAdmin) { ?>
        'columnDefs': [{
            'targets': [4], // column index (start from 0)
            'orderable': false // set orderable false for selected columns
        }],
        <?php } ?>
        "aoColumns": [{
                "sWidth": "8%"
            },
            {
                "sWidth": "<?php if ($isAdmin) { echo '45%'; } else { echo '65%'; } ?>"
            },
            {
                "sWidth": "14%"
            },
            {
                "sWidth": "13%"
            }<?php if ($isAdmin) { echo ",{\"sWidth\": \"20%\"}"; } ?>
        ]
    });
    $('.dataTables_length').addClass('bs-select');
});
</script>