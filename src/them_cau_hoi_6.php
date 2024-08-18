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
                    <input class="form-control" value="Câu hỏi phân loại" readonly  type="text" name="dang_cau_hoi" id="">
                </div>
                <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">

                    <table  class="table table-striped">
                    <?php 
                        $sl_dm = $_SESSION['sl'][0];
                        echo "<tr>";
                        for($i = 1; $i <= $sl_dm; $i++){
                            $tenDanhMuc = "";
                            if(isset($_POST["danh_muc_"."$i"])){ 
                                $tenDanhMuc =  $_POST["danh_muc_"."$i"];
                            }
                            echo "<th>
                                    <input name='danh_muc_"."$i' type='text' class='form-control text-center font-weight-bold' placeholder='Nhập tên danh mục' value='$tenDanhMuc'>
                            </th>";
                        }
                        echo "</tr>";

                        $sl_da = $_SESSION['sl'][1];
                        for ($i = 1; $i <= $sl_da; $i++) {
                            echo "<tr>";
                            for ($j = 1; $j <= $sl_dm; $j++) {
                                $dapAn = "";
                                if (isset($_POST["dap_an_" . $j . "_" . $i])) { 
                                    $dapAn = $_POST["dap_an_" . $j . "_" . $i];
                                }
                                echo "<td>
                                    <input name='dap_an_" . $j . "_" . $i . "' type='text' class='form-control' placeholder='Nhập đáp án' value='$dapAn'>
                                </td>";
                            }
                            echo "</tr>";
                        }
                        
                    ?>
                    
                    </table>
                </div>
                <?php
                    if(isset($_POST['btn'])){
                        $tenCauHoi = trim($_POST['ten_cau_hoi']);
                        $anh = $_FILES['file_tai_len'];
                        $dm = [];
                        for($i = 1; $i <= $sl_dm; $i++){
                            $dm[] = trim($_POST["danh_muc_"."$i"]);
                        }

                        $da = [];
                        for($i = 1; $i <= $sl_dm; $i++){
                            $da1 = [];
                            for($j = 1; $j <= $sl_da; $j++){
                                $da1[] = trim($_POST["dap_an_" . $i . "_" . $j]);
                            }
                            $da[] = $da1;
                        }
                        
                        // echo "<pre>";
                        // print_r($da);
                        // echo "</pre>";
                        
                        $a = checkCauHoi($tenCauHoi, $anh, $dm, $da);
                        
                        if($a[0] == 0){
                            $tt = $a[1];
                            echo "
                                <div class='alert alert-warning text-center' role='alert'>$tt</div>
                            ";
                        }else{
                            $da1 = loaiBoPhanTuRong($da);
                            // echo "<pre>";
                            // print_r($da1);
                            // echo "</pre>";
                            if(themCauHoiPhanLoai($tenCauHoi, $anh, $dm, $da1, $idKH)){
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

    <?php 
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

        function kiemTraTrung($a, $ptu) {
            $count = 0;
            foreach ($a as $x) {
                if (strtolower($x) == strtolower($ptu)) {
                    $count++;
                    if ($count > 1) {
                        return false;
                    }
                }
            }
            return true;
        }

        function checkDanhMuc($dm){
            for($i = 0; $i < count($dm); $i++){
                if($dm[$i] == ""){
                    return [0, "<p><b>Nhập tên danh mục</b></p>"];
                }
                if(!kiemTraTrung($dm, $dm[$i])){
                    return [0, "<p><b>Tên danh mục bị trùng</b></p>"];
                }
            }
            return [1, ""];
        }

        function checkRong($a){
            $cnt = 0;
            for($i = 0; $i < count($a); $i++){
                if($a[$i] != ""){
                    $cnt++;
                }
            }
            return $cnt == 0;
        }

        function checkDapAn($a){
            for($i = 0; $i < count($a); $i++){
                if(checkRong($a[$i])){
                    return [0, "Nhập ít nhất một đáp án cho danh mục"];
                }
            }
            return [1, ""];
        }

        function checkCauHoi($cauhoi, $anh, $dm, $da){
            $check = 1;
            $s = "";
            $tenAnh = "";
            if($cauhoi == ""){
                $check = 0;
                $s .= "<p><b>Nhập tên câu hỏi</b></p>";
            }
    
            if(isset($anh) && !empty($anh['name'])){
                $tenAnh = $anh['name'];
                if(!checkAnh($tenAnh)){
                    $check = 0;
                    $s .= "<p><b>Ảnh không hợp lệ</b></p>";
                }
            }

            $a1 = checkDanhMuc($dm);
            $a2 = checkDapAn($da);

            if($a1[0] == 0){
                $s .= $a1[1];
                $check = 0;
            }

            if($a2[0] == 0){
                $s .= $a2[1];
                $check = 0;
            }
    
            if($check == 0){
                return [0, $s];
            }else{
                return [1, ''];
            }
        }

        function loaiBoPhanTuRong($a){
            $b = [];
            $n = count($a);
            $m = count($a[0]);
            for($i = 0; $i < $n; $i++){
                $c = [];
                for($j = 0; $j < $m; $j++){
                    if($a[$i][$j] != ""){
                        $c[] = $a[$i][$j];
                    }
                }
                $b[] = $c;
            }
            return $b;
        }

        function themCauHoiPhanLoai($tenCauHoi, $anh, $dm, $da, $idKH){
            global $conn;

            $tenAnh = taiAnh($anh);
            $idTK = $_SESSION['checkTK'][1];
		    $loaiTK = $_SESSION['checkTK'][3];

            $idTG =  layIDThamGia($idTK, $idKH);
            $trangthai = 0;
		    if($loaiTK){
			    $trangthai = 1;
		    }
            $sql = "";
            if($tenAnh == null){
                $sql = "INSERT INTO cauhoi value(null, $idTG, 6, $trangthai, '$tenCauHoi', null)";
            }else{
                $sql = "INSERT INTO cauhoi value(null, $idTG, 6, $trangthai, '$tenCauHoi', '$tenAnh')";
            }

            $rs = mysqli_query($conn, $sql);
            
            if($rs === false){
                return false;
            }else{
                $idCauHoi = mysqli_insert_id($conn);
                for($i = 0; $i < count($dm); $i++){
                    $tenDanhMuc = $dm[$i];
                    $stt1 = $i + 1;
                    $sql1 = "INSERT INTO dapan value(null, $idCauHoi, '$tenDanhMuc', 1, 0, $stt1)";
                    $rs1 = mysqli_query($conn, $sql1);
                    if($rs1 === false){
                        return false;
                    }else{
                        for($j = 0; $j < count($da[$i]); $j++){
                            $tenDapAn = $da[$i][$j];
                            $stt2 = $j + 1;
                            $sql2 = "INSERT INTO dapan value(null, $idCauHoi, '$tenDapAn', 1, $stt2, $stt1)";
                            $rs2 = mysqli_query($conn, $sql2);
                            if($rs2 === false){
                                return false;
                            }
                        }
                    }
                }
                return true;
            }

        }
    ?>


</body>

	
</html>