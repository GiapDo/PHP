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
	<title>Luyện tập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
    <style>
        img{
            max-width: 400px;
        }
    </style>
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
           
        </div>
        
       <?php

            $a = lay10CauHoi($idKH);

           // echo "<pre>";
           // print_r($a);
           // echo "</pre>";
           if(count($a) > 10){
            $b = [];
            for($i = 0; $i < count($a); $i++){
                $b[] = $a[$i];
            }
            $a = $b;
           }

           if (isset($_POST['btn'])){
            $diem = 0;
            for($i = 0; $i < count($a); $i++){
                $idCH = $a[$i][0];
                $d = layDa($idCH);
                if ($a[$i][2] == 1) {
                    $name = "answer_".$idCH;
                    $da1 = trim($_POST[$name]);
                    if($da1 == $d[0][1]){
                        $diem += 1;
                    }
                }else if($a[$i][2] == 2){
                    $name = "id_".$idCH;
                    $idDa = "";
                    if(isset($_POST[$name])){
                        $idDa = $_POST[$name];
                        for($j = 0; $j < count($d); $j++){
                            if($d[$j][2] == 1){
                                if($idDa == $d[$j][0]){
                                    $diem++;
                                }
                            }
                        }
                    }
                }else if($a[$i][2] == 3){
                    $sld = 0;
                    $sld1 = 0;
                    for($j = 0; $j < count($d); $j++){
                        if($d[$j][2] == 1){
                            $sld += 1;
                        }
                    }
                    for($j = 0; $j < count($d); $j++){
                        $name = "id_".$a[$i][0]."_".$d[$j][0];
                        $idDa = "";
                        if(isset($_POST[$name])){
                            $idDa = $_POST[$name];
                            if($d[$j][2] == 1){
                                if($d[$j][2] == 1){
                                    if($idDa == $d[$j][0]){
                                        $sld1 += 1;
                                    }
                                }
                            }
                        }
                    }
                    if($sld == $sld1){
                        $diem += 1;
                    }
                }
            }
            $_SESSION['diem'] = $diem;
            header("location: thong_bao.php");
        }
           
            $s = "<form method='post'>";
            $s .= "<div class='container mt-4'>";
            for ($i = 0; $i < count($a); $i++) {
                $s .= "<div class='card mb-3 col-md-6 mx-auto'>";
                $s .= "<div class='card-body'>";
                $s .= "<h6 class='card-title'>Câu " . ($i + 1) . ": " . $a[$i][4] . "</h6>";
           
                if ($a[$i][5]) {
                    $anh = $a[$i][5];
                    $s .= "<img src='../images/$anh' class='img-fluid mb-3' alt='Ảnh câu hỏi' style='max-width: 300px; height: auto;'>";
                }
           
                if ($a[$i][2] == 1) {
                    $gtr = "";
                    $thuoctinh = "";
                    $tt1 = "";
                    $name = "answer_".$a[$i][0];
                    if(isset($_POST[$name])){
                        $gtr = $_POST[$name];
                        $c = layDa($a[$i][0]);
                        if($gtr == $c[0][1]){
                            $thuoctinh = "bg-success text-white";
                        }else{
                            $thuoctinh = "bg-danger text-white";
                        }
                        $tt1 = "disabled";
                    }

                    
                    $s .= "<input name='$name' type='text' class='form-control mb-3 $thuoctinh' placeholder='Nhập câu trả lời' value = '$gtr' $tt1>";
                }else if($a[$i][2] == 2){
                    $b = layDa($a[$i][0]);
                    $n = count($b);
                    for($j = 0; $j < $n; $j++){
                        $da = $b[$j][1];
                        $chon = "";
                        $thuoctinh = "";
                        $name = "id_".$a[$i][0];
                        if(isset($_POST[$name]) && $_POST[$name] == $b[$j][0]){
                            $gtr = $_POST[$name];
                            $c = dapandung($gtr);
                            if($c == 1){
                                $thuoctinh = "bg-success text-white";
                            }else{
                                $thuoctinh = "bg-danger text-white";
                            }
                            $chon = "checked";
                        }
                        

                        $s .= "
                                <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                    <div class='input-group-text'>
                                        <input name='id_".$a[$i][0]."' type='radio' value = '".$b[$j][0]."' $chon>
                                    </div>
                                    <input name='' type='text' class='form-control $thuoctinh' value='$da'>
                                </div>
                            ";
                    }
                }else if($a[$i][2] == 3){
                    $b = layDa($a[$i][0]);
                    $n = count($b);
                    for($j = 0; $j < $n; $j++){
                        $da = $b[$j][1];
                        $chon = "";
                        $thuoctinh = "";
                        $name = "id_".$a[$i][0]."_".$b[$j][0];
                        if(isset($_POST[$name]) && $_POST[$name] == $b[$j][0]){
                            $gtr = $_POST[$name];
                            $c = dapandung($gtr);
                            if($c == 1){
                                $thuoctinh = "bg-success text-white";
                            }else{
                                $thuoctinh = "bg-danger text-white";
                            }
                            $chon = "checked";
                        }
                        $s .= "
                                <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                    <div class='input-group-text'>
                                        <input name='id_".$a[$i][0]."_".$b[$j][0]."'  value='".$b[$j][0]."' type='checkbox' $chon>
                                    </div>
                                    <input name='' type='text' class='form-control $thuoctinh' value='$da'>
                                </div>
                            ";
                    }
                }
           
                $s .= "</div>"; // .card-body
                $s .= "</div>"; // .card
            }
                $s .= " <div class='text-center mt-4'>
                            <input class='btn btn-primary btn-block' name='btn' type='submit' value='Nộp bài'>
                        </div>";
            $s .= "</div>"; // .container
            $s .= "</form>";
           
            echo $s; 

            
       ?>
	</main>
    <?php 
        include 'footer.php'; 
    ?>

    <?php 
        function lay10CauHoi($idKH){
            global $conn;

            $sql = "SELECT *
                    FROM cauhoi
                    where QuestionStatus = 1 AND QuestionType IN(1, 2, 3) AND ThamGiaId in (
                        SELECT ThamGiaId
                        FROM thamgia
                        WHERE CourseId = $idKH
                    )";
            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = [$x[0], $x[1], $x[2], $x[3], $x[4], $x[5]];
                }
            }
            return $a;
        }

        function layDa($idCH){
            global $conn;
            $sql = "SELECT AnswerId, AnswerContent, CorrectAnswer
                    FROM dapan
                    WHERE QuestionID = $idCH";

            $rs = mysqli_query($conn, $sql);
            $a = [];
            if(mysqli_num_rows($rs)){
                while($x = mysqli_fetch_row($rs)){
                    $a[] = [$x[0], $x[1], $x[2]];
                }
            }
            return $a;
        }

        function dapandung($idDA){
            global $conn;
            $sql = "SELECT CorrectAnswer
                    FROM dapan
                    WHERE AnswerId = $idDA";
            $rs = mysqli_query($conn, $sql);
            return mysqli_fetch_row($rs)[0];
        }
    ?>
</body>
</html>