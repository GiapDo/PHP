<?php 
	include '../function.php';

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
	<?php
		if(isset($_POST['submitLogin'])){
			$user = trim($_POST['username']);
			$pass = trim($_POST['password']);
			$a = checkLogin($user, $pass);
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
		<div class="d-flex justify-content-center"><h1>Đăng nhập</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  <label for="username" class="form-label">Username</label>
				  <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username" value = "<?php if(isset($_POST['username'])){ echo $_POST['username'];} ?>">
				</div>
				<div class="mb-3">
				    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="password" value="<?php if(isset($_POST['password'])){ echo $_POST['password'];} ?>">
				    </div>
				</div>
				<div class="d-flex justify-content-center">
					<a class="btn btn-primary" style="margin-right: 20px; width : 110px" href="dang_ky.php">Đăng ký</a>
					<input type="submit" class="btn btn-primary" name="submitLogin" value="Đăng nhập" style="width : 110px">
				</div>
			  </form>
		</div>
		
	</main>
	<?php include 'footer.php'; ?>
</body>

	
</html>