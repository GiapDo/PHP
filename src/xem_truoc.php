<?php 
    include '../function.php';
    isLogin("dang_nhap.php");
    if(!isset($_GET['id_khoa_hoc']) || !isset($_GET['id_cau_hoi'])){
        header("location: khoa_hoc.php");
    }

    $idKH = $_GET['id_khoa_hoc'];
    $idCH = $_GET['id_cau_hoi'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Xem trước</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
    <?php 
        include 'navbar.php';
        $a = layCauHoi($idCH);
        $b = layDapAn($idCH);
        $dapan = "";
        for($i = 0; $i < count($b); $i++){
            if($b[$i][3]){
                $dapan = $b[$i][2];
            }
        }
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
					<!-- <hr> -->
			
			<div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">
                Khóa học 
                <?php 
                    echo layTenKhoaHoc($idKH);
                ?>
            </p>
			<a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
			</div>
            <div   style="margin: 20px 30%;">
               
                <!-- tên câu hỏi -->
                <div class="form-group">
                    <label for="name_quiz"><h4>
                        Câu hỏi: 
                        <?php
                        if($a[2] == 4){
                            echo nl2br($a[4]);
                        } else{
                            echo $a[4];
                        }
                        ?>
                    </h4></label>
                </div>
                <!-- ảnh câu hỏi -->
                <div class="form-group">
                    <?php 
                        if($a[5]){
                            $anh = $a[5];
                            echo "<img src = '../images/$anh' alt = 'Ảnh câu hỏi' width = '300px'>";
                        }
                    ?>
                </div>

                <?php 
                    if($a[2] == 1){
                        echo "
                            <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                <div class='input-group-text'>
                                    <input name=''  value='' checked  type='checkbox' readonly disabled>
                                </div>
                                <input name='' type='text' class='form-control' value='$dapan' readonly disabled>
                            </div>
                        ";
                    }elseif($a[2] == 2){
                        for($i = 0; $i < count($b); $i++){
                            $dapan = $b[$i][2];
                            if($b[$i][3]){
                                echo "
                                    <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                        <div class='input-group-text'>
                                            <input name=''  value='' checked  type='radio' readonly disabled>
                                        </div>
                                        <input name='' type='text' class='form-control bg-success text-white' value='$dapan' disabled>
                                    </div>
                                ";
                            }else{
                                echo "
                                    <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                        <div class='input-group-text'>
                                            <input name=''  value='' type='radio' readonly disabled>
                                        </div>
                                        <input name='' type='text' class='form-control' value='$dapan' disabled>
                                    </div>
                                ";
                            }
                        }
                    }elseif($a[2] == 3){
                        for($i = 0; $i < count($b); $i++){
                            $dapan = $b[$i][2];
                            if($b[$i][3]){
                                echo "
                                    <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                        <div class='input-group-text'>
                                            <input name=''  value='' checked  type='checkbox' readonly disabled>
                                        </div>
                                        <input name='' type='text' class='form-control bg-success text-white' value='$dapan' disabled>
                                    </div>
                                ";
                            }else{
                                echo "
                                    <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                        <div class='input-group-text'>
                                            <input name=''  value='' type='checkbox' readonly disabled>
                                        </div>
                                        <input name='' type='text' class='form-control' value='$dapan' disabled>
                                    </div>
                                ";
                            }
                        }
                    }elseif($a[2] == 4){
                        for($i = 0; $i < count($b); $i++){
                            $stt = $i + 1;
                            $dapan = $b[$i][2];
                            echo "
                                    <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                        <div class='input-group-text'>
                                            <b>$stt</b>
                                        </div>
                                        <input name='' type='text' class='form-control bg-success text-white' value='$dapan' disabled>
                                    </div>
                                ";
                        }
                    }elseif($a[2] == 5){

                        echo "<div class='d-flex flex-wrap flex-column align-items-center' style='padding: 1%;margin: 5% 0 0 0; '>
                        <p class='h3'>Cặp đáp án</p>
                        <table  class='table table-striped'>
                            <tr>
                                <th style = 'text-align: center;'>STT</th>
                                <th style = 'text-align: center;'>Cột A</th>
                                <th style = 'text-align: center;'>Cột B</th>
                            </tr>";
                            $cnt = 1;
                            for($i = 0; $i < count($b); $i += 2){
                                $gtri1 = $b[$i][2];
                                $gtri2 = $b[$i+1][2];
                                    echo "<tr>
                                            <th style = 'text-align: center;'>$cnt</th>
                                            <td>
                                                <input name='input1$i' type='text' class='form-control' value = '$gtri1' readonly disabled>
                                            </td>
                                            <td>
                                                <input name='input2$i' type='text' class='form-control' value = '$gtri2' readonly disabled>
                                            </td>
                                        </tr>
                                        ";
                                $cnt += 1;
                            }
                        echo "
                        </table>
                        </div>";
                    }elseif($a[2] == 6){
                        $b1 = [];
                        
                        $b1 = [];

                        foreach ($b as $x) {
                            $key = $x[5]; 

                            if (!array_key_exists($key, $b1)) {
                                $b1[$key] = [];
                            }
                            $b1[$key][] = $x;
                        }

                        echo "<div class='d-flex flex-wrap flex-column align-items-center' style='padding: 1%;margin: 5% 0 0 0; '>
                                <p class='h3'>Danh mục phân loại đáp án</p>
                                <table  class='table table-striped'>";
                        
                        echo "<tr style = 'text-align: center;'>
                                <th style='border-right: 2px solid #fff;'>Tên Danh Mục</th>
                                <th>Các đáp án</th>
                              </tr>";

                        foreach($b1 as $x => $y){
                            $s1 = "";
                            $s2 = "";
                            for($i = 0; $i < count($y); $i++){
                                if($b1[$x][$i][4] == 0){
                                    $tenDM = $b1[$x][$i][2];
                                    $s1 .= "<input type='text' class='form-control text-center font-weight-bold' value='$tenDM' readonly disabled>";
                                }else{
                                    $tenDA = $b1[$x][$i][2];
                                    $s2 .= "<input type='text' class='form-control mb-3' value='$tenDA' readonly disabled>";
                                }
                            }
                            echo "<tr>
                                    <td>$s1</td>
                                    <td>$s2</td>
                                </tr>";
                        }

                        echo "</div></table>";
                    }
                ?>
               
            </div>
            </form>
		
	</main>

    <?php include 'footer.php'; ?>

</body>

	
</html>