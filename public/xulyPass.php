<?php
include "../bootstrap.php";
session_start();
use CT466\Project\user;
$user = new user($PDO);

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $userLogin = $user->find($id_user);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "login.php";</script>';
}
$errors = [];
$passold = $_POST['passold'];
$passnew1 = $_POST['passnew1'];
$passnew2 = $_POST['passnew2'];
$pass = $userLogin->password;
if ($pass == $passold) {
    $user->updatePass($id_user, $passnew1);
    echo "<script>alert('Thay đổi mật khẩu thành công'); </script>";
    echo "<script>window.location.href= 'thongtincanhan.php';</script>";
} else {
    echo "<script>alert('Mật khẩu không đúng'); </script>";
    echo "<script>window.location.href= 'updatePass.php';</script>";
}
