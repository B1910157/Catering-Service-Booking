<?php
include "../bootstrap.php";

use CT466\Project\dattiec;
use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;
use CT466\Project\menu_user;
use CT466\Project\douong;
use CT466\Project\chitietdouong;
use CT466\Project\douong_user;
use CT466\Project\chitietmenu;


$menu_user = new menu_user($PDO);
$douong_user = new douong_user($PDO);
$chitietdouong = new chitietdouong($PDO);
$douong = new douong($PDO);
$chitietmenu = new chitietmenu($PDO);
$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);
$dattiec = new dattiec(($PDO));

$menus = $menu->allmenu();
$monans = $monan->all();

$dichvus = $dichvu->allDuyet();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();

$id_loaitiec = isset($_REQUEST['id_loaitiec']) ?
    filter_var($_REQUEST['id_loaitiec'], FILTER_SANITIZE_NUMBER_INT) : -1;
session_start();

if (isset($_SESSION["id_user"])) {
    $userID = $_SESSION["id_user"];
} else {
    echo '<script>alert("Bạn cần đăng nhập để xem lịch sử đặt tiệc.");</script>';
    echo '<script>window.location.href = "loginTV.php";</script>';
}


if(isset($_GET['id_ls'])){
    $id_dattiec = $_GET['id_ls'];
    $lichsu = $dattiec->findOneDT($id_dattiec);
}

// echo "<pre>";
// print_r($lichsu);

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
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Chi Tiết</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s"> ----------------- </p>
                </div>
            </div>
            <hr>



        </section>
        <div class="col-12 row">
    
            <?php foreach ($lichsu as $dattiec) :

                if (!isset($_GET['id_dv'])) {
                    $dichvuID = $dichvu->getId();
            ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>
                                    <b><u>Chi Tiết</u> </b>
                                </td>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    Ngày diễn ra:
                                </th>
                                <td>
                                    <?php echo $dattiec->ngaydat; ?>
                                </td>
                                <th>
                                    Giờ:
                                </th>
                                <td>
                                    <?php echo $dattiec->giodat; ?>
                                </td>
                                <th>Loại tiệc: </th>
                                <td><?php $lt = $loaitiec->find($dattiec->id_loaitiec);
                                    echo $lt->ten_loai; ?>
                                </td>
                                <th>Dịch vụ hỗ trợ: </th>
                                <td>
                                    <?php $tenDV = $dichvu->find($dattiec->id_dv);
                                    echo $tenDV->ten_dv; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Số bàn:
                                </th>
                                <td>
                                    <?php echo $dattiec->soluongban; ?>
                                </td>
                                <th>
                                    Menu:
                                </th>
                                <td  width="20%">

                                    <?php
                                    if (isset($_SESSION['id_user'])) {
                                        $menu_users = $menu_user->LS($id_dattiec, $_SESSION['id_user'], $dattiec->id_dv, $dattiec->id_menu);
                                        // echo "<pre>";
                                        // print_r($menu_users);
                                       
                                        if ($menu_users != null) {
                                            foreach ($menu_users as $menu_user) :
                                                $id_menu_user = $menu_user->getId();

                                    ?>
                                                <?php
                                                $tong = 0;
                                                // $chitiet->getId();
                                                $chitiet1 = $chitietmenu->findMenu($id_menu_user);
                                                $chitiets = $chitietmenu->showmenu($id_menu_user);
                                       
                                                foreach ($chitiets as $chitiet1) : {
                                                        // code...
                                                ?>
                                                        <?php
                                                        $idmonn =  $monan->find($chitiet1->id_mon); ?>
                                                        <?php
                                                        echo '- ' . $monan->tenmon . '<br>';
                                                        $gia = $idmonn->gia_mon;
                                                        $tong = $tong + $gia;
                                                        ?>
                                                <?php }
                                                endforeach ?>

                                                <?php endforeach;  ?><?php   }
                                                                } ?>

                                </td>
                                <th>Đồ uống: </th>
                                <td width="20%">

                                    <?php
                                    if (isset($_SESSION['id_user'])) {
                                        $douong_users = $douong_user->LS($_SESSION['id_user'], $dattiec->id_dv, $dattiec->id_douong);
                                        if ($douong_users != null) {
                                            foreach ($douong_users as $douong_user) :
                                                $id_douong_user = $douong_user->getId();

                                    ?>
                                                <?php
                                                $tong = 0;
                                                // $chitiet->getId();
                                                $chitiet1 = $chitietdouong->finddouong($id_douong_user);
                                                $chitiets = $chitietdouong->showdouong($id_douong_user);
                                                // $chitiet2 = $chitiet->showmenu($id);
                                                foreach ($chitiets as $chitiet1) : {
                                                        // code...
                                                ?>
                                                        <?php
                                                        $idmonn =  $douong->find($chitiet1->id_douong); ?>
                                                        <?php
                                                        echo '- ' . $douong->tendouong . ': '. $chitiet1->soluong .' '.$douong->dvt .'</br>';
                                                        $gia = $idmonn->giadouong;
                                                        $tong = $tong + $gia;
                                                        ?>
                                                <?php }
                                                endforeach ?>

                                                <?php endforeach;  ?><?php   }
                                                                } ?>

                                </td>
                                <th>Nơi diễn ra: </th>
                                <td>
                                    <?php echo $dattiec->diachitiec, ', ', $dattiec->phuong, ', ', $dattiec->quan, ', ', $dattiec->tinh; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Ngày thực hiện:
                                </th>
                                <td>
                                    <?php echo $dattiec->ngaythuchien; ?>
                                </td>
                                <th>
                                    Tổng tiền
                                </th>
                                <td>
                                    <?php echo number_format($dattiec->tongtien) .' vnđ';?>
                                </td>
                                
                            
                            
                                <th>
                                    Giá menu: - (1 bàn)
                                </th>
                                <td>
                                    <?php echo number_format($dattiec->giamenu); ?> vnđ
                                </td>
                                <th>
                                    Giá đồ uống:
                                </th>
                                <td>
                                    <?php echo number_format($dattiec->tongtien-$dattiec->giamenu*$dattiec->soluongban) .' vnđ';?>
                                </td>
                                
                            </tr>
                            <tr>
                            <th>
                                    Tiền cọc:
                                </th>
                                <td>
                                    <?php echo number_format($dattiec->tongtien/2) .' vnđ';?>
                                </td>
                                <th>
                                    Trạng thái:
                                </th>
                                <td>
                                    <?php   
                                     if($dattiec->trangthai == 0){
                                        echo '<p class="text-warning">Chưa xác nhận</p>';
                                     }
                                     else if($dattiec->trangthai == 1){
                                        echo '<p class="text-success">Đã xác nhận</p>';
                                     }
                                     elseif($dattiec->trangthai == 2){
                                        echo '<p class="text-danger">Đã bị hủy</p>';
                                     } 
                                     elseif($dattiec->trangthai == 3){
                                        echo '<p class="text-danger">Bạn đã hủy</p>';
                                     }else{
                                        echo '<p class="text-primary">Lỗi</p>';
                                     }
                                    ?>

                                 
                                </td>
                               
                                
                            </tr>
                        </tbody>

                    </table>
                    
            

        </div>
        <hr><br><br><br>

        <?php }
            endforeach; ?>


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