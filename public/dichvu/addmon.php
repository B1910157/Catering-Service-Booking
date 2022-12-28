<?php
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;

$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);

$monans = $monan->all();
$loaimons = $loaimon->all();


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monan = new MonAn($PDO);
    $monan->fill($_POST, $_FILES);

    if ($monan->validate()) {
        $monan->save();
        echo '<script>alert("Thêm món ăn thành công.");</script>';
		echo '<script>window.location.href= "QuanLyMonAn.php";</script>';
    }
    $errors = $monan->getValidationErrors();


		
	if (isset($errors['tenmon'])) {
		$gia_mon = $_POST['gia_mon'];
		$id_loaimon = $_POST['id_loaimon'];
	
		echo '<script>alert("Tên sản phẩm không hợp lệ.");</script>';
		echo "<script>window.location.href= 'addmon.php?gia_mon=$gia_mon&id_loaimon=$id_loaimon';</script>";
	}
	if (isset($errors['gia_mon'])) {
		$tenmon = $_POST['tenmon'];
		$id_loaimon = $_POST['id_loaimon'];
		
		echo '<script>alert("Giá sản phẩm không hợp lệ.");</script>';
		echo "<script>window.location.href= 'addmon.php?tenmon=$tenmon&id_loaimon=$id_loaimon';</script>";
	}
	if (isset($errors['id_loaimon'])) {
		$tenmon = $_POST['tenmon'];
		$gia_mon = $_POST['gia_mon'];
	
		echo '<script>alert("Mô tả sản phẩm không hợp lệ.");</script>';
		echo "<script>window.location.href= 'addmon.php?tenmon=$tenmon&gia_mon=$gia_mon';</script>";
	}
	
	if (isset($errors['image'])) {
		$tenmon = $_POST['tenmon'];
		$id_loaimon = $_POST['id_loaimon'];
		$gia_mon = $_POST['gia_mon'];
		
		echo '<script>alert("Hình ảnh không hợp lệ.");</script>';
		// echo "<script>window.location.href= 'addmon.php?tenmon=$tenmon&id_loaimon=$id_loaimon&gia_mon=$gia_mon';</script>";
	}
}

?>