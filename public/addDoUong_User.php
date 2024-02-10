<?php
session_start();
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\douong_user;
use CT466\Project\chitietdouong;
use CT466\Project\douong;

$douong_user = new douong_user($PDO);
$chitiet =  new chitietdouong($PDO);


if (isset($_SESSION['id_user'])) {
    if (isset($_POST)) {
        // echo "<pre>";
        // print_r($_POST);
        $id_dv = $_POST['id_dv'];
        $douong_user->fill($_POST);

        if ($douong_user->validate()) {
            $douong_user->save();
            // echo $douong_user->getId();
            echo '<script>window.location.href= "choose_drink.php?id_menu=',$_POST['id_menu'],'&id_menu_douong=',$douong_user->getId(),'&id_dv=',$id_dv ,'"; </script>';
            // echo '<script>window.location.href= "datTiec.php?id_menu=',$_POST['id_menu'],'&id_dv=',$id_dv,'&id_menu_douong=',$douong_user->getId(),'"; </script>';

        }
       
            // echo '<script>alert("Them thanh cong.");</script>';
        else {
            echo '<script>alert("Loi!!."); javascript:history.go(-1)</script>';
        }
    }
} else {
    echo '<script>alert("Vui lòng đăng nhập để tạo douong."); javascript:history.go(-1)</script>';
}


?>
