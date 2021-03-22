<?php

	session_start();
	
	
	include_once('parts/db_config.php');
	include 'parts/CommonFunctions.php';
	extract($_POST);
	$user_id = $_SESSION['user_id'];

	$postfile1 = $_FILES['postfile']['name'];
	echo $postfile1;
	if (isset($_FILES['postfile'])) {
		$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
		$postfile = uploadImage($_FILES['postfile'], 'uploadPostFile/');
	}
	echo $_FILES['postfile']['name'];

	$sql = "UPDATE user SET fname = '$fname', lname = '$lname', mobile_no = '$mobile_no', date_of_birth = '$date_of_birth', age = '$age',profile_picture='$postfile', gender = '$gender', branch = '$branch', current_location = '$current_location', education = '$education', skills = '$skills' WHERE user_id=$user_id;";
	echo $sql;
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($result);

	if(mysqli_errno($con)){
		$_SESSION['msg'] = "Something went wrong !";
		header("Location: add_detail.php?uid=$user_id");
		die();
	}
	else{
		header("Location: profile.php?uid=$user_id&me=1");
		die();
	}

?>