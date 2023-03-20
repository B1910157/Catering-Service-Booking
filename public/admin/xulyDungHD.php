<?php
include "../../bootstrap.php";
session_start();


use CT466\Project\dichvu;
$dichvu = new dichvu($PDO);

if(isset($_GET['dung'])){
    $id_dv = $_GET['dung'];
    // echo $id_dt;
    $dichvu->choNgungHD($id_dv);
    echo '<script>alert("Bạn đã dừng dịch vụ."); javascript:history.go(-1)</script>';

}else{
    echo '<script>alert("Thất bại!! Vui lòng kiểm tra lại");  javascript:history.go(-1)</script>';
}
