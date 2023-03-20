<?php
include "../../bootstrap.php";
session_start();


use CT466\Project\dichvu;
$dichvu = new dichvu($PDO);

if(isset($_GET['huy'])){
    $id_dv = $_GET['huy'];
    // echo $id_dt;
    $dichvu->huy($id_dv);
    echo '<script>alert("Bạn đã hủy dịch vụ."); javascript:history.go(-1)</script>';

}else{
    echo '<script>alert("Hủy thất bại!! Vui lòng kiểm tra lại");  javascript:history.go(-1)</script>';
}
