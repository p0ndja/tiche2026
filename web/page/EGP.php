<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
        <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.0/css/searchPanes.dataTables.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css"/>
        <style>
            .select-dropdown { color: white !important; }
            .caret { color: white !important; }
            a:hover {text-decoration: underline;}
        </style>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <div class="container-fluid font-sarabun">
            <div class="mt-3 mb-5 text-center">
                <h1 class="font-weight-bold font-sarabun">เผยแพร่ข่าวสารการจัดซื้อจัดจ้างภาครัฐ e-GP</h1>
                <h5 class="text-blue font-sarabun">ฝ่ายเภสัชกรรม โรงพยาบาลศรีนครินทร์ คณะแพทยศาสตร์ มหาวิทยาลัยขอนแก่น</h5>
                <small class="mt-3 font-weight-light text-muted">ข้อมูลทั้งหมดนำมาจาก <a href="http://www.gprocurement.go.th/new_index.html">ระบบการจัดซื้อจัดจ้างภาครัฐ (gprocurement.go.th)</a> ด้วยระบบอัตโนมัติ</small>
            </div>
            <div class="card bg-md card-body">
                <form method="POST" id="eGPSearchField">
                    <div class="row">
                        <div class="col-12 col-md-2 mt-0 mb-0">
                            <select class="mdb-select md-form colorful-select dropdown-success mt-0 mb-0 " multiple searchable="ค้นหา🔎" id="eGPYear" name="eGPYear[]">
                                <option value="" disabled selected>ปีงบประมาณ</option>
                                <?php for ($i = (int) date("Y", time())+543; $i >= 2565 ; $i--) { ?>
                                <option value="<?php echo $i; ?>">ปีงบประมาณ <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 mt-0 mb-0">
                            <select class="mdb-select md-form colorful-select dropdown-success mt-0 mb-0" multiple searchable="ค้นหา🔎" id="eGPType" name="eGPType[]">
                                <option value="" disabled selected>ประเภท</option>
                                <option value="P0">แผนการจัดซื้อจัดจ้าง</option>
                                <option value="15">ประกาศราคากลาง</option>
                                <option value="B0">ร่างเอกสาร</option>
                                <option value="D0">ประกาศเชิญชวน</option>
                                <option value="D1">ยกเลิกประกาศเชิญชวน</option>
                                <option value="D2">เปลี่ยนแปลงประกาศเชิญชวน</option>
                                <option value="W0">ประกาศรายชื่อผู้ชนะ</option>
                                <option value="W1">ยกเลิกประกาศรายชื่อผู้ชนะ</option>
                                <option value="W2">เปลี่ยนแปลงประกาศรายชื่อผู้ชนะ</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 mt-0 mb-0">
                            <select class="mdb-select md-form colorful-select dropdown-success mt-0 mb-0" multiple searchable="ค้นหา🔎" id="eGPMethod" name="eGPMethod[]" >
                                <option value="" disabled selected>วิธีการจัดหา</option>
                                <option value="15">e-market</option>
                                <option value="16">e-bidding</option>
                                <option value="18">คัดเลือก</option>
                                <option value="19">เฉพาะเจาะจง</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mt-0 mb-0">
                            <div class="d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="md-form mt-0 mb-0">
                                        <input type="text" id="eGPSearch" name="eGPSearch" class="form-control mt-0 mb-0 text-white" value=""/>
                                        <label class="form-label mt-0 mb-0 text-white" for="eGPSearch">คำค้น</label>
                                    </div>
                                </div>
                                <a class="btn-floating btn-primary btn-sm mt-0 mb-0 mr-1 ml-0" onclick="$('#eGPSearchField').submit();" data-toggle="tooltip" data-placement="top" title="ค้นหา"><i class="fa-solid fa-magnifying-glass"></i></a>
                                <a class="btn-floating btn-warning btn-sm mt-0 mb-0 mr-1 ml-0" href="" data-toggle="tooltip" data-placement="top" title="รีเซ็ต"><i class="fa-solid fa-arrows-rotate"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card card-body mt-3 mb-3">
                <div class="table-responsive">
                    <table class="table table-hover w-100 d-block d-md-table cell-border order-column" id="EGPTable">
                        <thead>
                            <tr>
                                <th scope="col" class="font-weight-bold text-right">ID</th>
                                <th scope="col" class="font-weight-bold">Title</th>
                                <th scope="col" class="font-weight-bold text-center">Date</th>
                                <th class="d-none"></th>
                                <th class="d-none"></th>
                                <th class="d-none"></th>
                                <!--th scope="col" class="font-weight-bold"></th-->
                            </tr>
                        </thead>
                        <tbody class="text-nowrap">
                            <?php
                                function typeTitle($type, $pill = true, $shadow = true) {
                                    $pill = ($pill) ? "badge-pill":"";
                                    $shadow = ($shadow) ? "":"z-depth-0";
                                    $txt = $type;
                                    $color = "default";
                                    switch($type) {
                                        case "P0":
                                            $txt = "แผนการจัดซื้อจัดจ้าง";
                                            $color = "secondary";
                                            break;
                                        case "15":
                                            $txt = "ประกาศราคากลาง";
                                            $color = "warning";
                                            break;
                                        case "B0":
                                            $txt = "ร่างเอกสาร";
                                            $color = "primary";
                                            break;
                                        case "D0":
                                            $txt = "ประกาศเชิญชวน";
                                            $color = "info";
                                            break;
                                        case "W0":
                                            $txt = "ประกาศรายชื่อผู้ชนะ";
                                            $color = "success";
                                            break;
                                        case "W1":
                                            $txt = "ยกเลิกประกาศรายชื่อผู้ชนะ";
                                            $color = "danger";
                                            break;
                                        case "W2":
                                            $txt = "เปลี่ยนแปลงประกาศรายชื่อผู้ชนะ";
                                            $color = "warning";
                                            break;
                                        case "D1":
                                            $txt = "ยกเลิกประกาศเชิญชวน";
                                            $color = "danger";
                                            break;
                                        case "D2":
                                            $txt = "เปลี่ยนแปลงประกาศเชิญชวน";
                                            $color = "warning";
                                            break;
                                        default:
                                            break;
                                    }
                                    return "<span class=\"badge badge-$color $pill $shadow $shadow mr-1 font-weight-normal\">$txt</span>";
                                }
                                function methodTitle($type, $pill = true, $shadow = true) {
                                    $pill = ($pill) ? "badge-pill":"";
                                    $shadow = ($shadow) ? "":"z-depth-0";
                                    $txt = $type;
                                    $color = "default";
                                    switch($type) {
                                        case "02":
                                            $txt = "สอบราคา";
                                            $color = "secondary";
                                            break;
                                        case "15":
                                            $txt = "e-market";
                                            $color = "warning";
                                            break;
                                        case "16":
                                            $txt = "e-bidding";
                                            $color = "primary";
                                            break;
                                        case "18":
                                            $txt = "คัดเลือก";
                                            $color = "info";
                                            break;
                                        case "19":
                                            $txt = "เฉพาะเจาะจง";
                                            $color = "danger";
                                            break;
                                        default:
                                            break;
                                    }
                                    return "<span class=\"badge badge-$color $pill $shadow mr-1 font-weight-normal\">$txt</span>";
                                }
                                function ThaiDMY($date, $full = true, $onlyMonthYear = false) {
                                    $date = strtotime($date);
                                    $d = date("d", $date); $m = date("m", $date); $y = date("Y", $date)+543;
                                    $month = ($full) ? ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"] : ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
                                    return ($onlyMonthYear) ? $month[$m-1]." ".$y : $d." ".$month[$m-1]." ".$y;
                                }
                                function fiscalYear($id) {
                                    $year = (mb_substr($id, 0, 1, 'utf-8') == "M") ? mb_substr($id, 1, 2, 'utf-8') : mb_substr($id, 0, 2, 'utf-8');
                                    return (int) "25$year";
                                }
                                $eGPconn = new mysqli('10.101.106.133', "eGP", "^f3CdPSLTzQCT2@!", "EGP");
                                mysqli_set_charset($eGPconn, 'utf8mb4');
                                
                                $query = array();
                                $year = array();
                                $qyear = array(); 
                                $type = array();
                                $method = array();
                                $search = "";
                                    //SELECT * FROM p0ndja.EGP WHERE id REGEXP '^(64|66)';

                                if (isset($_POST['eGPYear'])) {
                                    foreach($_POST['eGPYear'] as $y) {
                                        array_push($year, (int) $eGPconn->real_escape_string($y));
                                        array_push($qyear, (int) $eGPconn->real_escape_string($y)%2500);
                                    }
                                    array_push($query,"`id` REGEXP '^(" . implode("|", $qyear) . ")'");
                                }
                                if (isset($_POST['eGPType'])) {
                                    foreach($_POST['eGPType'] as $t) {
                                        array_push($type, $eGPconn->real_escape_string($t));
                                    }
                                    array_push($query,"`type` IN ('" . implode("','", $type) . "')");
                                }
                                if (isset($_POST['eGPMethod'])) {
                                    foreach($_POST['eGPMethod'] as $t) {
                                        array_push($method, $eGPconn->real_escape_string($t));
                                    }
                                    array_push($query,"`method` IN ('" . implode("','", $method) . "')");
                                }
                                if (isset($_POST['eGPSearch']) && !empty($_POST['eGPSearch']))
                                    $search = $eGPconn->real_escape_string($_POST['eGPSearch']);
                                    if (!empty($search)) array_push($query,"`title` LIKE '%".$search."%' or `id` LIKE '%".$search."%'");

                                if (!empty($query)) $query = "WHERE " . implode(" AND ", $query);
                                else $query = "";
                                //echo '<div class="alert alert-success" role="alert"><b>Debug Message:</b> '."SELECT * FROM `EGP` $query ORDER BY `date` DESC, `id` ASC".'</div>';
                                $stmt = $eGPconn->prepare("SELECT * FROM `pharmmd_EGP` $query ORDER BY `date` DESC, `id` ASC");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {?>
                                        <tr>
                                            <td scope='row' class="text-right font-weight-bold" data-order='<?php echo $row["id"]; ?>'><?php echo $row["id"]; ?></td>
                                            <td scope='row'><?php echo typeTitle($row["type"]); ?><a href="<?php echo $row["link"]; ?>" class="text-primary font-weight" target="_blank"><?php echo $row["title"];?></a></td>
                                            <td scope='row' class="text-center" data-order='<?php echo $row["date"]; ?>'><?php echo ThaiDMY($row["date"], true); ?></td>
                                            <td scope='row' class="d-none" data-order='<?php echo fiscalYear($row["id"]); ?>'><?php echo "ปีงบประมาณ ".fiscalYear($row["id"]); ?></div></td>
                                            <td scope='row' class="d-none"><div class="display-8"><?php echo typeTitle($row["type"], 0, 0); ?></div></td>
                                            <td scope='row' class="d-none"><div class="display-8"><?php echo methodTitle($row["method"], 0, 0); ?></div></td>
                                        </tr>
                                    <?php }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            <?php foreach($year as $y) { ?>$('#eGPYear option[value=<?php echo $y; ?>]').attr('selected', 'selected');<?php } ?>
            <?php foreach($type as $t) { ?>$('#eGPType option[value=<?php echo $t; ?>]').attr('selected', 'selected');<?php } ?>
            <?php foreach($method as $m) { ?>$('#eGPMethod option[value=<?php echo $m; ?>]').attr('selected', 'selected');<?php } ?>
            $('#eGPSearch').val('<?php echo $search; ?>');
        </script>
        <script>
        $(document).ready(function () {
            let datatable = $('#EGPTable').DataTable({
                searching: false,
                searchPane: true,
                "lengthMenu": [
                    [20, 50, 100, -1],
                    [20, 50, 100, "ทั้งหมด"]
                ],
                'order': [2, 'desc'],
                'columnDefs': [
                    {
                        'targets': [1], // column index (start from 0)
                        'orderable': false // set orderable false for selected columns
                    }
                ],
                "aoColumns": [
                    {
                        "sWidth": "5%"
                    },
                    {
                        "sWidth": "90%"
                    },
                    {
                        "sWidth": "5%"
                    },
                    {
                        "sWidth": "0%"
                    },
                    {
                        "sWidth": "0%"
                    },
                    {
                        "sWidth": "0%"
                    }
                ]
            });
            $('.dataTables_length').addClass('bs-select');
        });
        </script>
        <?php require_once '../static/function/popup.php'; ?>
        <?php require_once '../static/function/script/footer.php'; ?>
    </body>
</html>