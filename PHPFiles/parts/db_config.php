<?php 
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'dnetwork';
    $con = mysqli_connect($server,$username,$password,$database);
    error_reporting(0);
    if(!$con){
        echo "Connection not established.";
    }
?>