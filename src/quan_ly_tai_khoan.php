<?php 
    include '../function.php'; 

    isLogin("dang_nhap.php");

    if(!$_SESSION['checkTK'][3]){
        header("location: khoa_hoc.php");
    }

    function loai_tk($loai){
        if($loai){
            return "Người duyệt";
        }else{
            return "Người biên tập";
        }
    }

    function inThaoTac($loai, $idTK){
        $s = "<form method = 'post'>
                <input type = 'hidden' value = '$idTK' name = 'idTK'>";
        if($loai){
            $s .= "<input type = 'submit' value = 'Vai trò người biên tập' name = 'duyet2' class = 'theSubmit btn btn-primary' style = 'background-color: #198754; border-color: #198754;'><br>";
        }else{
            $s .= "<input type = 'submit' value = 'Vai trò người duyệt' name = 'duyet1' class = 'theSubmit btn btn-primary' style = 'background-color: #198754; border-color: #198754;'><br>";
        }
        $s .= "<input type = 'submit' value = 'Xóa' name = 'xoa' class = 'theSubmit btn btn-primary' style = 'background-color: #dc3545; border-color: #dc3545;'>
        </form>";
        return $s;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản lý tài khoản</title>
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
		<?php 
            if(isset($_SESSION['tbtk'])){
                if($_SESSION['tbtk'][0] === true && $_SESSION['tbtk'][1] == true && $_SESSION['tbtk'][2] == true){
                    echo "<div class='alert alert-success text-center' role='alert'>Cập nhật trạng thái tài khoản thành công</div>";
                }else{
                    echo "<div class='alert alert-warning text-center' role='alert'>Cập nhật trạng thái tài khoản thất bại</div>";
                }
                unset($_SESSION['tbtk']);
            }

            if(isset($_POST['duyet1'])){
                $idTK = $_POST['idTK'];
                $rs1 = capNhatTrangThaiTaiKhoan($idTK, 1);
                $rs2 = capNhatTrangThaiCauHoi($idTK);
                $rs3 = themVaoKhoaHocChuaThamGia($idTK);
                $_SESSION["tbtk"] = [$rs1, $rs2, $rs3];
                header("location: quan_ly_tai_khoan.php");
            }

            if(isset($_POST['duyet2'])){
                $idTK = $_POST['idTK'];
                $rs1 = capNhatTrangThaiTaiKhoan($idTK, 0);
                $_SESSION["tbtk"] = [$rs1, true, true];
                header("location: quan_ly_tai_khoan.php");
            }
        ?>
        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">
                Quản lý tài khoản
            </p>
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
        </div>
        <div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1% 20%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách tài khoản</p>
            <table  class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tên tài khoản</th>
                    <th>Loại tài khoản</th>
                    <th>Thao tác</th> 
                </tr>
                <?php 
                    $a = layTaiKhoan();
                    $b = [];
                    for($i = 0; $i < count($a); $i++){
                        if($a[$i][0] != $_SESSION['checkTK'][1]){
                            $b[] = $a[$i];
                        }
                    }
                    $a = $b;

                    for($i = 0; $i < count($a); $i++){
                        $stt = $i + 1;
                        $idTK = $a[$i][0];
                        $ten = $a[$i][1];
                        $loaiTK =loai_tk($a[$i][3]);
                        $thaotac = inThaoTac($a[$i][3], $a[$i][0]);
                        echo "<tr>
                                <td>$stt</td>
                                <td>$ten</td>
                                <td>$loaiTK</td>
                                <td style = 'text-align: center;'>$thaotac</td>
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
        function capNhatTrangThaiTaiKhoan($idTK, $loai){
            global $conn;
            $sql = "UPDATE taikhoan
                    SET UserRole = $loai
                    WHERE UserId = $idTK";
            $rs = mysqli_query($conn, $sql);
            return $rs;
        }

        function capNhatTrangThaiCauHoi($idTk){
            global $conn;
            $sql = "UPDATE cauhoi
                    SET QuestionStatus = 1
                    WHERE ThamGiaId in (
                        SELECT ThamGiaId
                        FROM thamgia
                        WHERE UserId = $idTk
                    )";
            $rs = mysqli_query($conn, $sql);
            return $rs;
        }

        function themVaoKhoaHocChuaThamGia($idTK){
            $DSKH = layDanhSachKhoaHocChuaThamGia($idTK);
            $n = count($DSKH);
            if($n >= 1){
                global $conn;
                for($i = 0; $i < $n; $i++){
                    $idKH = $DSKH[$i];
                    $sql = "INSERT INTO thamgia VALUE (null, $idTK, $idKH)";
                    $rs = mysqli_query($conn, $sql);
                    if($rs === false){
                        return false;
                    }
                }
                return true;
            }else{
                return true;
            }
        }

        function layDanhSachKhoaHocChuaThamGia($idTK){
            $a = layIDKhoaHoc();
            $b = layKhoaHocThamGia($idTK);

            $c = [];
            foreach($a as $x){
                $check = 0;
                foreach($b as $y){
                    if($x == $y){
                        $check = 1;
                        break;
                    }
                }
                if(!$check){
                    $c[] = $x;
                }
            }
            return $c;
        }

        function layIDKhoaHoc(){
            global $conn;
            $sql = "SELECT CourseId FROM khoahoc";
            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = $x[0];
                }
            }
            return $a;
        }

        function layKhoaHocThamGia($idTK){
            global $conn;
            $sql = "SELECT CourseId FROM thamgia WHERE UserId = $idTK";
            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = $x[0];
                }
            }
            return $a;
        }
    ?>
</body>
</html>