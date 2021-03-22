<?php 
require 'parts/db_config.php';
session_start();
$fid = $_GET['uid'];
$comment=$_POST['comment'];
$pid=$_GET['pid'];
$user_id = $_SESSION['user_id'];
$sql2 = "INSERT INTO comments (comment_id, post_id, u_id, description, created_on) VALUES (NULL, '$pid', '$user_id', '$comment', current_timestamp());";
$result2=mysqli_query($con,$sql2);
// echo $sql2;
if(isset($_GET['from'])){
    header("Location: profile.php?uid=$user_id&me=1");
}
else{
    header("Location: welcome.php");
}
?>