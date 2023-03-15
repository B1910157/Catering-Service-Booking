<?php
session_start();
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";

use CT466\Project\Menu;
use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\chitiet;

$chitiet = new chitiet($PDO);
$loaimon = new LoaiMon($PDO);
$menu = new Menu($PDO);

$monan = new MonAn($PDO);



if(isset($_SESSION['id_dv'] )){
    $id_dv =  $_SESSION['id_dv'];
}else{
    echo '<script>alert("Phiên đăng nhập hết hạn!!!Vui lòng đăng nhập lại.");</script>'; 
    echo '<script>window.location.href= "../index.php";</script>';
}
// $dichvus = $dichvu->all();
$monans = $monan->findMonDV($id_dv);
$loaimons = $loaimon->all();

$chitiets = $chitiet->all();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // echo $_GET['id_me'];
    $id_menu = $_GET['id_me'];
    $findmenu = $menu->findMenu($id_menu);
    // echo "<pre>"; ;
    // print_r($findmenu);
   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <br>
        <hr>
        <div class="row">
            <?php foreach ($monans as $monan) :
                if (isset($_GET['id_loaimon']) && $monan->id_loaimon == $_GET['id_loaimon']) {


                    $monanID = $monan->getId();
            ?>

                    <div class="card-item m-3">

                        <a href="detail.php?id=<?php echo $monanID; ?>">

                            <img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($monan->image) ?>">
                        </a>


                        <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                        <div class="p-3 font-weight-bold"><?php $loaimonan =  $loaimon->find($monan->id_loaimon);
                                                            echo $loaimonan->tenloaimon; ?></div>
                        <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>
                        <hr>
                        <form action="addMenu.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?php echo $monan->getId(); ?>">
                        </form>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">>ADD</button>

                        </div>
                    </div>


                <?php } elseif (!isset($_GET['id_loaimon'])) {
                    $monanID = $monan->getId();
                ?>
                    <div class="card-item text-center m-3 border">
                        <a href="">
                            <img style="height: 200px; width: 250px;" src="../img/upload/<?= htmlspecialchars($monan->image) ?>">
                        </a>

                        <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                        <div class="p-3 font-weight-bold"><?php $loaimonan =  $loaimon->find($monan->id_loaimon);
                                                            echo $loaimonan->tenloaimon; ?></div>

                        <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>

                        <form action="addMonMenu.php" method="post" enctype="multipart/form-data">

                            <input hidden type="text" name="idmenu" value="<?php echo $id_menu; ?>">
                            <input hidden type="text" name="id" min="0" value="<?php echo $monan->getId(); ?>">
                            <div class="card-footer ">
                                <button class="btn btn-primary " type="submit">Thêm món</button>
                                <a href=""></a>
                            </div>
                        </form>
                    </div>
            <?php }
            endforeach; ?>
        </div>
    </div>
</body>

</html>