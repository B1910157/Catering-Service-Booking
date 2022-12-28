<?php
session_start();
include "C:/xampp/apps/project/bootstrap.php";
require_once 'C:/xampp/apps/project/bootstrap.php';
// $_SESSION['id_user'] = '';
use CT275\Project\User;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = new User($PDO);
    $username = $_POST['username'];
    $password = $_POST['password'];
    //row tra ve so dong có username va password giong voi U P nguoi dung nhap vao 
    $row = $user->checkpoint($username,$password);
    //result tra ve mang cac truong cua nguoi dung do [id, admin, fullname, username, password, diachi, created_day, updated_day]
    $results = $user->checkpoint2($username,$password);
    // $sql = "SELECT * from nguoidung where username =:u and password =:p";
    // $query = $PDO->prepare($sql);
    // $query->execute([
    //     'u' => $username,
    //     'p' => $password
    // ]);
    // $row = $checkpoint;
    // $results = $checkpoint2;
    
    if($row > 0){
        $_SESSION["id_user"] =  $results['id'];
        // print_r($results);
       
    } else {
        unset($_SESSION["id_user"]);
    }
    
    if(isset($_SESSION["id_user"])){

        if ($results['admin'] == 1) {
            header("Location: admin/index.php");
        } else header("Location: index.php");
        
    }else {
        echo '<script>alert("Đăng nhập thất bại!!! Vui lòng kiểm tra lại.");</script>';
		echo '<script>window.location.href= "login.php";</script>';
    }
       
    
    
}
