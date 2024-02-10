<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";
session_start();


use CT466\Project\douong;
use CT466\Project\chitiet;
use CT466\Project\chitietdouong;
use CT466\Project\douong_user;

$douong_user =  new douong_user($PDO);


$douong = new douong($PDO);

$chitiet = new chitiet($PDO);
$chitietdouong = new chitietdouong($PDO);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // echo $_GET['id_menu'];
    $id_menu_douong = $_POST['id_menu_douong'];
    $id_dv = $_POST['id_dv'];
    $id_douong = $_POST['id_douong'];
 
    $rs1 = $douong_user->findUserAndDV($_SESSION['id_user'], $id_dv);
    $check = $chitietdouong->find2($_SESSION['id_user'], $id_dv, $id_douong, $id_menu_douong);
   
    //Check -- san pham da co trong gio
    if ($check != null) {
        $soluongmoi = $_POST['soluong'] + $chitietdouong->soluong;
        // echo $soluongmoi;
        
        $array2=[];
        // $array2['id_ctdu'] = $check->getId();
        $array2['id_douong'] = $check->id_douong;
        $array2['soluong'] = $soluongmoi;
        $chitietdouong->update_douong($array2);
        echo '<script>alert("Món này đã có trong douong của bạn. Đã cập nhật số lượng là ',$soluongmoi ,' ', $douong->find($check->id_douong)->dvt,'"); javascript:history.go(-1)</script>';
    }
    //Neu sp chua co trong gio

    else {
        $array1 = [];
        $array1['id_dv'] = $id_dv;
        $array1['id_user'] = $_SESSION['id_user'];
        $douong_user->fill($array1);

        if ($douong_user->validate()) {
            $douong_user->save();
            $array = [];
            $array['id_douong_user']=$id_menu_douong;
            $array['id_douong'] = $id_douong;
            $array['soluong'] = $_POST['soluong'];
            $chitietdouong->insert_douong($array);
            echo '<script>alert("Thêm douong vào menudouong thành công."); javascript:history.go(-1)</script>';
            // echo '<script>window.location.href= "datTiec.php?id_menu=',$_POST['id_menu'],'&id_dv=',$id_dv,'&id_menu_douong=',$id_menu_douong,'";</script>';
        }

        else {
            echo '<script>alert("Loi!!."); javascript:history.go(-1)</script>';
        }
    }
}
