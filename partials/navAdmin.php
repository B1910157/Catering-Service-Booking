<?php

use CT466\Project\dichvu;

$dichvu = new dichvu($PDO);
$id_dv = $_SESSION['id_dv'];
$dichvuLogin = $dichvu->find($id_dv);
if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    unset($_SESSION['id_dv']);
    // echo '<script>alert("Đăng xuất thành công.");</script>';
    echo '<script>window.location.href= "../index.php";</script>';
}

?>
<link rel="stylesheet" href="css/blue.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../../img/upload/<?php echo $dichvuLogin->image;?>" alt="logo" class="logo">
            </span>
            <div class="text header-text">
                <span class="name">Tiệc Lưu Động</span>
                <span class="profession"></span>
            </div>
        </div>
        <i class="fa fa-angle-right toggle"></i>
    </header>
    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <!-- <li class="search-box">
                    <label for="search"><i class="fa fa-search icon"></i></label>
                    <input type="text" id="search" placeholder="Search...">
                </li> -->
                <li class="nav-link">
                    <a href="index.php">
                        <i class="fa fa-home icon"></i>
                        <span class="text nav-text">Trang chủ</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="QuanLyDoUong.php">
                    <i class="fa fa-book icon"></i>
                        <span class="text nav-text">Đồ Uống</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="QuanLyMonAn.php">
                    <i class="fa fa-free-code-camp icon"></i>
                        <span class="text nav-text">Món Ăn</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="dv.php">
                    <i class="fa fa-id-card-o icon"></i>
                        <span class="text nav-text">Tài Khoản</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
            <li class="nav-link">
                <a href="index.php?dangxuat=1" onclick="return confirm('Xác nhận đăng xuất?')">
                    <i class="fa fa-sign-out icon" style="transform: rotate(180deg);"></i>
                    <span class="text nav-text">Đăng xuất</span>
                </a>
            </li>
            <li class="mode">
                <div class="moon-sun">
                    <i class="fa fa-moon-o icon moon"></i>
                    <i class="fa fa-sun-o icon sun"></i>
                </div>
                <span class="mode-text text">Dark Mode</span>
                <div class="toggle-switch">
                    <div class="switch"></div>
                </div>
            </li>
        </div>
    </div>

</nav>
<script src="js/blue.js">
</script>