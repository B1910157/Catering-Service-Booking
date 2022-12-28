<?php
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\chitiet;

$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$chitiet = new chitiet($PDO);


if(isset($_GET['idmenu']) && isset($_GET['idmon'])){
    $id_menu = $_GET['idmenu'];
    $id_mon = $_GET['idmon'];

    $chitiet->delete_mon($id_menu, $id_mon);
    echo '<script>alert("Đã xóa món ăn khỏi menu."); javascript:history.go(-1)</script>';
	
}




?>
