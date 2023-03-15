

<?php
session_start();
include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\dattiec;
use CT466\Project\chitiet;
use CT466\Project\loaitiec;
use CT466\Project\User;

$errors = [];
$dattiec = new dattiec($PDO);
$chitiet = new chitiet($PDO);
$loaitiec = new loaitiec($PDO);
$loaitiec = new User($PDO);

$loaitiecs = $loaitiec->all();
$findMenu = $chitiet->findMenu(7);

if(isset($_SESSION['id_user'])){
    $id_user = $_SESSION['id_user'];
    echo $id_user;
}else{
    echo '<script>alert("Bạn cần đăng nhập trước khi đặt tiệc.");</script>';
    echo '<script>window.location.href= "loginTV.php";</script>';
}
// echo "<pre>";
// print_r($_POST);
// print_r($dattiec->fill($_POST));
// $dattiec->save();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $array = [];
    $array['id_dv'] = $_POST['id_dv'];
    $array['id_loaitiec'] = $_POST['id_loaitiec'];
    $array['id_user'] = $id_user;
    $array['id_menu'] = $_POST['id_menu'];

    $array['soluongban'] = $_POST['soluongban'];
    $array['giodat'] = $_POST['giodat'];
    $array['ngaydat'] = $_POST['ngaydat'];
    $array['giamenu'] = $_POST['gia_menu'];
    $array['tongtien'] = $_POST['gia_menu'] * $_POST['soluongban'];
    $array['diachitiec'] = $_POST['diachitiec'];
    $array['phuong'] = $_POST['phuong'];
    $array['quan'] = $_POST['quan'];
    $array['tinh'] = $_POST['tinh'];

//     echo "<pre>";
//    print_r($dattiec->fill($array));
    // echo "<pre>";
   
    // print_r($a);
    $dattiec->fill($array);
    if ($dattiec->validate()) {
        $dattiec->save();
        echo '<script>alert("Đặt tiệc thành công! Chờ duyệt!.");</script>';
        echo '<script>window.location.href= "lichSu.php";</script>';
    }else{
        echo '<script>alert("Đặt tiệc không thành công!!.");</script>';
    }
    $errors = $dattiec->getValidationErrors();
    if (isset($errors['id_dv'])) {
        echo '<script>alert("dịch vụ không hợp lệ."); javascript:history.go(-1)</script>';
        
    }
    if (isset($errors['id_loaitiec'])) {
        echo '<script>alert("loại tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    }

    if (isset($errors['id_user'])) {
        echo '<script>alert("loại tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    }
    if (isset($errors['id_menu'])) {
        echo '<script>alert("loại tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    }

    if (isset($errors['soluongban'])) {
        echo '<script>alert("số lượng bàn lớn hơn 10."); javascript:history.go(-1)</script>';
        
    }
    
    if (isset($errors['giodat'])) {
        echo '<script>alert("Giờ đặt tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    }
    if (isset($errors['ngaydat'])) {
        echo '<script>alert("Ngày đặt tiệc không hợp lệ."); javascript:history.go(-1)</script>';
        
    }
}


// echo "<pre";
// print_r($_POST);
// echo "fikllllllll";
// print_r($dattiec->fill($array));
// $rs = $dattiec->insertDattiec($array);



?>