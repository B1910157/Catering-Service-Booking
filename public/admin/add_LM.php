<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\dichvu;

$loaimon = new LoaiMon($PDO);
$dichvu = new dichvu($PDO);
$loaimons = $loaimon->all();
$dichvus = $dichvu->all();


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // print_r($_POST);
    $loaimon->fill($_POST);
    // print_r($loaimon->fill($_POST));
    if ($loaimon->validate()) {
        $loaimon->save();
        echo '<script>alert("Thêm Loại Món thành công.");</script>';
        echo '<script>window.location.href= "qly_LM.php";</script>';
    }
    $errors = $loaimon->getValidationErrors();

   
    // echo "<pre>";
    // print_r($_POST);

}