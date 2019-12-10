<?php
require_once 'init.php';

if(isset($_POST["image"]))
{
	$data = $_POST["image"];
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$imageName = $currentUser['id'] . '.jpg';
	file_put_contents($imageName, $data);
	rename($imageName, 'uploads/'.$imageName);
	echo '<img src="uploads/'.$imageName.'"/>';

}

?>