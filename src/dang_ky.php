<?php 
	include '../function.php';

	function checkSign($user, $pass, $pass1){
		$s = "";
		$check = 1;
		global $conn;
		if(empty($user)){
			$s = '<p><b>Nhập tên tài khoản</b></p>';
			$check = 0;
		}

		if(empty($pass)){
			$s .= '<p><b>Nhập mật khẩu</b></p>';
			$check = 0;
		}

		if(empty($pass1)){
			$s .= '<p><b>Nhập xác nhận mật khẩu</b></p>';
			$check = 0;
		}

		if($check == 0){
			return [0, $s];
		}else{
			$sql = "SELECT * FROM taikhoan WHERE UserName LIKE '$user'";
			$rs1 = mysqli_query($conn, $sql);
			if(mysqli_num_rows($rs1)){
				return [0, '<p><b>Tên tài khoản đã tồn tại</b></p>'];
			}else{
				if($pass != $pass1){
					return [0, '<p><b>Mật khẩu và xác nhận mật khẩu không khớp</b></p>'];
				}else{
					$pass = md5($pass);
					$sql = "INSERT INTO taikhoan VALUE (null, '$user', '$pass', 0)";
					$rs2 = mysqli_query($conn, $sql);
					if($rs2 === true){
						return [1, mysqli_insert_id($conn), 0];
					}else{
						return [0, "<p><b>Đăng ký thất bại</b></p>"];
					}
				}
			}
		}

	}

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng ký</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
	<?php
		if(isset($_POST['submitSign'])){
			$user = trim($_POST['username']);
			$pass = trim($_POST['password1']);
			$pass1 = trim($_POST['password2']);
			$a = checkSign($user, $pass, $pass1);
			if($a[0] == 0){
				$tt = $a[1];
				echo "<div class='alert alert-danger text-center' role='alert'>
						$tt
					  </div>";
			}else{
				$_SESSION['checkTK'] = [1, $a[1], $user, $a[2]];
				header("location: khoa_hoc.php");
			}
		}
	?>

	
	<main style="min-height: 100vh; margin-top: 10%;">
		<div class="d-flex justify-content-center"><h1>Đăng ký</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  <label for="username" class="form-label">Username</label>
				  <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username" value = "<?php if(isset($_POST['username'])){ echo $_POST['username'];} ?>">
				</div>
				<div class="mb-3">
				    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập mật khẩu" name="password1" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1'];} ?>">
				    </div>
				</div>
				<div class="mb-3">
				    <label for="inputPassword" class="col-sm-5 col-form-label">Confirmation Password</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập xác nhận mật khẩu" name="password2" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1'];} ?>">
				    </div>
				</div>
				<div class="d-flex justify-content-center">
					<input type="submit" class="btn btn-primary" name="submitSign" value="Đăng ký" style="margin-right: 20px; width : 110px">
					<a class="btn btn-primary" style="width : 110px" href="dang_nhap.php">Đăng nhập</a>
				</div>
			</form>
		</div>
		
	</main>
	<?php include 'footer.php'; ?>
</body>

	
</html>