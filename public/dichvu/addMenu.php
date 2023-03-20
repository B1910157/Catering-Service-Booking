<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\Menu;
use CT466\Project\dichvu;

$menu = new menu($PDO);
$dichvu = new dichvu($PDO);

$menus = $menu->allmenu();
$dichvus = $dichvu->all();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['id_dv'])) {

        echo $_SESSION['id_dv'];
        $id_dv = $_SESSION['id_dv'];
        $menu = new menu($PDO);
        $menu->fill($_POST);
        print_r($menu->fill($_POST));
        if ($menu->validate()) {
            $menu->save();
            echo '<script>alert("Thêm Menu thành công.");</script>';
            echo '<script>window.location.href= "QuanLyMenu.php";</script>';
        }
        $errors = $menu->getValidationErrors();
    }else{
        echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
        echo '<script>window.location.href= "loginDV.php";</script>';
    }
    // echo "<pre>";
    // print_r($_POST);

}
