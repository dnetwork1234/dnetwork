<?php 
session_start();
require 'parts/db_config.php';
include 'parts/CommonFunctions.php';
extract($_POST);
$user_id=$_SESSION['user_id'];


$postfile1 = $_FILES['postfile']['name'];

if (isset($_FILES['postfile'])) {
    $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
    $postfile = uploadImage($_FILES['postfile'], 'uploadPostFile/');
}
echo $_FILES['postfile']['name'];


$sql1 = "INSERT INTO post (post_id, user_id,post_desc, created_on, updated_on) VALUES (NULL, '$user_id','$postdesc', current_timestamp(), current_timestamp())";
$result1 = mysqli_query($con,$sql1);
$num1 = mysqli_num_rows($result1);





$sql2 = "SELECT * from post where user_id='$user_id' ORDER BY post_id DESC";
$result2 = mysqli_query($con,$sql2);
$num2 = mysqli_num_rows($result2);
$row2 = mysqli_fetch_assoc($result2);
$post_id=$row2['post_id'];
// echo $sql2;

$sql3 = "INSERT INTO post_file (file_id, post_id, file_path) VALUES (NULL, '$post_id', '$postfile')";
$result3 = mysqli_query($con,$sql3);
$num3 = mysqli_num_rows($result3);


// echo $sql3;
header("Location: welcome.php");


?>