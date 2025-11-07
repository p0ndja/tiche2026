<?php
require_once '../static/function/function.php';
if(isset($_POST["image"])) {
	$data = $_POST["image"];
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	if (!file_exists('../file/profile/'. $_POST['userID'] .'/')) {
		make_directory('../file/profile/'. $_POST['userID'] .'/');
	}
	$imageName = "../file/profile/" . $_POST['userID'] . "/Avatar_" . generateRandom(32) . '.png';
	file_put_contents($imageName, $data);
	//createThumbnail($imageName, 0.1);
	echo $imageName;
}

?>