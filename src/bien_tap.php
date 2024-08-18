<?php 
    include '../function.php'; 
    isLogin("dang_nhap.php");

    if(!isset($_GET['id_khoa_hoc'])){
        header("location: khoa_hoc.php");
    }
    $idKH = $_GET['id_khoa_hoc'];

    function trangThai($tt){
        if($tt){
            return "Đã duyệt";
        }else{
            return "Chưa duyệt";
        }
    }

    function inThaoTac($tt, $idCauHoi){
        $s = "<form method = 'post'>
                    <input type = 'hidden' value = '$idCauHoi' name = 'idCauHoi'>
                    <input type = 'submit' value = 'Xem trước' name = 'xem_truoc' class = 'theSubmit btn btn-primary' style = 'background-color: #0dcaf0; border-color: #0dcaf0;'>";
        if($_SESSION['checkTK'][3]){
            if($tt == 0){
                $s .= "<input type = 'submit' value = 'Duyệt' name = 'duyet' class = 'theSubmit btn btn-primary' style = 'background-color: #198754; border-color: #198754;'>";
            }
            $s .= "<input type = 'submit' value = 'Xóa' name = 'xoa' class = 'theSubmit btn btn-primary' style = 'background-color: #dc3545; border-color: #dc3545;'>";
        }
        $s .= "</form>";
        return $s;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Biên tập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
    <style>
        img{
            max-width: 400px;
        }
        a{
            text-decoration: none;
            color: white;
        }

        .theSubmit{
            color: #fff;
            text-align: center;
            line-height: 30px;
            margin: 5px;
        }

    </style>
</head>
<body>
    <?php 
        include 'navbar.php';
    ?>

    <?php 
        if(isset($_SESSION['ThongBao1'])){
            $rs = $_SESSION['ThongBao1'];
            if($rs === true){
                echo "<div class='alert alert-success text-center' role='alert'>Cập nhật trạng thái câu hỏi thành công</div>";
            }else{
                echo "<div class='alert alert-warning text-center' role='alert'>Cập nhật trạng thái câu hỏi thất bại</div>";
            }
            unset($_SESSION['ThongBao1']);
        }

        if(isset($_SESSION['ThongBao2'])){
            $rs = $_SESSION['ThongBao2'];
            if($rs === true){
                echo "<div class='alert alert-success text-center' role='alert'>Xóa câu hỏi thành công</div>";
            }else{
                echo "<div class='alert alert-warning text-center' role='alert'>Xóa câu hỏi thất bại</div>";
            }
            unset($_SESSION['ThongBao2']);
        }

        if(isset($_POST['duyet'])){
            $idCauHoi = $_POST['idCauHoi'];
            $sql = "UPDATE cauhoi
                     SET QuestionStatus = 1
                     WHERE QuestionID = $idCauHoi";
            $rs = mysqli_query($conn, $sql);
            $_SESSION['ThongBao1'] = $rs;
            header("location: bien_tap.php?id_khoa_hoc=$idKH");
        }

        if(isset($_POST['xoa'])){
            $idCauHoi = $_POST['idCauHoi'];
            $sql1 = "DELETE FROM dapan
                     WHERE QuestionID = $idCauHoi";
            $rs1 = mysqli_query($conn, $sql1);
            if($rs1){
                xoaAnh($idCauHoi);
                $sql2 =  "DELETE FROM cauhoi
                         WHERE QuestionID = $idCauHoi";
                $rs2 = mysqli_query($conn, $sql2);
                $_SESSION['ThongBao2'] = $rs2;
                header("location: bien_tap.php?id_khoa_hoc=$idKH");
            }else{
                $_SESSION['ThongBao2'] = $rs1;
                header("location: bien_tap.php?id_khoa_hoc=$idKH");
            }
        }

        if(isset($_POST['xem_truoc'])){
            $idCauHoi = $_POST['idCauHoi'];
            header("location: xem_truoc.php?id_khoa_hoc=$idKH&&id_cau_hoi=$idCauHoi");
        }
    ?>

	<main style="min-height: 100vh; max-width: 100%;">
			
        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Khóa học 
                <?php 
                    echo layTenKhoaHoc($idKH);
                ?>
            </p>
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
           
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
            Thêm câu hỏi
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="them_cau_hoi_1.php?id_khoa_hoc=<?php echo $idKH; ?>">Câu hỏi điền</a></li>
                <li><a class="dropdown-item" href="so_luong_dap_an.php?id_khoa_hoc=<?php echo $idKH; ?>">Câu hỏi nhiều lựa chọn</a></li>
                <li><a class="dropdown-item" href="so_luong_dap_an_1.php?id_khoa_hoc=<?php echo $idKH; ?>">Câu hỏi phân loại</a></li>
            </ul>
            
            <a href="luyen_tap.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-primary">Luyện tập</a>
            <?php 
                if($_SESSION['checkTK'][3]){
                    echo "<a href='them_tai_khoan.php?id_khoa_hoc=$idKH' class='btn btn-primary'>Duyet tai khoan</a>";
                }
            ?>
            
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách câu hỏi</p>
            <table  class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tên câu hỏi</th>
                    <th>Loại câu hỏi</th>
                    <th>Đáp án</th>
                    <th>Tác giả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th> 
                </tr>
                <?php
                    $a = danhSachCauhoi($idKH);
                    $n = count($a);
                    if($n == 0){
                        echo "<tr>
                                <td align='center' colspan='6'>Không có câu hỏi nào</td>
                              </tr>";
                    }else{
                        for($i = 0; $i < $n; $i++){
                            $stt = $i + 1;
                            $tenCauHoi = $a[$i][1];
                            if($a[$i][2] == 4){
                                $tenCauHoi = nl2br($a[$i][1]);
                            }
                            $loaiCauHoi = loaiCauHoi($a[$i][2]);
                            $dapAn = layDapAnDung($a[$i][3], $a[$i][2]);
                            $tacgia = layTacGia($a[$i][4]);
                            $trangThai = trangThai($a[$i][5]);
                            $thaotac = inThaoTac($a[$i][5], $a[$i][0]);
                            echo "
                                <tr>
                                    <td>$stt</td>
                                    <td>$tenCauHoi</td>
                                    <td>$loaiCauHoi</td>
                                    <td>$dapAn</td>
                                    <td>$tacgia</td>
                                    <td>$trangThai</td>
                                    <td>$thaotac</td> 
                                </tr>
                            ";
                        }
                    }
                ?>
                
            </table>
        </div>
	</main>
    <?php 
        // include 'footer.php'; 
    ?>
</body>

    <?php 
        function xoaAnh($id){
            global $conn;
            $sql = "SELECT QuestionImage FROM cauhoi where QuestionID = $id";
            $rs = mysqli_query($conn, $sql);
            $tenAnh = mysqli_fetch_row($rs)[0];
            $duongDanAnh = "../images/" . $tenAnh;
            unlink($duongDanAnh);
        }
    ?>

	
</html>