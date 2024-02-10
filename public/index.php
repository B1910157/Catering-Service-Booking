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

<body>
    <!-- Main Page Content -->
    <div class="container">
        <?php include('../partials/navbar.php');
        ?>
        <section id="inner" class="inner-section section">
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">HỖ TRỢ ĐẶT TIỆC TRỰC TUYẾN</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s"> ----------------- </p>
                </div>
            </div>
            <hr>
            <div class="inner-wrapper row">
                <div class="list-group m-5 col-md-2">
                    <p class="list-group-item bg-primary">Danh Mục Dịch Vụ</p>
                    <?php foreach ($dichvus as $dichvu) :
                        $id_dv = $dichvu->getId(); ?>
                        <a class="list-group-item list-group-item-action" href="create_Menu.php?id_dv=<?php echo $id_dv; ?>">
                            <?php htmlspecialchars($dichvu->getId());
                            echo htmlspecialchars($dichvu->ten_dv) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="col-1">

                </div>
                <div class="col-6 text-center">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="../img/bg0.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="../img/img1.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="../img/banner.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>


        </section>
        <div>
            <h2 class="title">Các dịch vụ</h2>
            <div class="col-12 row container">
                <?php foreach ($dichvus as $dichvu) :
                    if (isset($_GET['id_dv']) && $dichvu->id_dv == $_GET['id_dv']) {


                        $dichvuID = $dichvu->getId();
                ?>
                        <div class="col-4">
                            <a href="detail.php?id=<?php echo $dichvuID; ?>">
                                <img class="" style="height: 100px; width: 100px;" src="img/upload/<?= htmlspecialchars($dichvu->image) ?>">
                            </a>

                            <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($dichvu->ten_dv) ?></div>
                            <div class="p-3 font-weight-bold"><?php $ct =  $category->find($dichvu->id_dv);
                                                                echo $ct->category_name; ?></div>
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
                            <a href="">
                                <img class="" style="height: 150px; width: 250px;" src="img/upload/<?= htmlspecialchars($dichvu->image) ?>">
                            </a>

                            <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($dichvu->ten_dv) ?></div>
                            <div class="text-uppercase p-3 font-weight-bold"> SDT: <?= htmlspecialchars($dichvu->sdt) ?> </div>
                            <div class="text-uppercase p-3 font-weight-bold"> Khu Vực: <?= htmlspecialchars($dichvu->dv_tinh) ?> </div>
                            <div class="text-uppercase p-3 font-weight-bold"> STK: <?= htmlspecialchars($dichvu->stk) ?> - <?= htmlspecialchars($dichvu->loai_the) ?> </div>


                            <hr>
                            <div class="card-footer">
                                <a class="btn btn-primary" href="create_menu.php?id_dv=<?php echo $dichvuID; ?>">Chọn Dịch Vụ</a>

                            </div>
                        </div>
                <?php }
                endforeach; ?>


            </div>


        </div>
        <?php include('../partials/footer.php'); ?>
    </div>

    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>


    <script>
        $(document).ready(function() {
            new WOW().init();

        });
    </script>

</body>

</html>