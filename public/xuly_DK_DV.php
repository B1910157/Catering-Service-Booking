

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
    // $array['image'] = $_POST['image'];

    echo "<pre>";
    echo "file";
    var_dump($_FILES);
    echo "array";
    print_r($array);
    print_r($dichvu->fill($array, $_FILES));
    $dichvu->fill($array, $_FILES);
    
    if ($dichvu->validate()) {
        $dichvu->save();
        echo '<script>alert("Đăng ký thành công! Chờ duyệt!.");</script>';
        // echo '<script>window.location.href= "dangkiDV.php";</script>';
    }else{
        echo '<script>alert("Đăng ký không thành công!!.");</script>';
    }
    
}






?>