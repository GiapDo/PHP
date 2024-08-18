<?php 
    include '../function.php'; 

    isLogin("dang_nhap.php");

    if(!$_SESSION['checkTK'][3]){
        header("location: khoa_hoc.php");
    }


    function inThaoTac($idKH){
        $s = "<form method = 'post'>
                <input type = 'hidden' value = '$idKH' name = 'idKH'>
                <input type = 'submit' value = 'Truy cập' name = 'truycap' class = 'theSubmit btn btn-primary m-r-3' style = 'background-color: #198754; border-color: #198754; margin-right: 5px;'>
                <input type = 'submit' value = 'Xóa' name = 'xoa' class = 'theSubmit btn btn-primary' style = 'background-color: #dc3545; border-color: #dc3545;'>
            </form>";
        return $s;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản lý khóa học</title>
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
        }

        th {
            text-align: center; 
        }

    </style>
</head>
<body>
    <?php 
        include 'navbar.php';
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
		
        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">
                Quản lý khóa học
            </p>
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
            <a href="Them_khoa_hoc.php" class="btn btn-primary">Thêm khóa học</a>
        </div>
        <?php
            if(isset($_SESSION['tb'])){
                if($_SESSION['tb']){
                    echo "<div class='alert alert-success text-center' role='alert'>Xóa khóa học thành công</div>";
                }else{
                    echo "<div class='alert alert-warning text-center' role='alert'>Xóa khóa học thất bại</div>";
                }
                unset($_SESSION['tb']);
            } 
            if(isset($_POST['truycap'])){
                $idKH = $_POST['idKH'];
                header("location: bien_tap.php?id_khoa_hoc=$idKH");
            }

            if(isset($_POST['xoa'])){
                $idKH = $_POST['idKH'];
                $rs = xoaKhoaHoc($idKH);
                $_SESSION["tb"] = $rs;
                header("location: quan_ly_khoa_hoc.php");
            }
        ?>
        <div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1% 0;margin: 5% 20% 0 20%; ">
            
        <p class="h3">Danh sách khóa học</p>
            <table  class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tên khóa học</th>
                    <th>Số lượng câu hỏi</th>
                    <th>Thao tác</th> 
                </tr>
                <?php 
                    $a = layKhoaHoc();
                    for($i = 0; $i < count($a); $i++){
                        $stt = $i + 1;
                        $ten = $a[$i][1];
                        $sl = laySoLuongCauHoi($a[$i][0]);
                        $tt = inThaoTac($a[$i][0]);
                        echo "<tr style='color: #ff6500;'>
                                <td style='border-right: 1px solid #000; text-align: center;'>$stt</td>
                                <td style='border-right: 1px solid #000; font-weight: bold;'>$ten</td>
                                <td style='border-right: 1px solid #000; text-align: center;'>$sl</td>
                                <td style = 'text-align: center;'>$tt</td>
                              </tr>";
                    }
                ?>
            </table>
            
        </div>
	</main>
    <?php 
        // include 'footer.php'; 
    ?>
    <?php 
        function layDanhSachKhoaHoc(){
            global $conn;
            $sql = "SELECT * FROM khoahoc";
            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = [$x[0], $x[1]];
                }
            }
            return $a;
        }

        function laySoLuongCauHoi($idKH){
            global $conn;
            $sql = "SELECT COUNT(*)
                    FROM cauhoi
                    WHERE ThamGiaId in (
                        SELECT ThamGiaId
                        FROM thamgia
                        WHERE CourseId = $idKH
                    )";
            $rs = mysqli_query($conn, $sql);
            if(mysqli_num_rows($rs)){
                return mysqli_fetch_row($rs)[0];
            }
            return 0;
        }

        function xoaKhoaHoc($idKH){
            global $conn;
            $queryThamGia = "SELECT ThamGiaId FROM thamgia WHERE CourseId = $idKH";

            $resultThamGia = mysqli_query($conn, $queryThamGia);

            if ($resultThamGia) {
                while ($rowThamGia = mysqli_fetch_assoc($resultThamGia)) {
                    $thamGiaId = $rowThamGia['ThamGiaId'];

                    $queryDapan = "DELETE FROM dapan 
                                   WHERE QuestionID IN (
                                    SELECT QuestionID 
                                    FROM cauhoi 
                                    WHERE ThamGiaId = $thamGiaId)";
                    $rs = mysqli_query($conn, $queryDapan);
                    
                    if($rs){
                        $queryCauhoi = "DELETE FROM cauhoi WHERE ThamGiaId = '$thamGiaId'";
                        $rs1 = mysqli_query($conn, $queryCauhoi);
                        if($rs1 === false){
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
                $queryThamGia = "DELETE FROM thamgia WHERE CourseId = $idKH";
                $rs = mysqli_query($conn, $queryThamGia);
                if($rs){
                    echo "Hi1";
                    $queryKhoahoc = "DELETE FROM khoahoc WHERE CourseId = $idKH";
                    $tenAnh = layTenAnh($idKH);
                    $rs1 = mysqli_query($conn, $queryKhoahoc);
                    if($rs1 === false){
                        return false;
                    }else{
                        $duongDanAnh = "../images/" . $tenAnh;
                        unlink($duongDanAnh);
                    }
                }else{
                    return false;
                }

                return true;
            } else {
                return false;
            }
        }

        function layTenAnh($id){
            global $conn;
            $sql = "SELECT CourseImage FROM khoahoc where CourseId = $id";
            $rs = mysqli_query($conn, $sql);
            return mysqli_fetch_row($rs)[0];
        }
    ?>
    
</body>
</html>