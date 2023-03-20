<?php
include "../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\dattiec;
use CT466\Project\user;
use CT466\Project\menu;

$user = new user($PDO);
$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$dichvu = new dichvu($PDO);
$dattiec = new dattiec($PDO);
$menu = new menu($PDO);


$users = $user->all();
$dichvus = $dichvu->all();

$monans = $monan->all();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();

if (isset($_SESSION['id_dv'])) {
    $id_dv = $_SESSION['id_dv'];
    $dattiecs = $dattiec->all();
    $dichvuLogin = $dichvu->find($id_dv);
    $menus = $menu->allmenu_DV($id_dv);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "loginDV.php";</script>';
}

// echo "<pre>";
// print_r($dichvuLogin);


// print_r($dattiec->all_DV($id_dv));
// print_r($users);
// print_r($menus);
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
    <script src="../js/validate_area.js"></script>


</head>

<body>
    <!-- Main Page Content -->
    <div class="">
        <?php include('../../partials/navAdmin.php');
        ?>
        <main>
            <section id="inner" class="inner-section section">
                <!-- SECTION HEADING -->
                <hr>
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s"><?php echo $dichvuLogin->ten_dv;  ?></h2>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="wow fadeIn note" data-wow-duration="2s">SDT: <?php echo $dichvuLogin->sdt;  ?></p>
                    </div>
                </div>
                <hr>
                <div class="text-right col-12">
                    <a href="index.php" class="btn btn-primary">Đơn đặt tiệc mới</a>
                    <a href="daDuyet.php" class="btn btn-success">Đơn đã duyệt</a>
                    <a href="daHuy.php" class="btn btn-danger">Đơn đã hủy</a>
                </div>
                <div class="inner-wrapper row">
                    <div class="col-md-12 card-container">
                        <h2 class="text-primary p-2">Đơn Đã Duyệt</h2>
                        <table id="sp" class=" text-center table-responsive table-striped">
                            <thead>
                                <tr class="border">
                                    <th>STT</th>
                                    <th>Loại tiệc</th>
                                    <th>Khách hàng </th>
                                    <th>Menu</th>
                                    <th>Gía menu</th>
                                    <th>Số lượng bàn</th>
                                    <th>giờ đặt</th>
                                    <th>ngày diễn ra tiệc</th>
                                    <th>Tỉnh/Thành Phố</th>
                                    <th>Quận/Huyện</th>
                                    <th>Phường/Xã</th>
                                    <th>Địa chỉ diễn ra tiệc</th>
                                    <th>Ngày khách hàng đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $dattiec->getId();
                                $dattiec1 = $dattiec->findDV($id_dv);
                                $dattiecs = $dattiec->all_DV_DaDuyet($id_dv);
                                foreach ($dattiecs as $dattiec1) :
                                    $dattiecID = $dattiec1->getId();
                                    $i++;
                                ?>
                                    <tr class="border">
                                        <td class="border"><?php echo $i ?></td>
                                        <td class="border"><?php
                                                            $tenloaitiec =  $loaitiec->find($dattiec1->id_loaitiec);
                                                            echo $tenloaitiec->ten_loai;
                                                            ?>
                                        </td>

                                        <td class="border"><?php
                                                            $tenkhachhang =  $user->find($dattiec1->id_user);
                                                            echo $tenkhachhang->fullname;

                                                            ?></td>
                                        <td class="border"><?php
                                                            $tenmenu =  $menu->findMenu($dattiec1->id_menu);
                                                            echo $tenmenu->tenmenu;

                                                            ?></td>
                                        <td class="border"><?php
                                                            echo $dattiec1->giamenu;


                                                            ?></td>

                                        <td class="border"><?php

                                                            echo $dattiec1->soluongban;

                                                            ?></td>
                                        <td class="border"><?php
                                                            echo $dattiec1->giodat;

                                                            ?></td>
                                        <td class="border"><?php
                                                            echo $dattiec1->ngaydat;
                                                            ?></td>

                                        <td class="border"><?php
                                                            echo $dattiec1->tinh;
                                                            ?></td>
                                        <td class="border"><?php echo $dattiec1->quan; ?></td>
                                        <td class="border"><?php echo $dattiec1->phuong; ?></td>
                                        <td class="border"><?php echo $dattiec1->diachitiec; ?></td>
                                        <td class="border"><?php echo $dattiec1->ngaythuchien; ?></td>
                                        <td class="border"><?php
                                                            echo $dattiec1->giamenu;
                                                            ?></td>
                                        <td class="border"><?php
                                                            if (($dattiec1->trangthai) == 0) {
                                                                echo "Đơn đặt tiệc mới";
                                                            } elseif (($dattiec1->trangthai) == 1) {
                                                                echo "<p class='text-primary'>Đã Duyệt</p> ";
                                                            } elseif (($dattiec1->trangthai) == 2) {
                                                                echo "Đã hủy đơn";
                                                            }
                                                            ?></td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>