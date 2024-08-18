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
	<title>Duyệt tài khoản</title>
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

        if(isset($_SESSION['tttd1'])){
            if($_SESSION['tttd1']){
                echo "<div class='alert alert-success text-center' role='alert'>Thêm tài khoản vào khóa học thành công</div>";
            }else{
                echo "<div class='alert alert-warning text-center' role='alert'>Thêm tài khoản vào khóa học thất bại</div>";
            }
            unset($_SESSION['tttd1']);
        }

        if(isset($_SESSION['tttd2'])){
            if($_SESSION['tttd2']){
                echo "<div class='alert alert-success text-center' role='alert'>Xóa tài khoản khỏi khóa học thành công</div>";
            }else{
                echo "<div class='alert alert-warning text-center' role='alert'>Xóa tài khoản khỏi khóa học thất bại</div>";
            }
            unset($_SESSION['tttd2']);
        }

        if(isset($_POST['duyet'])){
            $idTK = $_POST['idTaiKhoan'];
            $tt = "";
            if(thayDoiTrangThai($idTK, $idKH)){
                $tt = 1;
            }else{
                $tt = 0;
            }
            $_SESSION['tttd1'] = $tt;
            header("location:them_tai_khoan.php?id_khoa_hoc=$idKH");
        }

        if(isset($_POST['xoa'])){
            $idTK = $_POST['idTaiKhoan'];
            $tt = "";
            if(xoaTaiKhoan($idKH, $idTK)){
                $tt = 1;
            }else{
                $tt = 0;
            }
            $_SESSION['tttd2'] = $tt;
            header("location:them_tai_khoan.php?id_khoa_hoc=$idKH");
        }
    ?>

	<main style="min-height: 100vh; max-width: 100%;">
			
        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Khóa học 
                <?php 
                    echo layTenKhoaHoc($idKH);
                ?>
            </p>
            <a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-primary">Trở lại</a>
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách tài khoản</p>
            <table  class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tài khoản</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th> 
                </tr>
                <?php
                    $a = layTaiKhoan1();
                    $n = count($a);
                    if($n == 0){
                        echo "<tr>
                                <td align='center' colspan='4'>Không có tài khoản nào</td>
                              </tr>";
                    }else{
                        for($i = 0; $i < $n; $i++){
                            $stt = $i + 1;
                            $tenTaiKhoan= $a[$i][1];
                            $tt = trangThai($a[$i][0], $idKH);
                            $trangThai = "";
                            if($tt){
                                $trangThai = "Đã duyệt";
                            }else{
                                $trangThai = "Chưa duyệt";
                            }
                            $thaotac = inThaoTac($tt, $a[$i][0]);
                            echo "
                                <tr>
                                    <td>$stt</td>
                                    <td>$tenTaiKhoan</td>
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
        function layTaiKhoan1(){
            global $conn;
            $sql = "SELECT UserId, UserName 
                    FROM taikhoan 
                    where UserRole = 0";
            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = [$x[0], $x[1]];
                }
            }
            return $a;
        }

        function layThamGia($idTK, $idKH){
            global $conn;
            $sql = "SELECT ThamGiaId
                    FROM thamgia
                    WHERE UserId = $idTK AND CourseId = $idKH";

            $rs = mysqli_query($conn, $sql);
            return mysqli_num_rows($rs);
        }

        function trangThai($idTK, $idKH){
            $n = layThamGia($idTK, $idKH);
            if($n){
                return 1;
            }else{
                return 0;
            }
        }

        function inThaoTac($tt, $idTK){
            $s = "<form method = 'post'>
                    <input type = 'hidden' value = '$idTK' name = 'idTaiKhoan'>";
            if($tt == 0){
                $s .= "<input type = 'submit' value = 'Duyệt' name = 'duyet' class = 'theSubmit btn btn-primary' style = 'background-color: #198754; border-color: #198754;'>";
            }else{
                $s .= "<input type = 'submit' value = 'Xóa' name = 'xoa' class = 'theSubmit btn btn-primary' style = 'background-color: #dc3545; border-color: #dc3545;'>";
            } 
            $s .= "</form>";
            return $s;
        }

        function thayDoiTrangThai($idTK, $idKH){
            global $conn;
            $sql = "INSERT INTO thamgia VALUE(null, $idTK, $idKH)";
            $rs = mysqli_query($conn, $sql);
            return $rs;
        }

        function xoaTaiKhoan($idKH, $idTK){
            global $conn;
            $queryThamGia = "SELECT ThamGiaId FROM thamgia WHERE CourseId = $idKH AND UserId = $idTK";

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
                $queryXoaTG = "DELETE FROM thamgia WHERE CourseId = $idKH AND UserId = $idTK";
                $rs1 = mysqli_query($conn, $queryXoaTG);
                if($rs1 === false){
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }
    ?>

	
</html>