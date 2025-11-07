<?php

    require_once 'init.php';
    require_once 'connect.php';

    //protect from cross-site scripting
    function xss_clean($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    function latestIncrement($dbdatabase, $db) {
        global $conn;
        $conn->prepare("SET information_schema_stats_expiry = 0;")->execute();
        return mysqli_fetch_array(mysqli_query($conn,"SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbdatabase' AND TABLE_NAME = '$db'"), MYSQLI_ASSOC)["AUTO_INCREMENT"];
    }

    function make_directory($p) {
        $path = explode("/", $p);
        $stackPath = "";
        for ($i = 0; $i < count($path); $i++) {            
            $stackPath .= $path[$i] . "/";
            if (file_exists($stackPath)) continue;
            mkdir($stackPath, 0777, true);
        }
        return file_exists($stackPath);
    }

    //Remove Directory (delTree) by nbari@dalmp.com
    function remove_directory($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? remove_directory("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    function login(String $username, String $password) {
        global $conn;
        if ($stmt = $conn->prepare("SELECT `id` FROM `user` WHERE email = ? AND password = ? LIMIT 1")) {
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return new User((int) $row['id']);
                }
            }
        }
        return null;
    }

    //checkTime is in second unit as UNIX TIME FORMAT.
    function checkAuthKey(String $authKey, int $checkTime = 0, int $uid = 0) {
        global $conn;
        if (isLogin()) $uid = $_SESSION['currentActiveUser']->getID();
        else if (!isValidUserID($uid)) return false;
        
        if ($stmt = $conn->prepare("SELECT `tempAuthKey` FROM `user` WHERE `id` = ?")) {
            $stmt->bind_param('i',$uid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (empty($row['tempAuthKey']) || $row['tempAuthKey'] == null) return false;
                    $key = json_decode($row['tempAuthKey'], true);
                    if ($authKey == $key['key']) {
                        if ($checkTime > 0) return ((time() - ((int)$key['time'])) <= $checkTime);
                        else                return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    function generateAuthKey(int $uid) {
        global $conn;

        if (!isValidUserID($uid)) return false;

        $authKey = array(
            "key" => generateRandom(8),
            "time" => time()
        );
        $tempAuthKey = json_encode($authKey);

        if ($stmt = $conn->prepare("UPDATE `user` SET `tempAuthKey` = ? WHERE `id` = ?")) {
            $stmt->bind_param('si',$tempAuthKey,$uid);
            if ($stmt->execute()) {
                return $authKey['key'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function useAuthKey(String $authKey, int $checkTime = 0, int $uid = 0) {
        global $conn;
        if (isLogin()) $uid = $_SESSION['currentActiveUser']->getID();
        else if (!isValidUserID($uid)) return false;

        if (checkAuthKey($authKey, $checkTime, $uid)) {
            if ($stmt = $conn->prepare("UPDATE `user` SET `tempAuthKey` = null WHERE `id` = ?")) {
                $stmt->bind_param('i',$uid);
                return $stmt->execute();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function listCategory(bool $excludeHardcodedCategory = false) {
        global $conn;
        $category = $excludeHardcodedCategory ? array() : PostCategory::CATEGORIES;
        if ($stmt = $conn->prepare("SELECT DISTINCT JSON_EXTRACT(`property`,'$.category') as category FROM post")) {
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['category'] != "\"uncategorized\"" && !empty($row['category']))
                        array_push($category, substr($row['category'], 1, -1));
                }
                $category = array_unique($category);
                sort($category);
            }
        }
        return $excludeHardcodedCategory ? array_diff($category, PostCategory::CATEGORIES) : $category;
    }

    function loadPostNormal(String $category = "~", String $tag = "", int $page = 1, int $limit = 10, $onlypin = false) {
        $onlypin = ($onlypin == true) ? "AND JSON_EXTRACT(`property`,'$.pin') = true" : "";
        global $conn;
        $stmt;
        $start_id = ($page - 1) * $limit;
        if (!empty($tag)) {
            $json_tag = json_encode(array("tags"=>"$tag"));
            if ($category != "~") {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_EXTRACT(`property`,'$.category') = ? $onlypin AND JSON_CONTAINS(`property`,?) AND JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC LIMIT $start_id, $limit");
                $stmt->bind_param('ss', $category, $json_tag);
            } else {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_CONTAINS(`property`,?) $onlypin AND JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC LIMIT $start_id, $limit");
                $stmt->bind_param('s', $json_tag);
            }
        } else {
            if ($category != "~") {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_EXTRACT(`property`,'$.category') = ? $onlypin AND JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC LIMIT $start_id, $limit");
                $stmt->bind_param('s', $category);
            } else {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_EXTRACT(`property`,'$.hide') = false $onlypin ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC LIMIT $start_id, $limit");
            }
        }
        return $stmt;
    }

    function loadPostAll(String $category = "~", String $tag = "") {
        if ($category == "all" || $category == "*") $category = "~";
        global $conn;
        $stmt;
        if (!empty($tag)) {
            $json_tag = json_encode(array("tags"=>"$tag"));
            if ($category != "~") {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_EXTRACT(`property`,'$.category') = ? AND JSON_CONTAINS(`property`,?) AND JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC");
                $stmt->bind_param('ss', $category, $json_tag);
            } else {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_CONTAINS(`property`,?) AND JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC");
                $stmt->bind_param('s', $json_tag);
            }
        } else {
            if ($category != "~") {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_EXTRACT(`property`,'$.category') = ? AND JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC");
                $stmt->bind_param('s', $category);
            } else {
                $stmt = $conn->prepare("SELECT `id`,`title`,`property` FROM `post` WHERE JSON_EXTRACT(`property`,'$.hide') = false ORDER BY JSON_EXTRACT(`property`,'$.pin') DESC, JSON_EXTRACT(`property`,'$.upload_time') DESC");
            }
        }
        return $stmt;
    }

    function isLogin() {
        if (isset($_SESSION['currentActiveUser'])) return true;
        return false;
    }

    function isAdmin() {
        if (!isLogin()) return false;
        return $_SESSION['currentActiveUser']->getRole() == "admin" ? true : false;
    }

    function isValidUserID($id) {
        global $conn;
        if ($stmt = $conn->prepare("SELECT `id` FROM `user` WHERE `id` = ? LIMIT 1")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                return true;
            }
        }
        return false;
    }

    function getPostData(int $id) {
        global $conn;
        if ($stmt = $conn->prepare('SELECT * FROM `post` WHERE id = ?')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            }
        }
        return null;
    }

    function getUserData(int $id) {
        global $conn;
        if ($stmt = $conn->prepare('SELECT * FROM `user` WHERE id = ?')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            }
        }
        return null;
    }
/*
    function getNewsletterData(int $id) {
        global $conn;
        if ($stmt = $conn->prepare('SELECT * FROM `newsletter` WHERE id = ?')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            }
        }
        return null;
    }
*/
    function getConfig(String $key) {
        $data = getDatatable('settings');
        return (array_key_exists($key,$data)) ? $data[$key] : null;
    }

    function setConfig(String $key, $value) {
        $data = getDatatable('settings');
        $data[$key] = $value;
        return (setDatatable('settings', $value));
    }

    function getDatatable(String $key) {
        global $conn;
        if ($stmt = $conn->prepare('SELECT `value` FROM `datatable` WHERE `key` = ?')) {
            $stmt->bind_param('s', $key);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return json_decode($row["value"], true);
                }
            }
        }
        return array();
    }

    function setDatatable(String $key, $value) {
        if (is_array($value)) {
            $value = json_encode($value);
        } else if (!isJson($value)) {
            return -1;
        }
        
        global $conn;
        $data = getDatatable($key);
        if ($data) {
            if ($stmt = $conn->prepare('UPDATE `datatable` SET `value` = ? WHERE `key` = ?')) {
                $stmt->bind_param('ss', $value, $key);
                if ($stmt->execute()) return 1;
            }
            return 0;
        } else {
            if ($stmt = $conn->prepare('INSERT INTO `datatable` (`key`,`value`) VALUES (?,?)')) {
                $stmt->bind_param('ss', $key, $value);
                if ($stmt->execute()) return 1;
            }
            return 0;
        }
    }

    function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    function getRole($id) {
        return getUserData($id)["role"];
    }

    function watchVDO() {
        $vdo = array();
        $txtFile = "../static/asset/video.txt";
        if (file_exists($txtFile)) {
            $file = fopen("../static/asset/video.txt", "r");
            while(!feof($file)) {
                array_push($vdo, fgets($file));
                # do same stuff with the $vdo
            }
            fclose($file);
        } else {
            $file = fopen("../static/asset/video.txt","w");
            if (!fwrite($file,"https://www.youtube.com/embed/VXZM6imLsw4"))
                die("CAN'T WRITE FILE");
            fclose($file);
        }
        return array_filter($vdo);
    }

    function readTxt($path) {
        $msg = array();
        if (file_exists($path)) {
            $file = fopen($path, "r");
            while(!feof($file)) {
                array_push($msg, fgets($file));
                # do same stuff with the $vdo
            }
            fclose($file);
        }
        return $msg;
    }

    //FileSizeConvert by Arseny Mogilev
    function FileSizeConvert($bytes) {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => 1099511627776
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => 1073741824
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => 1048576
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = round($bytes / $arItem["VALUE"], 2) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    function createHeader($text, $link = null) {
        if ($link != null && !empty($link)) return '<div class="c_header font-weight-bold"><div class="c_title" style="font-weight:500;"><a href="'.$link.'" class="text-white">'.$text.'</a><div class="c_tail"></div><div class="c_tail2"></div></div></div>';
        return '<div class="c_header"><div class="c_title font-weight-bold" style="font-weight:500;">'.$text.'<div class="c_tail"></div><div class="c_tail2"></div></div></div>';
    }

    $getWriterDataFromID_authorList = array();
    function getWriterDataFromID(int $id) {
        global $getWriterDataFromID_authorList;
        if (array_key_exists($id, $getWriterDataFromID_authorList)) return $getWriterDataFromID_authorList[$id];
        $getWriterDataFromID_authorList[$id] = new User($id);
        return $getWriterDataFromID_authorList[$id];
    }

    function getClientIP() {
        $targetIP;
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) $targetIP = $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $targetIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else $targetIP = $_SERVER['REMOTE_ADDR'];
        if ($targetIP == "::1") $targetIP = "127.0.0.1";
        return $targetIP;
    }

    function fixPath($path) {
        return pathinfo($path, PATHINFO_DIRNAME) . "/" . pathinfo($path, PATHINFO_FILENAME);
    }

    function fixFilePath($path) {
        return pathinfo($path, PATHINFO_DIRNAME) . "/" . pathinfo($path, PATHINFO_FILENAME) . "." . pathinfo($path, PATHINFO_EXTENSION);
    }

    function lazy($path, $size = 0.025) {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $nam = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        list($wid, $ht) = getimagesize($path);

        $dul = "";
        if (file_exists("$dir/$nam.lazy.$ext")) {
            return "$dir/$nam.lazy.$ext";
        } else {
            return imageResize($wid*$size, "$dir/$nam.lazy", $path);
        }
    }

    function showWebP($path) {
        if(strpos($_SERVER['HTTP_ACCEPT'],'image/webp') !== false || strpos($_SERVER['HTTP_USER_AGENT'],' Chrome/') !== false) {
            $md5_file = md5_file($path);
            $dir = pathinfo($path, PATHINFO_DIRNAME);
            $nam = pathinfo($path, PATHINFO_FILENAME);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == "webp") return $path;
            // webp is supported!
            if (!file_exists("$dir/$md5_file.webp")) {
                $info = getimagesize($path);
                $mime = $info['mime'];
                switch ($mime) {
                    case 'image/jpeg':
                            $image_create_func = 'imagecreatefromjpeg';
                            break;
                    case 'image/png':
                            $image_create_func = 'imagecreatefrompng';
                            break;
                    case 'image/gif':
                            $image_create_func = 'imagecreatefromgif';
                            break;
                    default: 
                            throw new Exception('Unknown image type.');
                }
                $img = $image_create_func($path);
                if (imagewebp($img, "$dir/$md5_file.webp", 100))
                    return "$dir/$md5_file.webp";
            } else {
                return "$dir/$md5_file.webp";
            }
        }
        return $path;
    }

    function thumbnail($path) {
        if (!file_exists($path))
            return "../static/asset/banner.thumbnail.jpg";
        $md5_file = md5_file($path);
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $nam = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        list($wid, $ht) = getimagesize($path);
        if (file_exists("$dir/thumbnail_$md5_file.$ext"))
            return "$dir/thumbnail_$md5_file.$ext";
        return createThumbnail($path);
    }

    function createThumbnail($path) {
        $md5_file = md5_file($path);
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $nam = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        list($wid, $ht) = getimagesize($path);

        return imageResize(500, "$dir/thumbnail_$md5_file", $path);
        //Fixed width to be 500px to make sure thumbnail isn't too small.
    }

    function imageResize($newWidth, $targetFile, $originalFile) {

        $info = getimagesize($originalFile);
        $mime = $info['mime'];
    
        switch ($mime) {
                case 'image/jpeg':
                        $image_create_func = 'imagecreatefromjpeg';
                        $image_save_func = 'imagejpeg';
                        $new_image_ext = 'jpg';
                        break;
    
                case 'image/png':
                        $image_create_func = 'imagecreatefrompng';
                        $image_save_func = 'imagepng';
                        $new_image_ext = 'png';
                        break;
    
                case 'image/gif':
                        $image_create_func = 'imagecreatefromgif';
                        $image_save_func = 'imagegif';
                        $new_image_ext = 'gif';
                        break;
    
                default: 
                        throw new Exception('Unknown image type.');
        }
    
        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);
    
        $newHeight = (int) floor(($height / $width) * $newWidth);
        $newWidth = (int) floor($newWidth);
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
        if (file_exists($targetFile)) {
                unlink($targetFile);
        }
        if (!$image_save_func($tmp, "$targetFile.$new_image_ext")) return 0;
        return "$targetFile.$new_image_ext";
    }

    function get_average_colour($originalFile) {
        $info = getimagesize($originalFile);
        $mime = $info['mime'];
    
        switch ($mime) {
                case 'image/jpeg':
                        $image_create_func = 'imagecreatefromjpeg';
                        $image_save_func = 'imagejpeg';
                        $new_image_ext = 'jpg';
                        break;
    
                case 'image/png':
                        $image_create_func = 'imagecreatefrompng';
                        $image_save_func = 'imagepng';
                        $new_image_ext = 'png';
                        break;
    
                case 'image/gif':
                        $image_create_func = 'imagecreatefromgif';
                        $image_save_func = 'imagegif';
                        $new_image_ext = 'gif';
                        break;
    
                default: 
                        throw new Exception('Unknown image type.');
        }
    
        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);
        
        $r = 0; $g = 0; $b = 0;
        $sample = 16;
        for ($i = 0; $i < $sample; $i++) {
            for ($o = 0; $o < $sample; $o++) {
                $rgb = imagecolorat($img, round($width*($i/$sample)),round($height*($o/$sample)));
                $r += ($rgb >> 16)& 0xFF;
                $g += ($rgb >> 8)& 0xFF;
                $b += $rgb& 0xFF;
            }
        }
        return "rgba(" . (floor($r/($sample*$sample))) .",". (floor($g/($sample*$sample))) .",". (floor($b/($sample*$sample))) . ",0.8)";
    }

    function path_curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y/m/d', time());
    }

    function unformat_curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('YmdHis', time());
    }

    function curDate() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y-m-d', time());
    }

    function curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('H:i:s', time());
    }

    function curFullTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y-m-d H:i:s', time());
    }
