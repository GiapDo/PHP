<?php 
    include '../function.php'; 
    isLogin("dang_nhap.php");
    if(!$_SESSION['checkTK'][3]){
        header("location: khoa_hoc.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thêm khóa học</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
    <?php 
        include 'navbar.php';
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
			<div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Thêm khóa học mới</p>
			<a href="quan_ly_khoa_hoc.php" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
			</div>
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name"><span style="color: red;">*</span>Nhập tên khóa học</label>
                    <input class="form-control"  type="text" name="ten_khoa_hoc" id="" value="<?php if(isset($_POST['ten_khoa_hoc'])){ echo $_POST['ten_khoa_hoc'];} ?>">
                </div>
                <div class="form-group">
                    <label for="name">Ảnh cho khóa học</label>
                    <input class="form-control"  type="file" name="file_tai_len" id="">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Mô tả khóa học</label>
                    <input class="form-control" type="text" name="mo_ta" id="" value="<?php if(isset($_POST['mo_ta'])){ echo $_POST['mo_ta'];} ?>">
                </div>
                <br>
                <?php
                    if(isset($_POST['btn'])){
                        $tenKH = trim($_POST['ten_khoa_hoc']);
                        $anh = $_FILES['file_tai_len'];
                        $moTa = trim($_POST['mo_ta']);
                        
                        $a = checkThemKhoaHoc($tenKH, $anh);
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            $tenKH = bokhoangtrang($tenKH);
                            if($moTa != ""){
                                $moTa = bokhoangtrang($moTa);
                            }

                            if(themKhoaHoc($tenKH, $anh, $moTa)){
                                echo "<div class='alert alert-success text-center' role='alert'>Thêm khóa học thành công</div>";
                            }else{
                                echo "<div class='alert alert-warning text-center' role='alert'>Thêm khóa học thất bại</div>";
                            }
                        }
                    }
                    
                ?>
                               
                
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm khóa học">
                </div>
               
            </div>
            </form>
		
	</main>

    <?php 
        // include 'footer.php'; 
    ?>

</body>

    <?php 
        function checkThemKhoaHoc($ten, $anh){
            $check = 1;
		    $s = "";
		    if($ten == ""){
			    $check = 0;
			    $s .= "<p><b>Nhập tên khóa học</b></p>";
		    }
		
		    if(isset($anh) && !empty($anh['name'])){
			    $tenAnh = $anh['name'];
			    if(!checkAnh($tenAnh)){
				    $check = 0;
				    $s .= "<p><b>Ảnh không hợp lệ</b></p>";
			    }
		    }

		    if($check == 0){
			    return [0, $s];
		    }else{
			    return [1, ''];
		    }
        }

        function bokhoangtrang($s){
            $s1 = $s[0];
            for($i = 1; $i < strlen($s); $i++){
                if($s[$i] == " " && $s[$i-1] == " "){
                    continue;
                }else{
                    $s1 .= $s[$i];
                }
            }
            return $s1;
        }

        function themKhoaHoc($ten, $anh, $mota){
            global $conn;
            $anh = taiAnh($anh);

            if($mota == ""){
                $mota = null;
            }

            if($anh == null){
                $a = themAnhMacDinh();
                if($a[0]){
                    $anh = $a[1];
                }else{
                    return false;
                }
            }

            $sql = "INSERT INTO khoahoc VALUE(null, '$ten', '$mota', '$anh')";
            $rs = mysqli_query($conn, $sql);
            
            $idKH = mysqli_insert_id($conn);
            if($rs){
                $a = layRaTKD();
                foreach($a as $x){
                    $sql1 = "INSERT INTO thamgia VALUE(null, $x, $idKH)";
                    $rs1 = mysqli_query($conn, $sql1);
                    if($rs1 === false){
                        return false;
                    }
                }
                return true;
            }else{
                return false;
            }
        }

        function layRaTKD(){
            global $conn;
            $sql = "SELECT UserId FROM taikhoan WHERE UserRole = 1";
            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = $x[0];
                }
            }
            return $a;
        }

        function themAnhMacDinh(){
            $sourceImage = "../images/khoahoc.jpg";
            $targetDirectory = "../images/";
        	$date = date('YmdHis');
        	$tenAnh = "khoahoc".$date.".jpg";
            $targetFile = $targetDirectory . $tenAnh;

            if (copy($sourceImage, $targetFile)) {
                return [1, $tenAnh];
            } else {
                return [0, "Thất bại"];
            }
        }
    ?>

	
</html>