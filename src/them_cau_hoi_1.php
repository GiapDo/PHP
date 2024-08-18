<?php 
    include '../function.php'; 
    isLogin("dang_nhap.php");
    if(!isset($_GET['id_khoa_hoc'])){
        header("location: khoa_hoc.php");
    }

    $idKH = $_GET['id_khoa_hoc'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thêm câu hỏi</title>
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
            <p class="h3">Khóa học 
                <?php 
                    echo layTenKhoaHoc($idKH);
                ?>
            </p>
			<a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
			</div>
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                    <input class="form-control"  type="text" name="ten_cau_hoi" id="" value="<?php if(isset($_POST['ten_cau_hoi'])){ echo $_POST['ten_cau_hoi'];} ?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label>
                    <input class="form-control"  type="file" name="file_tai_len" id="">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <input class="form-control" value="Điền" readonly  type="text" name="dang_cau_hoi" id="">
                </div>
                <div style='margin: 20px 0 0 0;' class='input-group mb-3'>   
                    <input name='da' type='text' class='form-control' placeholder='Nhập đáp án' value="<?php if(isset($_POST['da'])){ echo $_POST['da'];} ?>">
                </div>
                <?php
                    if(isset($_POST['btn'])){
                        $tenCauHoi = trim($_POST['ten_cau_hoi']);
                        $anh = $_FILES['file_tai_len'];
                        $dapAn = trim($_POST['da']);
    
                        $a = checkThemCauHoi($tenCauHoi, $dapAn, $anh);
    
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            if(themCauHoiDien($tenCauHoi, $dapAn, $anh, $idKH)){
                                echo "<div class='alert alert-success text-center' role='alert'>Thêm câu hỏi thành công</div>";
                            }else{
                                echo "<div class='alert alert-warning text-center' role='alert'>Thêm câu hỏi thất bại</div>";
                            }
                        }
                    }
                    
                ?>
                               
                
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm câu hỏi">
                </div>
               
            </div>
            </form>
		
	</main>

    <?php 
        // include 'footer.php'; 
    ?>

</body>

	
</html>