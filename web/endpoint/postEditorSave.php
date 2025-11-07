<?php
require_once '../static/function/connect.php';

$category = "~";
if (isset($_POST['submit'])) {
    $category = $_POST['group'];
    /* URL Encode Reserved */
    foreach(array("?", "#", "/", "\\", "--") as $c)
        $category = str_replace($c, "-", $category);
    $category = str_replace("--", "-", $category);

    $method = $_POST['method'];
    $id = ($method == "create") ? latestIncrement($db["table"], 'post') : (int) $_GET['news'];
    $title = $_POST['title'];
    $article = str_replace(array("\r","\n"), "", $_POST['articleEditor']);

    $tags = explode(",", $_POST['tags']);

    date_default_timezone_set('Asia/Bangkok'); 

    $finaldir = $_POST['real_cover'];
    if (isset($_FILES['cover']) && $_FILES['cover']['name'] != "") {
        $name_file = $_FILES['cover']['name'];
        $tmp_name = $_FILES['cover']['tmp_name'];
        $locate_img ="../file/post/".$id."/"."thumbnail/";
        if (!file_exists($locate_img)) {
            if (!make_directory($locate_img)) die(PresetMessage::FILE_IO);
        }
        if (!move_uploaded_file($tmp_name,$locate_img.$name_file)) die(PresetMessage::FILE_UPLOAD_NOT_FOUND);
        $finaldir = $locate_img.$name_file;
        $thumbnail = createThumbnail($finaldir);
    }

    $fileTotal = count($_FILES['attachment']['name']);
    if (is_uploaded_file($_FILES['attachment']['tmp_name'][0])) {
        if (!file_exists("../file/post/$id/attachment/")) {
            //First time upload.
            make_directory("../file/post/$id/attachment/");
        } else {
            //Remove all uploaded file.
            foreach(array_filter(glob("../file/post/$id/attachment/*"), 'is_file') as $f) unlink($f);
        }
        for ($i = 0; $i < $fileTotal; $i++) {
            if($_FILES['attachment']['tmp_name'][$i] != ""){
                $name_file = $_FILES['attachment']['name'][$i];
                $tmp_name = $_FILES['attachment']['tmp_name'][$i];
                $locate_img ="../file/post/".$id.'/'.'attachment/';
                if (!move_uploaded_file($tmp_name,$locate_img.$name_file)) die(PresetMessage::FILE_UPLOAD_NOT_FOUND);
                if (!rename($locate_img.$name_file, $locate_img.$name_file)) die(PresetMessage::FILE_IO);
            }
        }
    } else if (empty($_POST['attachmentURL'])) {
        //User reset attachment field
        foreach(array_filter(glob("../file/post/$id/attachment/*"), 'is_file') as $f) unlink($f);
    }

    $post = new Post((int) $id);
        $post->setProperty('author', $_SESSION['currentActiveUser']->getID());
        $post->setProperty('category', $_POST['group']);
        $post->setProperty('upload_time', time());
        $post->setProperty('hide', (isset($_POST['isHidden']) && $_POST['isHidden'] == 'on') ? true : false);
        $post->setProperty('pin', (isset($_POST['isPinned']) && $_POST['isPinned'] == 'on') ? true : false);
        $post->setProperty('tags', $tags);
        $post->setProperty('cover', $finaldir);
        if ($method == "create") $post->setProperty('allowDelete', true);
    $properties = json_encode($post->properties());

    if ($method == "create") {
        if ($stmt = $conn->prepare("INSERT INTO `post` (title, article, property) VALUES (?,?,?)")) {
            $stmt->bind_param('sss', $title, $article, $properties);
            if (!$stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
            } else {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "เพิ่มโพสต์ $title #$id แล้ว!");
            }
        } else {
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
        }
    } else {
        if ($stmt = $conn->prepare("UPDATE `post` SET title=?, article=?, property=? WHERE id=?")) {
            $stmt->bind_param('ssss', $title, $article, $properties, $id);
            if (!$stmt->execute()) {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_QUERY . ": " . $conn->error, SweetAlert::ERROR);
                print_r($conn->error);
            } else {
                $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::SUCCESS, "อัปเดตโพสต์ $title #$id แล้ว!");
            }
        } else {
            $_SESSION['SweetAlert'] = new SweetAlert(PresetMessage::ERROR, PresetMessage::DATABASE_ESTABLISH . ": " . $conn->error, SweetAlert::ERROR);
        }
    }
}
header("Location: ../post/". $id);
?>