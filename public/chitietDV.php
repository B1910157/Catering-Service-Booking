<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;
use CT466\Project\chitiet;


$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);
$chitiet = new chitiet($PDO);



$monans = $monan->all();

$dichvus = $dichvu->allDuyet();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();


if (isset($_GET['id_dv'])) {
    $id_dv = isset($_REQUEST['id_dv']) ?
        filter_var($_REQUEST['id_dv'], FILTER_SANITIZE_NUMBER_INT) : -1;
    $menus = $menu->allmenu_DV($id_dv);
}

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
            <div class="row">
                <div class="col-md-12 ">
                    <form id="dattiec" action="datTiec.php" method="post" enctype="multipart/form-data">

                        <h2>LIST MENU CỦA TIỆC</h2>
                        <div class="col-md-12">
                            <?php foreach ($menus as $menu) :
                                $id = $menu->getId();
                                $n = 1;
                            ?>
                                <div class="border">
                                    <div class="text-uppercase font-weight-bold"><?= htmlspecialchars($menu->tenmenu) ?></div>
                                    <?php
                                    $tong = 0;
                                    // $chitiet->getId();
                                    $chitiet1 = $chitiet->findMenu($id);
                                    $chitiets = $chitiet->all1($id);
                                    // $chitiet2 = $chitiet->showmenu($id);
                                    foreach ($chitiets as $chitiet1) : {
                                            // code...
                                    ?>
                                            <?php
                                            $idmonn =  $monan->find($chitiet1->id_mon); ?>
                                            <img style="width: 20px;  height: 20px;" src="../img/upload/<?php echo $monan->image; ?>">
                                            <?php
                                            echo 'Món:' . $monan->tenmon;
                                            echo ' : ' . $monan->gia_mon . 'vnđ <br>';
                                            $gia = $idmonn->gia_mon;
                                            $tong = $tong + $gia;
                                            ?>
                                    <?php }
                                    endforeach ?>
                                    <br>
                                    <p>Tổng Menu: <i class="text-danger"><?php echo $tong; ?></i> vnd</p>
                                    <input type="hidden" name="gia_menu" value="<?php echo $tong ?>">
                                    <a class="btn btn-primary" href="datTiec.php?id_menu=<?php echo $menu->getId(); ?>&id_dv=<?php echo $id_dv ?>">Chọn menu</a>
                                    <br>
                                    <hr>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </form>
                </div>

            </div>


        </section>



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