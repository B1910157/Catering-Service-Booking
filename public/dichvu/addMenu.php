<?php
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\Menu;

$menu = new menu($PDO);


$menus = $menu->allmenu();



$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu = new menu($PDO);
    $menu->fill($_POST);

    if ($menu->validate()) {
        $menu->save();
        echo '<script>alert("Thêm Menu thành công.");</script>';
		echo '<script>window.location.href= "QuanLyMenu.php";</script>';
    }
    $errors = $menu->getValidationErrors();


		
	
}

?>