<?php 
	include "../function.php";
	isLogin("dang_nhap.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Khóa học</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
	<?php include 'navbar.php';?>
	<main style="min-height: 100vh; width: 100%;">
		<div class="" style="text-align: center;">
			<h2>
				Khóa học
			</h2>
		</div>
		<div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">

		<?php 
			$a = layKhoaHoc();

			if(count($a) > 0){
				for($i = 0; $i < count($a); $i++){
					inKhoaHoc($a[$i][3], $a[$i][2], $a[$i][1], $a[$i][0]);
				}
			}
		?>
		
		</div>
	</main>
	<?php include 'footer.php'; ?>
</body>

	
</html>