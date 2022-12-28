

<?php
session_start();
include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\dattiec;
use CT466\Project\user;

$errors = [];
$dattiec = new dattiec($PDO);
$user = new user($PDO);



echo "<pre>";
print_r($_POST);
// print_r($dattiec->fill($_POST));
// $dattiec->save();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $array = [];
    $array['fullname'] = $_POST['fullname'];
	$array['username'] = $_POST['username'];
    
    

    $array['password'] = $_POST['password'];
	
    $array['diachi'] = $_POST['diachi'];
    $array['phuong'] = $_POST['phuong'];
    $array['quan'] = $_POST['quan'];
    $array['tinh'] = $_POST['tinh'];

    $array['sdt'] = $_POST['sdt'];
	$array['email'] = $_POST['email'];
    
    echo "<pre>";
    print_r($user->fill($array));
    
   
    // print_r($a);

    // if ($dichvu->validate()) {
    //     $dichvu->save();
    //     echo '<script>alert("Đăng ký thành công! Chờ duyệt!.");</script>';
    //     echo '<script>window.location.href= "dangkiDV.php";</script>';
    // }else{
    //     echo '<script>alert("Đăng ký không thành công!!.");</script>';
    // }
    // $errors = $dattiec->getValidationErrors();
    // if (isset($errors['id_dv'])) {
    //     echo '<script>alert("dịch vụ không hợp lệ."); javascript:history.go(-1)</script>';
        
    // }
    // if (isset($errors['id_loaitiec'])) {
    //     echo '<script>alert("loại tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    // }

    // if (isset($errors['id_user'])) {
    //     echo '<script>alert("loại tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    // }
    // if (isset($errors['id_menu'])) {
    //     echo '<script>alert("loại tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    // }

    // if (isset($errors['soluongban'])) {
    //     echo '<script>alert("số lượng bàn lớn hơn 10."); javascript:history.go(-1)</script>';
        
    // }
    
    // if (isset($errors['giodat'])) {
    //     echo '<script>alert("Giờ đặt tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    // }
    // if (isset($errors['ngaydat'])) {
    //     echo '<script>alert("Ngày đặt tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    // }
}


// echo "<pre";
// print_r($_POST);
// echo "fikllllllll";
// print_r($dattiec->fill($array));
// $rs = $dattiec->insertDattiec($array);



?>