/*
    function sendFileToIMGHost($file) {
        $data = array(
            'img' => new CURLFile($file['tmp_name'],$file['type'], $file['name']),
        ); 
        
        //**Note :CURLFile class will work if you have PHP version >= 5**
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://img.p0nd.ga/upload.php');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $msg = FALSE;
        } else {
            $msg = $response;
        }
        
        curl_close($ch);
        return $msg;
    }
*/
    function isValidPostID($id) {
        return getPostData($id) != null;
    }

    function isValidCategory($category) {
        if ($category == "~" || $category == "uncategorized") return true;
        return in_array($category, listCategory());
    }

    function icon($file, $name = true) {
        $fext = pathinfo($file, PATHINFO_EXTENSION);
        $fname = pathinfo($file, PATHINFO_FILENAME);
        $type = mime_content_type($file);
        $ico = 'far fa-file';
        switch($type) {
            case "directory": 
                $ico = 'fas fa-folder text-warning';
                break;
            case in_array($fext, ['doc', 'docx', 'docm', 'dot', 'dotx', 'dotm', 'odt']):
                $ico = 'far fa-file-word text-primary';
                break;
            case in_array($fext, ['ppt', 'pptx', 'pps', 'ppsx', 'potx', 'potm', 'pot', 'ppsm', 'ppa', 'ppam', 'odp']):
                $ico = 'far fa-file-powerpoint text-warning';
                break;
            case in_array($fext, ['xlsx','xsl','xlsb','xlsm','csv','xltx', 'xltm', 'xlt','ods']):
                $ico = 'far fa-file-excel text-success';
                break;
            case startsWith($type, 'image/'):
                $ico = 'far fa-file-image text-secondary';
                break;
            case startsWith($type, 'text/'):
                $ico = 'far fa-file-alt text-info';
                break;
            case startsWith($type, 'video/'):
                $ico = 'far fa-file-video text-danger';
                break;
            case startsWith($type, 'application/pdf'):
                $ico = 'far fa-file-pdf text-danger';
                break;
            default:
                $ico = 'far fa-file';
        }
        if (!empty($fext)) $fext = ".$fext";
        if (!$name) {
            $fname = "";
            $fext = "";
        }
        return "<i class='$ico'></i> $fname$fext";
    }
    
    function icon_url($file) {    
        return "<a href='$file' target='_blank' class='md'>".icon($file)."</a>";
    }

    function generateCategoryBadge($category) {
        return ($category != "uncategorized" && !empty($category)) ? "<a href='../category/$category-1'><span class='badge badge-sngr'>$category</span></a>" : null;
    }

    function generateCategoryBadgeForced($category) {
        return ($category != "uncategorized" && !empty($category)) ? "<a href='../category/$category-1'><span class='badge badge-sngr font-weight-normal'>$category</span></a>" : "<span class='badge badge-dark font-weight-normal'>ไม่ได้จัดหมวดหมู่</span>";
    }

    function generateCategoryTitle($category, $tag = "", $link = false, $alt_link = "") {
        $text = $category;
        if ($category == "~")
            $text = "โพสต์ทั้งหมด";
        if (!empty($tag))
            $text .= " #$tag";

        if ($link) {
            if (!empty($alt_link)) return createHeader($text, "$alt_link");
            if (!empty($tag)) return createHeader($text, "../category/$category-1-$tag");
            return createHeader($text, "../category/$category-1");
        }
        return createHeader($text);
    }

    function WTFTime(int $dateString) {
        if($dateString > time()) {
            return 1;
        # date is in the future
        }
        if($dateString < time()) {
            return -1;
        # date is in the past
        }
        if($dateString == time()) {
            return 0;
        # date is right now
        }
    }

    function dateDifference($date_1 , $date_2 = 'now' , $differenceFormat = '%a')
    {
        date_default_timezone_set('Asia/Bangkok'); 
        $datetime1 = date_create(date("Y-m-d H:i:s", $date_1));
        $datetime2 = date_create('now');
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    
    }

    function fromThenToNow($date_1, $differenceFormat = '%a')
    {
        $datetime1 = date_create(date("Y-m-d H:i:s", $date_1));
        $datetime2 = date_create(date("Y-m-d H:i:s", time()));
        
        $interval = date_diff($datetime1, $datetime2);

        $time = WTFTime($date_1);
    
        $days = $interval->format($differenceFormat);
        $msg = "";
        if ($days == 0) {
            if ($hour = dateDifference($date_1, 'now', '%h'))
                $msg = "$hour hour" . ($hour == 1 ? "" : "s") . " ago";
            else if ($min = dateDifference($date_1, 'now', '%i'))
                $msg = "$min minute" . ($min == 1 ? "" : "s") . " ago";
            else
                $msg = "Recently";
        }
        else if ($time > 0) {
            if ($days > 364)
                $msg = "In " . floor($days/365) . " year" . (floor($days/365) > 1 ? "s" : "");
            else if ($days > 29)
                $msg = "In " . floor($days/30) . " month" . (floor($days/30) > 1 ? "s" : "");
            else
                $msg = "In $days day" . ($days > 1 ? "s" : "");
        } else {
            if ($days > 364)
                $msg = floor($days/365) . " year". (floor($days/365) > 1 ? "s" : "") . " ago";
            else if ($days > 29)
                $msg = floor($days/30) . " month". (floor($days/30) > 1 ? "s" : "") . " ago";
            else
                $msg = "$days day" . ("$days " . $days > 1 ? "s" : "") . " ago";
        }
        return "<a title='" . date("M d Y H:i:s", $date_1) . " ICT'>$msg</a>";
    }

    function generateRandom($length = 16, $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789") {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $string[rand(0, strlen($string) - 1)];
        }
        return $randomString;
    }

    function startsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
    function endsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

    function sanitizeFilename($filename) {
        // Remove all characters except letters, numbers, dashes, underscores, and dots
        return preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $filename);
    }
?><?php function needLogin() {
    if (!isLogin()) {?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You need to logged-in!",
        icon: "error"
    }).then(function () {
        <?php $_SESSION['auth_error'] = "กรุณาเข้าสู่ระบบก่อนดำเนินการต่อ"; ?>
        window.location = "../login/";
    });
</script>
<?php die(); }} ?><?php function needPermission($perm) {
    if (!isLogin()) { needLogin(); die(); }
    if (!isAdmin()) { ?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You don't have enough permission!",
        icon: "warning"
    }).then(function () {
        window.location = "../";
    });
</script>
<?php die();}
    }
?><?php function needAdmin() {
    if (!isLogin()) { needLogin(); die(); }
    if (!isAdmin()) { ?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You don't have enough permission!",
        icon: "warning"
    }).then(function () {
        window.location = "../";
    });
</script>
<?php die();}
    }
?><?php function back() {
    if (isset($_SERVER["HTTP_REFERER"])) header("Location: " . $_SERVER["HTTP_REFERER"]);
    else home();
    die();
} ?><?php function home() { header("Location: ../"); } ?>