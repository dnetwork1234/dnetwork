<?php 
require 'parts/db_config.php';
session_start();
$user_id = $_SESSION['user_id'];
$uid = $_GET['uid'];
$do = $_GET['do'];
// for request accept
if($do==1){
    $sql1 = "UPDATE follow SET is_accepted = '1' WHERE user_id='$uid' and u_id='$user_id'";
    $result1=mysqli_query($con,$sql1);
    $num1 = mysqli_num_rows($result1);
    $row1=mysqli_fetch_assoc($result1);
    echo $sql1;
    if($_GET['from']=='1'){
        header("Location: profile.php?uid=$uid");
    }
    else{
        header("Location: requests.php");
    }
    
}
//do=2 for request delete
if($do==2){
    $sql2 = "DELETE FROM follow WHERE user_id='$uid' and u_id='$user_id'";
    $result2=mysqli_query($con,$sql2);
    $num2 = mysqli_num_rows($result2);
    $row2=mysqli_fetch_assoc($result2);
    echo $sql2;
    header("Location: requests.php");
}
?>