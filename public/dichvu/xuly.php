<?php
include "../../bootstrap.php";
session_start();


use CT466\Project\dattiec;
$dattiec = new dattiec($PDO);

if(isset($_GET['duyet'])){
    $id_dt = $_GET['duyet'];
    // echo $id_dt;
    $dattiec->duyet($id_dt);
    echo '<script>alert("Bạn đã duyệt đơn đặt tiệc này."); javascript:history.go(-1)</script>';

}else{
    echo '<script>alert("Duyệt đơn thất bại!! Vui lòng kiểm tra lại");  javascript:history.go(-1)</script>';
}
