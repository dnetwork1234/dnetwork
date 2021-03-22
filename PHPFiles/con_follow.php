<?php 
session_start();
require 'parts/db_config.php';
$uid = $_GET['uid'];
$user_id=$_SESSION['user_id'];
if(isset($_SESSION['unfollow'])){
    $sql = "DELETE FROM FOLLOW WHERE user_id='$uid' and u_id='$user_id'";
    $result=mysqli_query($con,$sql);
    $num = mysqli_num_rows($result);
    $row=mysqli_fetch_assoc($result);
    echo $sql;
    unset($_SESSION['unfollow']);
    header("Location: profile.php?uid=$uid");
}
else if(isset($_SESSION['pending'])){
    $sql1 = "DELETE FROM FOLLOW WHERE user_id='$user_id' and u_id='$uid'";
    $result1=mysqli_query($con,$sql1);
    $num1 = mysqli_num_rows($result1);
    $row1=mysqli_fetch_assoc($result1);
    echo $sql1;
    unset($_SESSION['pending']);
    header("Location: profile.php?uid=$uid");
}
else{
    $sql2 = "INSERT INTO follow (follow_id, user_id, u_id, created_on, is_accepted) VALUES (NULL, '$user_id', '$uid', current_timestamp(), 0)";
    $result2=mysqli_query($con,$sql2);
    $num2 = mysqli_num_rows($result2);
    $row2=mysqli_fetch_assoc($result2);
    echo $sql2;
    header("Location: profile.php?uid=$uid");
}

?>