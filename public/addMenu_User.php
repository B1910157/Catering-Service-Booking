<?php
session_start();
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\menu_user;
use CT466\Project\chitietmenu;
use CT466\Project\Menu;

$menu_user = new menu_user($PDO);
$chitiet =  new chitietmenu($PDO);


if (isset($_SESSION['id_user'])) {
    if (isset($_POST)) {
        // echo "<pre>";
        // print_r($_POST);
        $id_dv = $_POST['id_dv'];
        $menu_user->fill($_POST);

        if ($menu_user->validate()) {
            $menu_user->save();
            // echo $menu_user->getId();
            echo '<script>window.location.href= "datTiec.php?id_menu=',$menu_user->getId(),'&id_dv=',$id_dv,'";</script>';
        }
       
            // echo '<script>alert("Them thanh cong.");</script>';
        else {
            echo '<script>alert("Loi!!."); javascript:history.go(-1)</script>';
        }
    }
} else {
    echo '<script>alert("Vui lòng đăng nhập để tạo Menu."); javascript:history.go(-1)</script>';
}


?>
