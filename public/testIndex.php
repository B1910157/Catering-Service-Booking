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

$dichvus = $dichvu->all();
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
        <h1 class="title text-center">Dịch Vụ Tiệc Lưu Động</h1>
        <hr>
        <div class="row">
            <div class="col-6">
                <p class="">Dịch vụ đặt tiệc lưu động ngày càng được nhiều khách hàng lựa chọn vì những ưu điểm như đặt tiệc lưu động giá rẻ, đặt tiệc lưu động có thể mang đến những bữa tiệc hoàn hảo đến bất cứ đâu,…
                </p>
                <p>
                    Bên cạnh đó, khi sử dụng dịch vụ tiệc lưu động trọn gói, quý khách có thể hoàn toàn yên tâm về chất lượng của các món ăn trong bữa tiệc, đồng thời tiết kiệm thời gian và công sức đáng kể.
                </p>
            </div>
            <div class="col-6">
                <img src="./img/img1.jpg" alt="" class="w-75 h-75 ml-5" >

            </div>
            


        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn-lg btn-success">Đặt tiệc ngay</button>
            </div>
            
        </div>

    </div>

</body>

</html>


<!-- ĐỒ UỐNG -->
<div class="container">
        <div>
            <h2 class="title"> Gói đồ uống của bạn </h2>
            <div class="container row">

                <?php
                if (isset($_SESSION['id_user'])) {
                    if ($douong_users != null) {

                        foreach ($douong_users as $douong_user) :
                            $id_douong_user = $douong_user->getId();
                            // echo $id_douong_user;
                ?>
                            <div class="col-4 p-3">
                                <?php
                                $tong = 0;
                                // $chitiet->getId();
                                $chitiet1 = $chitietdouong->finddouong($id_douong_user);
                                $chitiets = $chitietdouong->showdouong($id_douong_user);
                                // $chitiet2 = $chitiet->showdouong($id);
                                foreach ($chitiets as $chitiet1) : {
                                        // code...



                                ?>
                                        <?php
                                        $idmonn =  $douong->find($chitiet1->id_douong); ?>

                                        <img style="width: 20px;  height: 20px;" src="../img/upload/<?php echo $douong->image; ?>">
                                        <?php
                                        echo 'Món:' . $douong->tendouong;
                                        echo ' : ' . number_format($douong->giadouong) . ' vnđ <br>';
                                        $gia = $idmonn->giadouong;
                                        $tong = $tong + $gia;
                                        ?>
                                <?php }
                                endforeach ?>
                                <p>Tổng douong: <i class="text-danger"><?php echo $tong; ?></i> vnd</p>
                                <input type="hidden" name="gia_douong" value="<?php echo $tong ?>">
                                <a class="btn btn-primary" href="datTiec.php?id_menu=<?php echo $_GET['id_menu']; ?>&id_dv=<?php echo $id_dv ?>&id_menu_douong=<?php echo $douong_user->getId(); ?>">Chọn đồ uống</a>


                            </div>
                        <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="text-uppercase  font-weight-bold"><?php
                                                                $dv = $douong_user->id_dv;
                                                                $tendv = $dichvu->find($dv);
                                                                echo $tendv->ten_dv;

                                                                ?>
                </div>


            </div>


        <?php } else { ?>
            <div class="row">
                <div class="col-12 text-center">
                    Bạn chưa tạo menu nào trong dịch vụ này!!!
                </div>

            </div>

    <?php }
                } ?>


        </div>