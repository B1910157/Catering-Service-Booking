<?php
include "../../bootstrap.php";
session_start();
use CT466\Project\loaitiec;

$loaitiec = new loaitiec($PDO);


if(isset($_GET['id_loaitiec'])){
    $loaitiec->find($_GET['id_loaitiec']);
    $loaitiec->delete();
    echo "<script>alert('Xóa thành công'); </script>";
    echo "<script>window.location.href= 'qly_LT.php';</script>";
}
?>