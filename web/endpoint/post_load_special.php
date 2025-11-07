<?php 
require_once '../static/function/connect.php';
$total_post_inDB = 0;
function lostPostSpecial(String $category = "~", String $tag = "", int $limit = 10, $seed = null) {
    global $total_post_inDB;
    global $conn;
    $final_list = array(); $id_list = array();
    $stmt = loadPostNormal($category, $tag, 1, $limit, true); //Get only pinned post first
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $properties = json_decode($row["property"], true);
                if(isset($properties["pin"]) && ((int) $properties["pin"] == 1)){
                    array_push($final_list, $row['id']);
                }
            }
            $total_post_inDB += $result->num_rows;
        }
    }
    if (count($final_list) < $limit) { //Then, continue gather more non-pinned post and random with hashed by date
        $quota_left = $limit - count($final_list);
        $stmt = "";
        if (!empty($tag)) {
            $json_tag = json_encode(array("tags"=>"$tag"));
            if ($category != "~") {
                $stmt = $conn->prepare("SELECT `id` FROM `post` WHERE JSON_EXTRACT(`property`,'$.category') = ? AND JSON_CONTAINS(`property`,?) AND JSON_EXTRACT(`property`,'$.hide') = false AND JSON_EXTRACT(`property`,'$.pin') = false");
                $stmt->bind_param('ss', $category, $json_tag);
            } else {
                $stmt = $conn->prepare("SELECT `id` FROM `post` WHERE JSON_CONTAINS(`property`,?) AND JSON_EXTRACT(`property`,'$.hide') = false AND JSON_EXTRACT(`property`,'$.pin') = false");
                $stmt->bind_param('s', $json_tag);
            }
        } else {
            if ($category != "~") {
                $stmt = $conn->prepare("SELECT `id` FROM `post` WHERE JSON_EXTRACT(`property`,'$.category') = ? AND JSON_EXTRACT(`property`,'$.hide') = false AND JSON_EXTRACT(`property`,'$.pin') = false");
                $stmt->bind_param('s', $category);
            } else {
                $stmt = $conn->prepare("SELECT `id` FROM `post` WHERE JSON_EXTRACT(`property`,'$.hide') = false AND JSON_EXTRACT(`property`,'$.pin') = false");
            }
        }
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($id_list, $row['id']);
                }
                $total_post_inDB += $result->num_rows;
            }
        }
        if (count($id_list) <= $quota_left) {
            foreach($id_list as $i) {
                array_push($final_list, $i);
            }
        } else {
            if ($seed == null) $seed = (int) date("dmY");
            fisherYatesShuffle($id_list, $seed);
            for ($i = 0; $i < $quota_left; $i++) { //Push only first n post into final list
                array_push($final_list, $id_list[$i]);
            } 
        }
    }
    $final_query_id = implode(',', $final_list);
    return $conn->prepare("SELECT * FROM `post` WHERE `id` IN ($final_query_id) ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC");
}

function fisherYatesShuffle(&$items, $seed) {
    @mt_srand($seed);
    for ($i = count($items) - 1; $i > 0; $i--)
    {
        $j = @mt_rand(0, $i);
        $tmp = $items[$i];
        $items[$i] = $items[$j];
        $items[$j] = $tmp;
    }
}

$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$tag = isset($_GET['tags']) ? $_GET['tags'] : "";
$category = isset($_GET['category']) ? $_GET['category'] : "~";
$news_per_page = isset($_GET['maximum']) ? (int) $_GET['maximum'] : 25;
$seed = isset($_GET['seed']) ? (int) $_GET['seed'] : (int) date("dmY");

$stmt = lostPostSpecial($category, $tag, $news_per_page, $seed);
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

            $writer = new User((int) $properties['author']);
            $properties_writer = ($writer->getID() != -1 && isAdmin()) ? ' by '.'<a href="../user/'.$writer->getID().'" class="md">'.$writer->getName().'#'.$writer->getID().'</a>' : "";
        ?>
        <div class="col-12 col-md-6 col-xl-4">
            <a href="<?php echo $properties_link; ?>" class="text-dark">
                <div class="card mb-1 mt-1">
                    <div class="view overlay zoom">
                        <img src="<?php echo $properties_cover; ?>" class="card-img-top" loading="lazy" style="min-width: 100%; object-fit: contain; aspect-ratio: 16/9; background-color: <?php echo get_average_colour($properties_cover); ?>;">
                    </div>
                </div>
                <div class="ml-1 mr-1 mt-2 mb-3">
                    <a href="<?php echo $properties_link; ?>" class="display-8 md"><text class='font-weight-bold'><?php echo $properties_pin; ?><?php echo mb_strimwidth($row['title'],0,70,'...'); ?></text></a>
                    <br><small class="mt-1 text-muted"><?php echo fromThenToNow($properties["upload_time"]) . $properties_writer; ?> </small>
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
    if ($total_post_inDB < $news_per_page) { ?>
    <div id="EOF"></div>
    <?php } else if (isset($_GET['LM2VA'])) { ?><div class="text-center w-100"><a href="../category/<?php echo $category; ?>-1" class="btn btn-c-md btn-md">ดูเพิ่มเติม</a></div><?php } ?>
<?php } else { ?>
<div id="EOF"></div>
<?php if ($current_page == 1) { ?>
    <div class="col-12 font-weight-italic text-muted text-center">ไม่พบข้อมูลใด ๆ</div>
<?php } ?>
<?php } ?>