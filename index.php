<?php 
	include 'function.php';
	// dùng hàm kiểm tra đăng nhập trong file funciton
	// nếu đăng nhập rồi thì truy cập vào trang khóa học
	// còn chưa đăng nhập thì điều hướng ra trang đăng nhập
	isLogin("src/dang_nhap.php");
	if(isset($_SESSION['checkTK'])){
		if($_SESSION['checkTK'][0]){
			header("location: src/khoa_hoc.php");
		}
	}
 ?>