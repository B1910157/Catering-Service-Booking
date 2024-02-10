<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\vieclam;
use CT466\Project\dichvu;

$vieclam = new vieclam($PDO);
$dichvu = new dichvu($PDO);

$dichvus = $dichvu->all();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['id_dv'])) {

        // echo $_SESSION['id_dv'];
        $id_dv = $_SESSION['id_dv'];
        $vieclams = $vieclam->get_DV($id_dv);
        $vieclam->fill($_POST);
        // echo "<pre>";
        // print_r($vieclam->fill($_POST));
        if ($vieclam->validate()) {
            $vieclam->save();
            echo '<script>alert("Đăng bài thành công.");</script>';
            echo '<script>window.location.href= "viecLam.php";</script>';
        }
        $errors = $vieclam->getValidationErrors();
    } else {
        echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
        echo '<script>window.location.href= "loginDV.php";</script>';
    }
    // echo "<pre>";
    // print_r($_POST);

}
