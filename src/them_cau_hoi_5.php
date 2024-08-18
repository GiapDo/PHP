<?php 
    include '../function.php'; 
    isLogin("dang_nhap.php");
    if(!isset($_GET['id_khoa_hoc'])){
        header("location: khoa_hoc.php");
    }

    $idKH = $_GET['id_khoa_hoc'];

    function checkCauHoi($cauhoi){
        $check = 1;
		$s = "";
		$tenAnh = "";
		if(empty($cauhoi)){
			$check = 0;
			$s .= "<p><b>Nhập tên câu hỏi</b></p>";
		}
        if($check == 0){
			return [0, $s];
		}else{
			return [1, ""];
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
            </p>
			<a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data" false>
			</div>
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                    <input class="form-control"  type="text" name="ten_cau_hoi" id="" value="<?php if(isset($_POST['ten_cau_hoi'])){ echo $_POST['ten_cau_hoi'];} if(isset($_SESSION['tencauhoi'])){ echo $_SESSION['tencauhoi'];} ?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <input class="form-control" value="Câu hỏi nối" readonly  type="text" name="dang_cau_hoi" id="">
                </div>
                <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
                    <p class="h3">Cặp đáp án</p>
                    <table  class="table table-striped">
                        <tr>
                            <th style = 'text-align: center;'>STT</th>
                            <th style = 'text-align: center;'>Cột A</th>
                            <th style = 'text-align: center;'>Cột B</th>
                        </tr>

                        <?php 
                            $n = $_SESSION['slda'];
                            for($i = 1; $i <= $n; $i++){
                                $gtri1 = "";
                                $gtri2 = "";
                                if(isset($_POST["input1$i"])){
                                    $gtri1 = $_POST["input1$i"];
                                }
                                if(isset($_POST["input2$i"])){
                                    $gtri2 = $_POST["input2$i"];
                                }
                                echo "<tr>
                                        <th style = 'text-align: center;'>$i</th>
                                        <td>
                                            <input name='input1$i' type='text' class='form-control' value = '$gtri1'>
                                        </td>
                                        <td>
                                            <input name='input2$i' type='text' class='form-control' value = '$gtri2'>
                                        </td>
                                    </tr>
                                    ";
                            }
                        ?>
                
                    </table>
                </div>
                
                <?php
                    if(isset($_POST['btn'])){
                        $tenCauHoi = trim($_POST['ten_cau_hoi']);
                        $sl = $_SESSION['slda'];
                        $a1 = checkCauHoi($tenCauHoi);
                        $check = 1;
                        $da = [];
                        $tt = "";

                        if($a1[0] == 0){
                            $tt .= $a1[1];
                        }else{
                            for($i = 1; $i <= $sl; $i++){
                                if(trim($_POST["input1$i"]) == ""){
                                    $check = 0;
                                    $tt .= "<p><b>Nhập đáp án</b></p>";
                                    break;
                                }
                                if(trim($_POST["input2$i"]) == ""){
                                    $check = 0;
                                    $tt .= "<p><b>Nhập đáp án</b></p>";
                                    break;
                                }
                            }
                            if($check){
                                for($i = 1; $i <= $sl; $i++){
                                    $da[] = [trim($_POST["input1$i"]), trim($_POST["input2$i"])];
                                }

                                // echo "<pre>";
                                // print_r($da);
                                // echo "</pre>";

                                $rs = themcauhoinoi($tenCauHoi, $da, $idKH);
                                if($rs){
                                    echo "<div class='alert alert-success text-center' role='alert'>Thêm câu hỏi thành công</div>";
                                }else{
                                    echo "<div class='alert alert-warning text-center' role='alert'>Thêm câu hỏi thất bại</div>";
                                }
                                
                            }
                        }

                        if($tt != ""){
                            echo "<div class='alert alert-warning text-center' role='alert'>$tt</div>";
                        }
                    }
                    
                ?>
                <div style="margin: 20px 0 0 0;" class="d-flex justify-content-center">
                    <input class="btn btn-primary" name="btn" type="submit" value="Thêm câu hỏi" style="margin-right: 50px;">
                    <a class="btn btn-primary" href="so_luong_dap_an.php?id_khoa_hoc=<?php echo $idKH; ?>">Tạo câu hỏi mới</a>
                </div>  
               
            </div>
            </form>
		
	</main>

    <?php 
        // include 'footer.php'; 
    ?>

    <?php 
        function themcauhoinoi($cauhoi, $da, $idKH){
            global $conn;
            $idTK = $_SESSION['checkTK'][1];
            $loaiTK = $_SESSION['checkTK'][3];
            $trangthai = 0;

            if($loaiTK){
                $trangthai = 1;
            }

            $sql1 = "SELECT ThamGiaId FROM thamgia WHERE UserId = $idTK AND CourseId = $idKH";
		    $rs1 = mysqli_query($conn, $sql1);
		    $idThamGia = mysqli_fetch_row($rs1)[0];

            $sql2 = "INSERT INTO cauhoi value(null, $idThamGia, 5, $trangthai, '$cauhoi', null)";

            $rs2 = mysqli_query($conn, $sql2);
		
		    if($rs2 === false){
			    return 0;
		    }else{
			    $idCauHoi = mysqli_insert_id($conn);
			    for($i = 0; $i < count($da); $i++){
				    $da1 = $da[$i][0];
				    $da2 = $da[$i][1];
				    $stt = $i + 1;
				    $sql3 = "INSERT INTO dapan values
                                (null, $idCauHoi, '$da1', 1, $stt, 1),
                                (null, $idCauHoi, '$da2', 1, $stt, 2)";

				
				    $rs3 = mysqli_query($conn, $sql3);
				    if($rs3 === false){
					    return 0;
				    }
			    }
			return 1;
			
		}
        }
    ?>

</body>

	
</html>