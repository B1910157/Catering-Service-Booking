

<?php
session_start();
include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\dattiec;
use CT466\Project\dichvu;

$errors = [];
$dattiec = new dattiec($PDO);
$dichvu = new dichvu($PDO);



echo "<pre>";
print_r($_POST);
// print_r($dattiec->fill($_POST));
// $dattiec->save();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $array = [];
    $array['ten_dv'] = $_POST['ten_dv'];
    $array['email'] = $_POST['email'];
    

    $array['password'] = $_POST['password'];
    $array['sdt'] = $_POST['sdt'];
    
    $array['dv_diachi'] = $_POST['diachi'];
    $array['dv_phuong'] = $_POST['phuong'];
    $array['dv_quan'] = $_POST['quan'];
    $array['dv_tinh'] = $_POST['tinh'];

    echo "<pre>";
    print_r($dichvu->fill($array));
    
   
    // print_r($a);

    if ($dichvu->validate()) {
        $dichvu->save();
        echo '<script>alert("Đăng ký thành công! Chờ duyệt!.");</script>';
        echo '<script>window.location.href= "dangkiDV.php";</script>';
    }else{
        echo '<script>alert("Đăng ký không thành công!!.");</script>';
    }
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