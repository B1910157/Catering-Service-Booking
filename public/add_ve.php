<?php
session_start();
// include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\chitietvl;
use CT466\Project\vieclam;

$vieclam =  new vieclam($PDO);

$chitietvl = new chitietvl($PDO);

$errors = [];

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $findVL = $vieclam->findVL($_POST['id_vl']);
        $soluongvetoida = $vieclam->soluongve;
        // echo "So luong ve toi da ".$soluongvetoida;


        $check = $chitietvl->getVL($_POST['id_vl'], $id_user);
        //neu check null thì người dùng chưa đăng ký vé
        //nếu check có giá trị (!= null) thì người dùng đã từng đăng ký vé vào bài đăng việc làm này rồi => tăng thêm số lượng vé book cho người dùng cho đến khi bằng số lượng tối đa có thể đki
        if ($check != null) {
            $ct1 = $chitietvl->find($_POST['id_vl']);
            $vebook = $_POST['soluongbook'] + $ct1->soluongbook;
            // echo " Soluong ve da book " . $vebook;
            //neu người dùng đã đặt vé rồi muốn đặt lại
            if ($vebook > $soluongvetoida) {
                echo '<script>alert("Số lượng vé tối đa là ' . $soluongvetoida . ' Vui lòng kiểm tra lại.");</script>';
            } else {
                echo "so luong ve " . $ct1->soluongbook;
                $array = [];
                $ve = ($_POST['soluongbook'] + $ct1->soluongbook);
                $array['id_dv'] = $_POST['id_dv'];
                $array['id_vl'] = $_POST['id_vl'];
                $array['id_user'] = $_POST['id_user'];
                $array['soluongbook'] = $ve;
                $chitietvl->update_VL($array);
                echo "update xong";
                echo '<script>alert("Cập nhật vé thành công.");</script>';
            }
        } else {
            //Thêm mới người dùng vào trong bảng tin việc làm
            $chitietvl->insert_VL($_POST);
            // echo "Đã thêm";
            echo '<script>alert("Đăng ký vé thành công.");</script>';
        }
    }
} else {

    echo '<script>alert("Bạn chưa đăng nhập."); javascript:history.go(-1)</script>';
}
