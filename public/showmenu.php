<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\Menu;
use CT466\Project\dichvu;

$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);

$monans = $monan->all();
$loaimons = $loaimon->all();

$menus = $menu->all();

$id_menu = isset($_REQUEST['id_menu']) ?
    filter_var($_REQUEST['id_menu'], FILTER_SANITIZE_NUMBER_INT) : -1;
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
    <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
</head>

<body>
    <!-- Main Page Content -->
    <div class="container">
        <?php include('../partials/navbar.php');
        ?>
        <section id="inner" class="inner-section section">
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">SẢN PHẨM</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s">Đảm bảo chất lượng <i class="fa fa-check" aria-hidden="true"></i></p>
                </div>
            </div>
            <hr>
            <div class="inner-wrapper row">
                <div class="list-group m-3 col-md-2">
                    <p class="list-group-item bg-primary">DANH MỤC</p>
                    <?php foreach ($loaimons as $loaimon) :
                        $loaiID = $loaimon->getId(); ?>
                        <a class="list-group-item list-group-item-action" href="monan.php?id_loaimon=<?php echo $loaiID; ?>">
                            <?php htmlspecialchars($loaimon->getId());
                            echo htmlspecialchars($loaimon->tenloaimon) ?>
                        </a>
                    <?php endforeach; ?>
                </div>

            </div>

            <table class="table table-borderd text-center ">
                <thead>
                    <tr>
                        <th>
                            <?php
                            echo 'MENU';
                            ?>
                        </th>

                    </tr>
                    <tr>
                        <th>STT</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Hình ảnh</th>

                        <th>Giá</th>
                        <th>Tổng tiền</th>
                        <th width="15%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 1;
                    foreach ($menus as $menu) : {
                            // code...
                            $id_menu = $menu->getId();
                            echo $menu->tenmenu;
                            echo '\n';
                    ?>

                            <tr>

                                <td><?php echo $n;
                                    $n++; ?></td>
                                <td><?php $idmonn =  $monan->find($menu->id_mon);
                                    echo $idmonn->tenmon;
                                    
                                     ?></td>

                                <td>
                                    <img class="w-25 h-25" src="img/upload/<?php $idmonn =  $monan->find($menu->id_mon);
                                                                            echo $idmonn->image; ?>">
                                </td>
                                <td> <?php

                                        $idmonn =  $monan->find($menu->id_mon);

                                        echo number_format($idmonn->gia_mon, 0, '', '.'); ?><sup> vnđ</sup></td>

                                <td><?php echo '00000'; ?><sup> vnđ</sup></td>
                                <td>

                                    <a class="btn btn-danger" href="delete_cart.php?menu_id=<?php echo $menu->getId(); ?>&mon_id=<?php echo $menu->id_mon; ?>">Xóa</a>
                                </td>
                                </form>
                            </tr>
                            <tr>
                                <a href="chitietmenu.php?id=<?php echo $id_menu; ?>">chi tiet <?php echo $id_menu; ?></a>
                            </tr>

                    <?php }
                    endforeach ?>

                </tbody>
            </table>


        </section>
        <?php include('../partials/footer.php'); ?>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
    <script>
        $(document).ready(function() {
            new WOW().init();
        });
    </script>
</body>

</html>