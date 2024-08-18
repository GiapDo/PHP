<?php 
    include '../function.php'; 
    isLogin("dang_nhap.php");
    if(!isset($_GET['id_khoa_hoc'])){
        header("location: khoa_hoc.php");
    }

    $idKH = $_GET['id_khoa_hoc'];

    function checkSoLuongDapAn($sl){
        if($sl == ""){
            return [0, "<p><b>Nhập số lượng đáp án</b></p>"];
        }
        elseif(!is_numeric($sl)){
            return [0, "<p><b>Số lượng đáp án không hợp lệ</b></p>"];
        }
        else{
            if(((float)$sl - (int)$sl) != 0){
                return [0, "<p><b>Số lượng đáp án không hợp lệ</b></p>"];
            }else{
                $sl = (int)$sl;
                if($sl >= 2 && $sl <= 20){
                    return [1, $sl];
                }else{
                    return [0, "<p><b>Số lượng đáp án ít nhất là 2 và nhiều nhất là 20</b></p>"];
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
                <br> Thêm câu hỏi mới
            </p>
			<a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
			</div>
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập số lượng đáp án</label>
                    <input class="form-control"  type="text" name="sl_da" id="" value="<?php if(isset($_POST['sl_da'])){ echo $_POST['sl_da'];} ?>">
                <div>
                <?php
                    if(isset($_POST['btn1'])){
                        $sl = $_POST['sl_da'];
                        $a = checkSoLuongDapAn($sl);
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <br><div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            $_SESSION['slda'] = $a[1];
                            header("location: them_cau_hoi_2.php?id_khoa_hoc=$idKH");
                        }
                    }

                    if(isset($_POST['btn2'])){
                        $sl = $_POST['sl_da'];
                        $a = checkSoLuongDapAn($sl);
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <br><div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            $_SESSION['slda'] = $a[1];
                            header("location: them_cau_hoi_3.php?id_khoa_hoc=$idKH");
                        }
                    }

                    if(isset($_POST['btn3'])){
                        $sl = $_POST['sl_da'];
                        $a = checkSoLuongDapAn($sl);
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <br><div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            $_SESSION['slda'] = $a[1];
                            header("location: them_cau_hoi_4.php?id_khoa_hoc=$idKH");
                        }
                    }

                    if(isset($_POST['btn4'])){
                        $sl = $_POST['sl_da'];
                        $a = checkSoLuongDapAn($sl);
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <br><div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            $_SESSION['slda'] = $a[1];
                            header("location: them_cau_hoi_5.php?id_khoa_hoc=$idKH");
                        }
                    }


                    
                ?>
                               
                
                <div style="margin: 20px 0 0 0;" class="d-flex justify-content-center flex-wrap">
                    <input class="btn btn-primary" name="btn1" type="submit" value="Câu hỏi chọn một đáp án" style="margin-right: 50px;">
                    <input class="btn btn-primary" name="btn2" type="submit" value="Câu hỏi chọn nhiều đáp án" style="margin-right: 50px;">
                    <input class="btn btn-primary" name="btn3" type="submit" value="Câu hỏi sắp xếp lại" style="margin-right: 50px;">
                    <input class="btn btn-primary" name="btn4" type="submit" value="Câu hỏi nối" style="margin-right: 50px;">
                </div>
               
            </div>
            </form>
		
	</main>

    <?php 
        // include 'footer.php'; 
    ?>

</body>

	
</html>