<?php
    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = 'Dp17103919@';
    $DB_NAME = '23_project_k71'; 
    $conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
    if($conn){
        mysqli_query($conn,"SET NAMES 'utf8'");
    }
?>