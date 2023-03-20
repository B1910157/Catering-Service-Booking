<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;


$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);

$menus = $menu->allmenu();
$monans = $monan->all();

$dichvus = $dichvu->allDuyet();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();

$id_loaitiec = isset($_REQUEST['id_loaitiec']) ?
    filter_var($_REQUEST['id_loaitiec'], FILTER_SANITIZE_NUMBER_INT) : -1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiệc Lưu Động</title>
    <!-- 
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
    <script src="js/validate_area.js"></script>


</head>

<body> <!-- Main Page Content -->

    <div class="container">
        <?php include('../partials/navbar.php'); ?>
        <h1 class="title text-center">Các Dịch Vụ Nhà Hàng Lưu Động</h1>
        <hr>
        <div class="row">
            <div class="col-12 row">
                <?php foreach ($dichvus as $dichvu) :
                    if (isset($_GET['id_dv']) && $dichvu->getId() == $_GET['id_dv']) {


                        $dichvuID = $dichvu->getId();
                ?>
                        <div class="col-4">
                            <a href="chitietDV.php?id_dv=<?php echo $dichvuID; ?>">
                                <img class="w-75"   src="img/upload/<?= htmlspecialchars($dichvu->image) ?>">
                            </a>

                            <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($dichvu->ten_dv) ?></div>
                            <div class="p-3 font-weight-bold"><?php $ct =  $dichvu->find($dichvu->getId());
                                                                echo $ct->ten_dv; ?></div>
                            <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($dichvu->price, 0, '', '.'); ?> VNĐ</i></div>
                            <hr>
                            <div class="card-footer">
                                <a class="btn btn-primary" href="detail.php?id=<?php echo $dichvuID; ?>">Xem chi tiết</a>

                            </div>
                        </div>
                    <?php } elseif (!isset($_GET['id_dv'])) {
                        $dichvuID = $dichvu->getId();
                    ?>
                        <div class="card-item">
                            <a href="detail.php?id=<?php echo $dichvuID; ?>">
                                <img class="w-50" src="img/upload/<?= htmlspecialchars($dichvu->image) ?>">
                            </a>

                            <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($dichvu->ten_dv) ?></div>
                            <div class="text-uppercase p-3 font-weight-bold"> SDT: <?= htmlspecialchars($dichvu->sdt) ?>  </div>
                            <div class="text-uppercase p-3 font-weight-bold"> Tỉnh: <?= htmlspecialchars($dichvu->dv_tinh) ?>  </div>


                            <hr>
                            <div class="card-footer">
                                <a class="btn btn-primary" href="chitietDV.php?id_dv=<?php echo $dichvuID; ?>">Chọn Dịch Vụ</a>

                            </div>
                        </div>
                <?php }
                endforeach; ?>


            </div>

        </div>


    </div>

</body>

</html>