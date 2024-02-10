<?php
include "../bootstrap.php";
session_start();


use CT466\Project\chitietdouong;
use CT466\Project\douong_user;
use CT466\Project\douong;
use CT466\Project\dichvu;

$dichvu = new dichvu($PDO);
$douong = new douong($PDO);
$douong_user = new douong_user($PDO);
$chitietdouong = new chitietdouong($PDO);

if (isset($_POST)) {
    // echo '<pre>';
    // print_r($_POST);
    $soluongmoi = $_POST['soluong'];
    // echo $soluongmoi;

    $array2 = [];
    // $array2['id_ctdu'] = $check->getId();
    $array2['id_douong_user'] = $_POST['id_douong_user'];
    $array2['id_douong'] = $_POST['id_douong'];
    $array2['soluong'] = $soluongmoi;
    $chitietdouong->update_souong_douong($array2);
    //  echo '<pre>';
    // print_r($array2);
    echo '<script>alert(" Đã cập nhật số lượng là ', $soluongmoi, '"); javascript:history.go(-1)</script>';
}
