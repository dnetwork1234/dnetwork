<?php 
require 'parts/db_config.php';
session_start();
$fid = $_GET['uid'];
$user_id=$_SESSION['user_id'];
$pid=$_GET['pid'];

//for welcome page
if(isset($_GET['do']) && !isset($_GET['from'])){
    $sql = "DELETE FROM likes where post_id='$pid' and u_id='$user_id'";
    $result=mysqli_query($con,$sql);
    echo $sql;
    header("Location: welcome.php");
}
else if(!isset($_GET['do']) && !isset($_GET['from'])){
    $sql2 = "INSERT INTO likes (like_id, post_id, u_id, created_on) VALUES (NULL, '$pid', '$user_id', current_timestamp())";
    $result2=mysqli_query($con,$sql2);
    echo $sql2;
    header("Location: welcome.php");
}



// for profile page
else if(isset($_GET['do']) && isset($_GET['from'])){
    $sql3 = "INSERT INTO likes (like_id, post_id, u_id, created_on) VALUES (NULL, '$pid', '$user_id', current_timestamp())";
    $result3=mysqli_query($con,$sql3);
    echo $sql3;
    if($_GET['from']=='1'){
        $u_id = $_GET['uid'];
        header("Location: profile.php?uid=$u_id");
    }
    else{
        header("Location: profile.php?uid=$user_id&me=1");
    }
    
}
else{
    $sql4 = "DELETE FROM likes where post_id='$pid' and u_id='$user_id'";
    $result4=mysqli_query($con,$sql4);
    echo $sql4;
    if($_GET['from']=='1'){
        $u_id = $_GET['uid'];
        header("Location: profile.php?uid=$u_id");
    }
    else{
        header("Location: profile.php?uid=$user_id&me=1");
    }
}

// echo $sql2;

?>