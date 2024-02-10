<?php
session_start();
// include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";
use CT466\Project\Menu;
use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\chitiet;

$loaimon = new LoaiMon($PDO);
$menu = new Menu($PDO);

$monan = new MonAn($PDO);

$chitiet = new chitiet($PDO);


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
	print_r($_POST);
    $id_mon = $_POST['id'];
	$id_menu = $_POST['idmenu'];
	// $menu->fill1($_POST);
	$chitiet->insert_menu2($id_menu, $id_mon); 
	echo '<script>alert("Thêm món vào menu thành công.");</script>';
	
	echo 'Hellooo';
	// 	// echo '<script>window.location.href= "choose.php";</script>';
	// } $errors = $menu->getValidationErrors();
	// if (isset($errors['tenmenu'])) {
	// 	echo '<script>alert("Tên menu không hợp lệ.");</script>';
		echo "<script>window.location.href= 'test2.php';</script>";
	// }
	
}
?>