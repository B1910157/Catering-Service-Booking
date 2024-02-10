<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\loaitiec;
use CT466\Project\dichvu;

$loaitiec = new loaitiec($PDO);
$dichvu = new dichvu($PDO);
$loaitiecs = $loaitiec->all();
$dichvus = $dichvu->all();


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // print_r($_POST);
    $loaitiec->fill($_POST);
    // print_r($loaitiec->fill($_POST));
    if ($loaitiec->validate()) {
        $loaitiec->save();
        echo '<script>alert("Thêm Loại Tiệc thành công.");</script>';
        echo '<script>window.location.href= "qly_LT.php";</script>';
    }
    $errors = $loaitiec->getValidationErrors();

   
    // echo "<pre>";
    // print_r($_POST);

}