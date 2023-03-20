<?php
include "../bootstrap.php";

session_start();

// $_SESSION['id_user'] = '';
use CT466\Project\User;
// echo $_POST['username'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = new User($PDO);
    $username = $_POST['username'];
    // echo $username;
    $password = $_POST['password'];
    //row tra ve so dong có username va password giong voi U P nguoi dung nhap vao 
    $row = $user->checkpoint($username, $password);
    // echo $row;
    //result tra ve mang cac truong cua nguoi dung do [id, admin, fullname, username, password, diachi, created_day, updated_day]
    $results = $user->checkpoint2($username, $password);

    // echo "<pre>";
    // print_r($results);
    if ($row > 0) {
        $_SESSION["id_user"] =  $results['id_user'];
        // print_r($results);

    } else {
        unset($_SESSION["id_user"]);
    }

    if (isset($_SESSION["id_user"])) {
        echo '<script>alert("Đăng nhập tài khoản  thành công!!!");</script>';
        echo '<script>window.location.href= "index.php";</script>';
    }

    else {
        echo '<script>alert("Đăng nhập thất bại!!! Vui lòng kiểm tra lại.");</script>';
        echo '<script>window.location.href= "loginTV.php";</script>';
    }
}
