<?php
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\Menu;

$menu = new menu($PDO);

if ((isset($_GET['id']))  && ($menu->findMenu($_GET['id'])) !== NULL) {

    if ($menu->validateToDelete()) {
        $menu->delete();
        echo '<script>alert("Xóa Menu thành công.");</script>';
        echo "<script>window.location.href= 'QuanLyMenu.php';</script>";
    } else {
        echo '<script>alert("Menu này đã có người đặt!!! Tạm thời không thể xóa");</script>';
        echo "<script>window.location.href= 'QuanLyMenu.php';</script>";
    }
} else {
    echo '<script>alert("Menu của bạn đang trống");</script>';
    echo "<script>window.location.href= 'QuanLyMenu.php';</script>";
}
