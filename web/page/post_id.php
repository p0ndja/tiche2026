<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <?php
        if (isset($_GET['id'])) {
            $post = new Post((int) $_GET['id']);
            if ($post->getID() == -1) back();
            if ($post->getProperty('hotlink') != null) header("Location: " . $post->getProperty('hotlink'));
            $files_in_attachment = array();
            $id = $post->getID();
            if (file_exists("../file/post/$id/attachment/")) $files_in_attachment = glob("../file/post/$id/attachment/*");
        } else header("Location: ../");
    ?>
    <div class="container mb-3" id="container" >
        <div class="row">
                <div class="col-12 col-lg-3">
                    <?php require_once '../static/function/sidetab.php'; ?>
                </div>
            <!-- <div class="col-12">--><div class="col-12 col-lg-9">
        <!-- <a onclick="window.history.back();" class="float-left"><i class="fas fa-arrow-left"></i> Back</a><br> -->
                <div class=""> <!-- ml-2 mt-2 mb-2 mr-2 -->
                    <?php if (!empty($post->getProperty('cover'))) { ?><img class="img-fluid w-100 z-depth-1" loading="lazy" src="<?php if (file_exists($post->getProperty('cover'))) echo $post->getProperty('cover'); else echo "../static/asset/header_16x9.png"; ?>" style="min-width: 100%;"><?php } ?>
                    <h3 class="font-weight-bold">
                        <?php echo $post->getTitle(); ?>
                        <?php if (isAdmin()) { ?>
                            <a href="../post/edit-<?php echo $post->getID(); ?>" class="z-depth-0 btn-sm btn-floating btn-warning mr-0 ml-0 mb-0 mt-0"><i class='fas fa-edit'></i></a>
                            <?php if ($post->getProperty('hide')) { ?>
                            <a href="../endpoint/postIO.php?method=toggle&target=hide&id=<?php echo $id;?>" class='z-depth-0 btn-sm grey btn-floating mr-0 ml-0 mb-0 mt-0'><i class='fa fa-eye-slash'></i></a>
                            <?php } else { ?>
                            <a href="../endpoint/postIO.php?method=toggle&target=hide&id=<?php echo $id;?>" class='z-depth-0 btn-sm btn-success btn-floating mr-0 ml-0 mb-0 mt-0'><i class='fa fa-eye'></i></a>
                            <?php } ?>
                            <?php if ($post->getProperty('pin')) { ?>
                            <a href="../endpoint/postIO.php?method=toggle&target=pin&id=<?php echo $id;?>" class='z-depth-0 btn-sm btn-success btn-floating mr-0 ml-0 mb-0 mt-0'><i class='fas fa-thumbtack'></i></a>
                            <?php } else { ?>
                            <a href="../endpoint/postIO.php?method=toggle&target=pin&id=<?php echo $id;?>" class='z-depth-0 btn-sm grey btn-floating mr-0 ml-0 mb-0 mt-0'><span class="fa-stack"><i class="fas fa-thumbtack fa-stack-1x"></i><i class="fas fa-slash fa-stack-2x"></i></span></a>
                            <?php } ?>
                            <?php if ($post->getProperty('allowDelete') == true) { ?>
                            <a class='z-depth-0 btn-sm btn-danger btn-floating mr-0 ml-0 mb-0 mt-0'
                            onclick='
                                    swal({title: "ลบข่าวหรือไม่ ?",text: "หลังจากที่ลบแล้ว ข่าวนี้จะไม่สามารถกู้คืนได้!",icon: "warning",buttons: true,dangerMode: true}).then((willDelete) => { if (willDelete) { window.location = "../endpoint/postIO.php?method=delete&id=<?php echo $post->getID(); ?>&category=<?php echo $post->getProperty("category"); ?>";}});'>
                            <i class="fas fa-trash-alt"></i></a>
                            <?php } ?>
                            <?php } ?>
                    </h2>
                <!-- Case post reader -->
                <?php if (trim($post->getArticle()) != null) { ?>
                <hr>
                <div id="articleRenderer"><?php print_r($post->getArticle()); ?></div>
                <?php } ?>
                <?php if (count($files_in_attachment) > 0) {?>
                    <hr>
                    <?php if (count($files_in_attachment) == 1 && pathinfo($files_in_attachment[0], PATHINFO_EXTENSION) == "pdf") { ?>
                    <?php   if (empty(trim($post->getArticle()))) {
                                $link = $files_in_attachment[0];
                                if (isAdmin()) { ?>
                                    <h5 class="font-weight-bold">#Redirect <a href="<?php echo $link; ?>" class="md"><?php echo $link; ?></a></h5>
                                <?php } else {
                                    header("Location: $link");
                                    }
                                }
                    ?>
                    <iframe
                        src="../static/library/pdf.js/web/viewer.html?file=../../../<?php echo $files_in_attachment[0]; ?>"
                        width="100%" height="750"></iframe>
                    <?php } else {
                        $_GET['path'] = "../file/post/$id/attachment/"; 
                        include '../endpoint/file_lookup.php';
                    } ?>
                <?php } ?>
                <!-- <i class="far fa-clock"></i>
                <small class="text-muted">
                <?php
                    // $writer = new User((int) $post->getProperty('author'));
                    // $properties_writer = ($writer->getID() != -1 && isAdmin()) ? ' by '.'<a href="../user/'.$writer->getID().'" class="md">'.$writer->getName().'#'.$writer->getID().'</a>' : "";
                    // echo fromThenToNow($post->getProperty('upload_time')) . $properties_writer; 
                ?>
                </small> -->
                <!-- <br> -->
                <?php // echo generateCategoryBadge($post->getProperty('category')); ?>
                <?php // if (!empty($post->getProperty('tags'))) { ?>
                    <?php // foreach ($post->getProperty('tags') as $s) { if (!empty($s)) { ?>
                        <!-- <div class="badge badge-sngr d-none"><a href="../category/<?php echo $post->getProperty('category')."-1-$s"; ?>" class="text-white"><?php echo $s; ?></a></div> -->
                    <?php // } } ?>
                <?php // }?>
                </div>
            </div>
            <div class="d-none"> <!--col-md-4 col-12-->
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="font-weight-bold text-md">Latest</h4>
                        <p>
                                <?php
                                if ($stmt=$conn->prepare("SELECT title,id FROM `post` WHERE JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.upload_time') DESC LIMIT 5")) {
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        echo '<ul>';
                                        while ($row = $result->fetch_assoc()) {
                                            $postid = $row['id'];
                                            $posttitle = $row['title'];
                                            echo "<li><a class=\"md\" href=\"../post/$postid\">$posttitle</a></li>";
                                        }
                                        echo '</ul>';
                                    } else {
                                        echo "<i>No recent article</i> 😢";
                                    }
                                }
                                ?>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body card-text">
                        <h4 class="font-weight-bold text-md">Category</h4>
                        <ul>
                            <?php foreach(listCategory() as $l) { ?>
                            <li style="color: green"><a class="md" href="../category/<?php echo $l; ?>-1"><?php echo $l; ?></a></li>
                            <?php } ?>
                        </ul>
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