<?php
	session_start();
	include 'connectdb.php';

	function layTaiKhoan(){
		global $conn;
		$sql = "SELECT * FROM taikhoan";
		$rs = mysqli_query($conn, $sql);
		$a = [];
		if(mysqli_num_rows($rs)){
			while($row = mysqli_fetch_row($rs)){
				$a[] = [$row[0], $row[1], $row[2], $row[3]];
			}
		}
		return $a;
	}

	function layTenKhoaHoc($idKH){
		global $conn;
		$sql = "SELECT CourseName
				FROM khoahoc
				WHERE CourseId = $idKH";
		$rs = mysqli_query($conn, $sql);
		return mysqli_fetch_row($rs)[0];
	}

	function layCauHoi($idCH){
		global $conn;
		$sql = "SELECT *
				FROM cauhoi
				WHERE QuestionID = $idCH";
		$rs = mysqli_query($conn, $sql);
		return mysqli_fetch_row($rs);
	}

	function layKhoaHoc(){
		global $conn;
		$idTK = $_SESSION['checkTK'][1];
		$sql = "SELECT * 
				FROM khoahoc 
				WHERE CourseId in (
					SELECT CourseId
					FROM thamgia
					WHERE UserId = $idTK
				)";
		$rs = mysqli_query($conn, $sql);
		$a = [];
		if(mysqli_num_rows($rs)){
			while($row = mysqli_fetch_row($rs)){
				$a[] = [$row[0], $row[1], $row[2], $row[3]];
			}
		}
		return $a;
	}

    
	function isLogin($s1){
		if(!isset($_SESSION['checkTK'])){
			header("location: $s1");
		}else{
			if($_SESSION['checkTK'][0] == 0){
				header("location: $s1");
			}
		}
	}
    
    function checkLogin($username, $password)
	{
		$check = 1;
		$s = "";
		if(empty($username)){
			$check = 0;
			$s = "<p><b>Nhập tên tài khoản</b></p>";
		}

		if(empty($password)){
			$check = 0;
			$s .= "<p><b>Nhập mật khẩu</b></p>";
		}

		if($check == 0){
			return [$check, $s];
		}else{
			$a = layTaiKhoan();
			$n = count($a);
			if($n > 0){
				for($i = 0; $i < $n; $i++){
					if($a[$i][1] == $username){
						if($a[$i][2] == md5($password)){
							return [1, $a[$i][0], $a[$i][3]];
						}else{
							return [0, "<p><b>Mật khẩu nhập sai</b></p>"];
						}
					}
				}
				return [0, "<p><b>Tài khoản không tồn tại</b></p>"];
			}
		}
	}

	function inKhoaHoc($anh, $mota, $ten, $idKH){
		echo "<div class='col'>
				<div class='card'>
					<img src='../images/$anh' class='card-img-top' alt='Course Image'>
					<div class='card-body'>
						<h5 class='card-title'>$ten</h5>";
		if(!empty($mota)){
			echo "<div class='card-text overflow-auto' style='max-height: 150px; max-width: 100%;'>$mota</div>";
		}
		echo "<div class='text-center' style='max-width: 100%;'>
					<a class='btn btn-primary' href = 'bien_tap.php?id_khoa_hoc=$idKH'>Truy cập</a>
			  </div>
			  </div>
			  </div>
			  </div>";
	}

	function danhSachCauhoi($idKH){
		global $conn;
		$idTK = $_SESSION['checkTK'][1];
		$loaiTK = $_SESSION['checkTK'][3];
		$a = [];
		$sql = "";
		if($loaiTK){
			$sql = "SELECT *
				    FROM cauhoi
					WHERE ThamGiaId in (
						SELECT ThamGiaId
						FROM thamgia
						WHERE CourseId = $idKH
					)";
		}else{
			$sql = "SELECT *
					FROM cauhoi 
					WHERE ThamGiaId = (
						SELECT ThamGiaId
						FROM thamgia
						WHERE CourseId = $idKH and UserId = $idTK 
					)";
		}

		$rs = mysqli_query($conn, $sql);
		if(mysqli_num_rows($rs) > 0){
			while($r = mysqli_fetch_row($rs)){
				$a[] = [$r[0], $r[4], $r[2], layDapAn($r[0]), $r[1], $r[3]];
			}
		}
		return $a;
	}

	function layDapAn($idCauHoi){
		global $conn;
		$sql = "SELECT * 
				FROM dapan
				WHERE QuestionID = $idCauHoi";
		$rs = mysqli_query($conn, $sql);
		$a = [];
		if(mysqli_num_rows($rs) > 0){
			while($r = mysqli_fetch_row($rs)){
				$a[] = [$r[0], $r[1], $r[2], $r[3], $r[4], $r[5]];
			}
		}
		return $a;
	}

	function loaiCauHoi($loai){
		if($loai == 1){
			return "Điền";
		}elseif($loai == 2){
			return "Chọn một đáp án";
		}elseif($loai == 3){
			return "Chọn nhiều đáp án";
		}elseif($loai == 4){
			return "Sắp xếp lại đáp án";
		}elseif($loai == 5){
			return "Nối đáp án";
		}elseif($loai == 6){
			return "Câu hỏi phân loại";
		}
	}
    
	function layDapAnDung($a, $loai){
		$s = "";
		if($loai == 5){
			for($i = 0; $i < count($a); $i++){
				if($a[$i][5] == 1){
					$s .= "<p>".$a[$i][2];
				}else{
					$s .= " - ".$a[$i][2]."</p>";
				}
			}
		}elseif($loai == 6){
			for($i = 0; $i < count($a); $i++){
				if($a[$i][4] == 0){
					$s .= $a[$i][2]."<br>";
				}
			}
		}else{
			for($i = 0; $i < count($a); $i++){
				if($a[$i][3]){
					$s .= "<p>".$a[$i][2]."</p>";
				}
				
			}
		}
		return $s;
	}

	function layTacGia($idThamGia){
		global $conn;
		$sql = "SELECT UserName 
				FROM taikhoan
				WHERE UserId = (
					SELECT UserId
					FROM thamgia
					WHERE ThamGiaId = $idThamGia
				)";
		$rs = mysqli_query($conn, $sql);
		if(mysqli_num_rows($rs) > 0){
			return mysqli_fetch_row($rs)[0];
		}
	}

	function layDC($anh){
		$pos = 0;
		for($i = strlen($anh) - 1; $i >= 0; $i--){
			if($anh[$i] == '.'){
				$pos = $i;
				break;
			}
		}
		return $pos;
	}

	function checkAnh($ten){
		$pos = layDC($ten);
		$type = substr($ten, $pos + 1);
		if($type == 'jpg' || $type == 'jpeg' || $type ==  'png' || $type == 'gif'){
			return true;
		}else{
			return false;
		}
		
	}

	function checkThemCauHoi($cauhoi, $dapAn, $anh){
		$check = 1;
		$s = "";
		$tenAnh = "";
		if($cauhoi == ""){
			$check = 0;
			$s .= "<p><b>Nhập tên câu hỏi</b></p>";
		}
		
		if($dapAn == ""){
			$check = 0;
			$s .= "<p><b>Nhập đáp án</b></p>";
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
			return [1, ''];
		}
	}

	function taiAnh($anh){
		$tenAnh = "";
		if(isset($anh) && !empty($anh['name'])){
			$diaChi = "../images/";
			$tenAnh = $anh['name'];
			$i = layDC($tenAnh);
        	$date = date('YmdHis');
        	$tenAnh = substr_replace($tenAnh, $date, $i, 0);
			move_uploaded_file($anh['tmp_name'], $diaChi . $tenAnh);
		}else{
			$tenAnh = null;
		}
		return $tenAnh;
	}

	function themCauHoiDien($cauhoi, $dapAn, $anh, $idKH){
		$tenAnh = taiAnh($anh);	

		$idTK = $_SESSION['checkTK'][1];
		$loaiTK = $_SESSION['checkTK'][3];
		$trangthai = 0;
		if($loaiTK){
			$trangthai = 1;
		}
		global $conn;
		$sql1 = "SELECT ThamGiaId FROM thamgia WHERE UserId = $idTK AND CourseId = $idKH";
		$rs1 = mysqli_query($conn, $sql1);
		$idTrangThai = mysqli_fetch_row($rs1)[0];
		if($tenAnh === null){
			$sql2 = "INSERT INTO cauhoi value(null, $idTrangThai, 1, $trangthai, '$cauhoi', null)";
		}else{
			$sql2 = "INSERT INTO cauhoi value(null, $idTrangThai, 1, $trangthai, '$cauhoi', '$tenAnh')";
		}

		$rs2 = mysqli_query($conn, $sql2);
		
		if($rs2 === false){
			return 0;
		}else{
			$idCauHoi = mysqli_insert_id($conn);
			$sql3 = "INSERT INTO dapan value(null, $idCauHoi, '$dapAn', 1, null, null)";
			$rs3 = mysqli_query($conn, $sql3);
			return $rs3;
		}
		
	}

	function layIDThamGia($idTK, $idKH){
		global $conn;
		$sql1 = "SELECT ThamGiaId FROM thamgia WHERE UserId = $idTK AND CourseId = $idKH";
		$rs1 = mysqli_query($conn, $sql1);
		return mysqli_fetch_row($rs1)[0];
	}

	function themCauHoiMotDapAn($cauhoi, $dapAn, $anh, $idKH, $loai){
		$tenAnh = taiAnh($anh);	

		$idTK = $_SESSION['checkTK'][1];
		$loaiTK = $_SESSION['checkTK'][3];
		$trangthai = 0;
		if($loaiTK){
			$trangthai = 1;
		}
		global $conn;
		$idThamGia = layIDThamGia($idTK, $idKH);
		if($tenAnh === null){
			$sql2 = "INSERT INTO cauhoi value(null, $idThamGia, $loai, $trangthai, '$cauhoi', null)";
		}else{
			$sql2 = "INSERT INTO cauhoi value(null, $idThamGia, $loai, $trangthai, '$cauhoi', '$tenAnh')";
		}

		$rs2 = mysqli_query($conn, $sql2);
		
		if($rs2 === false){
			return 0;
		}else{
			$idCauHoi = mysqli_insert_id($conn);
			for($i = 0; $i < count($dapAn); $i++){
				$da = $dapAn[$i][1];
				$daDung = $dapAn[$i][0];
				$stt = $i + 1;
				$sql3 = "";
				if($loai == 2 || $loai == 3){
					$sql3 = "INSERT INTO dapan value(null, $idCauHoi, '$da', $daDung, null, null)";
				}elseif($loai == 4){
					$sql3 = "INSERT INTO dapan value(null, $idCauHoi, '$da', $daDung, $stt, null)";
				}
				
				$rs3 = mysqli_query($conn, $sql3);
				if($rs3 === false){
					return 0;
				}
			}
			return 1;
		}
	}	

?> 