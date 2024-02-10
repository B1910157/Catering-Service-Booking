<?php
session_start();
include __DIR__ . "/../bootstrap.php";

use CT466\Project\gopy;
$gopy = new gopy($PDO);

$errors = [];

if (isset($_POST)) {
    $gopy->insert($_POST);
    echo "<script>alert('Cảm ơn bạn đã đóng góp ý kiến'); </script>";
    echo "<script>window.location.href= 'lienhe.php';</script>";
} else {
    echo "<script>alert('lỗi'); </script>";
    echo "<script>window.location.href= 'lienhe.php';</script>";
}

?>