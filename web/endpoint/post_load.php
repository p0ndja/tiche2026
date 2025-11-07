<?php 
require_once '../static/function/connect.php';
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$tag = isset($_GET['tags']) ? $_GET['tags'] : "";
$category = isset($_GET['category']) ? $_GET['category'] : "~";
$news_per_page = isset($_GET['maximum']) ? (int) $_GET['maximum'] : 25;
$max_per_line = isset($_GET['maxPerLine']) ? (int) $_GET['maxPerLine'] : 3;

$stmt = loadPostNormal($category, $tag, $current_page, $news_per_page);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $properties = json_decode($row["property"], true);
            $properties_pin = isset($properties["pin"]) && ((int) $properties["pin"] == 1) ? '<span class="badge badge-md"><i class="fa-solid fa-thumbtack"></i></span> ' : ""; 
            $properties_link = "../post/" . $row['id']; //TODO later if post only has link, create a redirect link
            $properties_cover = (isset($properties['cover']) && !empty($properties['cover']) && file_exists($properties['cover'])) ? thumbnail($properties["cover"]) : "../static/asset/header_16x9.png";
            $properties_tags = isset($properties["tags"]) ? $properties["tags"] : "";

            $writer = getWriterDataFromID($properties['author']);
        ?>
        <div class="col-12 col-md-6 col-lg-12">
            <a href="<?php echo $properties_link; ?>" class="text-dark">
                <div class="card mb-1 mt-1">
                    <div class="view overlay zoom">
                        <img src="<?php echo $properties_cover; ?>" class="card-img-top" loading="lazy" style="min-width: 100%; object-fit: contain; aspect-ratio: 16/9; background-color: <?php echo get_average_colour($properties_cover); ?>;">
                    </div>
                </div>
                <div class="ml-1 mr-1 mt-2 mb-3">
                    <a href="<?php echo $properties_link; ?>" class="display-8 md"><text class='font-weight-bold'><?php echo $properties_pin; ?><?php echo mb_strimwidth($row['title'],0,70,'...'); ?></text></a>
                    <br><small class="mt-1 text-muted"><?php echo fromThenToNow($properties["upload_time"]) . (($writer->getID() != -1 && isAdmin()) ? ' by '.'<a href="../user/'.$writer->getID().'" class="md">'.$writer->getName().'#'.$writer->getID().'</a>' : ""); ?> </small>
                    <br>
                    <?php if (!empty($properties_tags)) { ?>
                        <?php foreach ($properties_tags as $s) { if (!empty($s)) { ?>
                            <div class="badge badge-md"><a href="../category/<?php echo "$category-1-$s"; ?>" class="text-white"><?php echo $s; ?></a></div>
                        <?php } } ?>
                    <?php }?>
                </div>
            </a>
        </div>
    <?php }
    if ($result->num_rows < $news_per_page) { ?>
    <div id="EOF"></div>
    <?php } else if (isset($_GET['LM2VA'])) { ?><div class="text-center w-100"><a href="../category/<?php echo $category; ?>-1" class="btn btn-c-md btn-md">Read More</a></div><?php } ?>
<?php } else { ?>
<div id="EOF"></div>
<?php if ($current_page == 1) { ?>
    <div class="col-12 font-weight-italic text-muted text-center">To be announced</div>
<?php } ?>
<?php } ?>