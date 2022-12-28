<?php
session_start();

use CT466\Project\User;

$user = new User($PDO);
// if (!isset($_SESSION['id_user'])) {
//     redirect(BASE_URL_PATH);
// } elseif ($user->find($_SESSION['id_user'])->admin == 0) {
//     redirect(BASE_URL_PATH);
// }
?>
<h2 class="title">Admin Shop</h2>
<br>
<!-- Nav pills -->
<nav class="navbar navbar-expand-lg navbar-light bg-light row">
    <a class="navbar-brand col-1" href="index.php">
        <img src="../img/logo1.png" alt="" style="width:100px;">
    </a>
    <ul class="nav nav-pills col-9" role="">


        <li class="nav-item">
            <a class="nav-link " href="manage_user.php">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_category.php">Quản lý danh mục sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_Pro.php">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_order.php">Quản lý đơn hàng</a>
        </li>
    </ul>
    <?php
    // if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    //     unset($_SESSION['id_user']);
    // } 
    ?>

    <ul class="text-right nav nav-pills col-2 ">
        <li><i style='color: red;'>Admin&nbsp;</i></li>
        <li> <i style='color: red;'>
                <?php
                // echo $user->find($_SESSION['id_user'])->fullname;
                ?>
            </i></li>
        <li><a class="nav-link" href="../index.php?dangxuat=1">Đăng xuất</a></li>
    </ul>


</nav>