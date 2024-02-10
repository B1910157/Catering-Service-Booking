<?php
session_start();
// include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";
use CT466\Project\chitietmenu;
use CT466\Project\chitietdouong;

$chitietmenu = new chitietmenu($PDO);
$chitietdouong = new chitietdouong($PDO);

if(isset($_SESSION['id_user'])){
    if(isset($_GET['id_menu']) && $_GET['id_mon']){
        $chitietmenu->delete_mon($_GET['id_menu'], $_GET['id_mon']);
        echo '<script>alert("Xóa thành công!."); javascript:history.go(-1)</script>';
    }
    if(isset($_GET['id_douong_user']) && $_GET['id_douong']){
        $chitietdouong->delete_mon($_GET['id_douong_user'], $_GET['id_douong']);
        echo '<script>alert("Xóa thành công!."); javascript:history.go(-1)</script>';
    }
    
}else{
    echo '<script>alert("Bạn chưa đăng nhập!."); javascript:history.go(-1)</script>';
     
}



?>