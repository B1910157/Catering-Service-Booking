<?php
include "../../bootstrap.php";
session_start();


use CT466\Project\dichvu;
$dichvu = new dichvu($PDO);

if(isset($_GET['duyet'])){
    $id_dv = $_GET['duyet'];
    // echo $id_dt;
    $dichvu->choHD($id_dv);
    echo '<script>alert("Bạn đã duyệt dịch vụ."); javascript:history.go(-1)</script>';

}else{
    echo '<script>alert("Duyệt thất bại!! Vui lòng kiểm tra lại");  javascript:history.go(-1)</script>';
}
