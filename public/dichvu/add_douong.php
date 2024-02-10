<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\douong;

$douong = new douong($PDO);


$douongs = $douong->all();


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $douong = new douong($PDO);
    $douong->fill($_POST, $_FILES);

    if ($douong->validate()) {
        $douong->save();
        echo '<script>alert("Thêm thành công.");</script>';
		echo '<script>window.location.href= "QuanLyDoUong.php";</script>';
    }
    elseif(!isset($_POST['tendouong'])){
        echo '<script>alert("Vui lòng nhập đầy đủ thông tin.1");</script>';
        echo '<script>window.location.href= "QuanLyDoUong.php";</script>';
    }elseif(!isset($_POST['dvt'])){
        echo '<script>alert("Vui lòng nhập đầy đủ thông tin.");</script>';
        echo '<script>window.location.href= "QuanLyDoUong.php";</script>';
    }elseif(!isset($_POST['giadouong'])){
        echo '<script>alert("Vui lòng nhập đầy đủ thông tin.");</script>';
        echo '<script>window.location.href= "QuanLyDoUong.php";</script>';
    }elseif(!isset($_POST['image'])){
        echo '<script>alert("Vui lòng nhập đầy đủ thông tin.");</script>';
        echo '<script>window.location.href= "QuanLyDoUong.php";</script>';
    }
    
    $errors = $douong->getValidationErrors();
	
}
?>