<?php
include "../../bootstrap.php";

session_start();

// $_SESSION['id_user'] = '';
use CT466\Project\dichvu;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dichvu = new dichvu($PDO);
    $email = $_POST['email'];
    $password = $_POST['password'];
    //row tra ve so dong có username va password giong voi U P nguoi dung nhap vao 
    $row = $dichvu->checkpoint($email, $password);

    //result tra ve mang cac truong cua nguoi dung do [id, admin, fullname, username, password, diachi, created_day, updated_day]
    $results = $dichvu->checkpoint2($email, $password);

    // echo "<pre>";
    // print_r($results);
    if ($row > 0) {
        $_SESSION["id_dv"] =  $results['id_dv'];
        // print_r($results);

    } else {
        unset($_SESSION["id_dv"]);
    }

    if (isset($_SESSION["id_dv"])) {

        if ($results['trangthai'] == 1) {
            echo '<script>alert("Đăng nhập tài khoản Dịch vụ thành công!!!");</script>';
            echo '<script>window.location.href= "index.php";</script>';
           
        } else
            echo '<script>alert("Đăng nhập dịch vụ thất bại!!! Vui lòng đợi Admin duyệt tài khoản.");</script>';
        echo '<script>window.location.href= "loginDV.php";</script>';
    } else {
        echo '<script>alert("Đăng nhập dịch vụ thất bại!!! Vui lòng kiểm tra lại.");</script>';
        echo '<script>window.location.href= "loginDV.php";</script>';
    }
}
