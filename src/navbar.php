
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="khoa_hoc.php">
      <img src="../images/logo.png" width="200px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <?php 
                  echo $_SESSION['checkTK'][2];
             ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <?php 
              if($_SESSION['checkTK'][3]){
                echo "
                      <li><a class='dropdown-item' href='quan_ly_tai_khoan.php'>Quản lý tài khoản</a></li>
                      <li><a class='dropdown-item' href='quan_ly_khoa_hoc.php'>Quản lý khóa học</a></li>
                      ";
              }
            ?>
            <li><a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>