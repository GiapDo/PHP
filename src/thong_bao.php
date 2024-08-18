<?php 
    include '../function.php'; 
    isLogin("dang_nhap.php");
    if(isset($_SESSION['diem'])){
        $diem = $_SESSION['diem'];
        echo "Điểm của bạn là: $diem";
        unset($_SESSION['diem']);
    }
?>