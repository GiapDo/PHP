<?php
    include '../function.php'; 
    isLogin("dang_nhap.php");
    if(!isset($_GET['id_khoa_hoc'])){
        header("location: khoa_hoc.php");
    }

    $idKH = $_GET['id_khoa_hoc'];

    function checkCauHoiMotDapAN($cauhoi, $anh){
        $check = 1;
        $s = "";
        $tenAnh = "";
        if(empty($cauhoi)){
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="  sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
            <form method="POST" enctype="multipart/form-data">
            </div>
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                    <input class="form-control"  type="text" name="ten_cau_hoi" id="" value="<?php if(isset($_POST['ten_cau_hoi'])){ echo $_POST['ten_cau_hoi'];} if(isset($_SESSION['tencauhoi'])){ echo $_SESSION['tencauhoi'];} ?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label>
                    <input class="form-control"  type="file" name="file_tai_len" id="">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <input class="form-control" value="Chọn một đáp án" readonly  type="text" name="dang_cau_hoi" id="">
                </div>
                <div id ='hienthi'>
                    <div id = 'dapan'>
                        <?php 
                            $n = $_SESSION['slda'];
                            for($i = 1; $i <= $n; $i++){
                                $chon = "";
                                $gtri = "";
                                if(isset($_POST["dapAnDuocChon"]) && $_POST["dapAnDuocChon"] == $i){
                                    $chon = "checked";
                                }
                                if(isset($_POST["input$i"])){
                                    $gtri = $_POST["input$i"];
                                }
                                echo "
                                    <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                                        <div class='input-group-text'>
                                            <input name='dapAnDuocChon' value='$i' type='radio' $chon>
                                        </div>
                                        <input name='input$i' type='text' class='form-control' value = '$gtri'>
                                    </div>
                                 ";
                            }
                        ?>
                    </div>
            
                    <?php
                        if(isset($_POST['btn'])){
                            $tenCauHoi = trim($_POST['ten_cau_hoi']);
                            $anh = $_FILES['file_tai_len'];
                            $sl = $_SESSION['slda'];
                            $a1 = checkCauHoiMotDapAN($tenCauHoi, $anh);
                            $check = 1;
                            $da1 = [];
                            $tt = "";
                            $pos = 0;

                            if($a1[0] == 0){
                                $tt .= $a1[1];
                            }else{
                                for($i = 1; $i <= $sl; $i++){
                                    if(trim($_POST["input$i"]) == ""){
                                        $check = 0;
                                        $tt .= "<p><b>Nhập đáp án</b></p>";
                                        break;
                                    }
                                }

                                if($check){
                                    if(isset($_POST['dapAnDuocChon'])){
                                        $pos = $_POST['dapAnDuocChon'];
                                    }else{
                                        $check = 0;
                                        $tt .= "<p><b>Vui lòng chọn đáp án đúng</b></p>";
                                    }
                            }
                            

                            if($check){
                                for($i = 1; $i <= $sl; $i++){
                                    if($i == $pos){
                                        $da1[] = [1, trim($_POST["input$i"])];
                                    }else{
                                        $da1[] = [0, trim($_POST["input$i"])];
                                    }
                                }

                                $rs = themCauHoiMotDapAn($tenCauHoi, $da1, $anh, $idKH, 2);
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
                </div>

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
    
</body>

    
</html>