<?php
include "../../bootstrap.php";
session_start();
use CT466\Project\dichvu;
$dichvu = new dichvu($PDO);
$dichvus = $dichvu->allDuyet();
if (isset($_SESSION['id_dv'])) {
    $id_dv = $_SESSION['id_dv'];
    $dichvuLogin = $dichvu->find($id_dv);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "../loginDV.php";</script>';
}
$errors = [];
$passold = $_POST['passold'];
$passnew1 = $_POST['passnew1'];
$passnew2 = $_POST['passnew2'];
$pass = $dichvuLogin->password;
if ($pass == $passold) {
    $dichvu->updatePass($id_dv, $passnew1);
    echo "<script>alert('Thay đổi mật khẩu thành công'); </script>";
    echo "<script>window.location.href= 'dv.php';</script>";
} else {
    echo "<script>alert('Mật khẩu không đúng'); </script>";
    echo "<script>window.location.href= 'updatePass.php';</script>";
}
