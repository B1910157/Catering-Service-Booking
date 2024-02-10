<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";
session_start();


use CT466\Project\MonAn;
use CT466\Project\chitiet;
use CT466\Project\chitietmenu;

$monan = new MonAn($PDO);

$chitiet = new chitiet($PDO);
$chitietmenu = new chitietmenu($PDO);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo '<pre>';
    // print_r($_POST);
    $id_mon = $_POST['id'];
    $id_menu_user = $_POST['id_menu'];
    // echo "<pre>";
    // print_r($_POST);
    $check = $chitietmenu->find2($id_menu_user, $id_mon);
    if ($check != null) {
        echo '<script>alert("Món này đã có trong menu của bạn. Vui lòng chọn món khác!!! "); javascript:history.go(-1)</script>';
    } else {

        $array = [];
        $array['id_menu_user'] = $id_menu_user;
        $array['id_mon'] = $id_mon;
        $chitietmenu->insert_menu($array);
        echo '<script>alert("Thêm món vào menu thành công."); javascript:history.go(-1)</script>';
    }
}
