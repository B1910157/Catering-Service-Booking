<?php

include "../bootstrap.php";

use CT466\Project\dattiec;

$dattiec = new dattiec(($PDO));

if(isset($_GET['id_don'])){
    $id_dt =  $_GET['id_don'];
    $dattiec->khachHuy($id_dt);
    echo '<script>alert("Hủy đơn thành công.");</script>';
    echo '<script>window.location.href = "lichSu.php";</script>';
}


?>