<?php
include "../../bootstrap.php";
session_start();
use CT466\Project\LoaiMon;

$loaimon = new LoaiMon($PDO);


if(isset($_GET['id_loaimon'])){
    $loaimon->find($_GET['id_loaimon']);
    $loaimon->delete();
    echo "<script>alert('Xóa Loại Món thành công'); </script>";
    echo "<script>window.location.href= 'qly_LM.php';</script>";
}
?>