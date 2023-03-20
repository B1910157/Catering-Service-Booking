<?php
include "../../bootstrap.php";
session_start();


use CT466\Project\dattiec;
$dattiec = new dattiec($PDO);

if(isset($_GET['huy'])){
    $id_dt = $_GET['huy'];
    $dattiec->huy($id_dt);
    echo '<script>alert("Bạn đã hủy đơn đặt tiệc này."); javascript:history.go(-1)</script>';
}else{
    echo '<script>alert("Có lỗi xảy ra. Vui lòng kiểm tra lại."); javascript:history.go(-1)</script>';
}
