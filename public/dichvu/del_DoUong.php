<?php
include "../../bootstrap.php";
session_start();
use CT466\Project\douong;

$douong = new douong($PDO);

if(isset($_GET['id_mon'])){
    $douong->find($_GET['id_mon']);
    $douong->delete();
    echo "<script>alert('Xóathành công'); </script>";
    echo "<script>window.location.href= 'QuanLyDoUong.php';</script>";
}
?>