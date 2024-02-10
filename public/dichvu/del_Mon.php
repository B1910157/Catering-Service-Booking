<?php
include "../../bootstrap.php";
session_start();
use CT466\Project\MonAn;

$monan = new MonAn($PDO);

if(isset($_GET['id_mon'])){
    $monan->find($_GET['id_mon']);
    $monan->delete();
    echo "<script>alert('Xóa món ăn thành công'); </script>";
    echo "<script>window.location.href= 'QuanLyMonAn.php';</script>";
}
?>