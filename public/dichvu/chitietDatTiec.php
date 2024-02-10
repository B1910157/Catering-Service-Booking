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
use CT466\Project\douong;
use CT466\Project\chitietmenu;
use CT466\Project\douong_user;
use CT466\Project\chitietdouong;
use CT466\Project\menu_user;

$douong = new douong($PDO);

$menu_user = new menu_user($PDO);

$douong_user = new douong_user($PDO);
$chitietmenu = new chitietmenu($PDO);
$chitietdouong = new chitietdouong($PDO);
$user = new user($PDO);
$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$dichvu = new dichvu($PDO);
$dattiec = new dattiec($PDO);
// $menu = new menu($PDO);


// $menus = $menu->allmenu();
$monans = $monan->all();

$dichvus = $dichvu->allDuyet();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();

if (isset($_SESSION['id_dv'])) {
    $id_dv = $_SESSION['id_dv'];
    // $dattiecs = $dattiec->all();
    $dichvuLogin = $dichvu->find($id_dv);
    // $menus = $menu->allmenu_DV($id_dv);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "../loginDV.php";</script>';
}
if (isset($_GET['id_ct'])) {
    $id_ct = $_GET['id_ct'];
    $lichsu =  $dattiec->findOneDT($id_ct);
    // $dattiec1 = $dattiec->findDV($id_dv);
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
    <div class="m-2">
        <?php include('../../partials/navAdmin.php');
        ?>
        <main>
            <hr>
            <section id="inner" class="inner-section section">
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s"><?php echo $dichvuLogin->ten_dv;  ?></h2>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="wow fadeIn note" data-wow-duration="2s">SDT: <?php echo $dichvuLogin->sdt;  ?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="text-right col-12">
                        <a href="index.php" class="btn btn-primary">Đơn đặt tiệc mới</a>
                        <a href="daDuyet.php" class="btn btn-success">Đơn đã duyệt</a>
                        <a href="daHuy.php" class="btn btn-danger">Đơn đã hủy</a>

                    </div>
                </div>
                <div class="inner-wrapper row">
                    <div class="col-md-12 card-container">
                        <h2 class="text-primary p-2">Chi tiết đơn đặt tiệc</h2>
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
                                                <th> <b>Ngày diễn ra:</b>

                                                </th>
                                                <td>
                                                    <?php echo $dattiec->ngaydat; ?>
                                                </td>
                                                <th>
                                                    <b>
                                                        Giờ:
                                                    </b>

                                                </th>
                                                <td>
                                                    <?php echo $dattiec->giodat; ?>
                                                </td>
                                                <th>
                                                    <b> Loại tiệc: </b>
                                                </th>
                                                <td><?php $lt = $loaitiec->find($dattiec->id_loaitiec);
                                                    echo $lt->ten_loai; ?>
                                                </td>
                                                <th>
                                                    <b>
                                                        Dịch vụ hỗ trợ:
                                                    </b>
                                                </th>
                                                <td>
                                                    <?php $tenDV = $dichvu->find($dattiec->id_dv);
                                                    echo $tenDV->ten_dv; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <b>
                                                        Số bàn:
                                                    </b>

                                                </th>
                                                <td>
                                                    <?php echo $dattiec->soluongban; ?>
                                                </td>
                                                <th>
                                                    <b>
                                                        Menu:
                                                    </b>

                                                </th>
                                                <td width="20%">

                                                    <?php
                                                    if (isset($_SESSION['id_dv'])) {
                                                        // $dattiec->find($id_dattiec);
                                                        // echo $dattiec->id_user;
                                                        $menu_users = $menu_user->LS($dattiec->id_user, $dattiec->id_dv, $dattiec->id_menu);
                                                        // echo "LOKSDODKISDJS";
                                                        if ($menu_users != null) {
                                                            foreach ($menu_users as $menu_user) :
                                                                $id_menu_user = $menu_user->getId();


                                                    ?>
                                                                <?php
                                                                $tong = 0;
                                                                // $chitiet->getId();
                                                                $chitiet1 = $chitietmenu->findMenu($id_menu_user);
                                                                $chitiets = $chitietmenu->showmenu($id_menu_user);
                                                                // $chitiet2 = $chitiet->showmenu($id);
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
                                                <th>
                                                    <b> Đồ uống:</b>
                                                </th>

                                                <td width="20%">

                                                    <?php
                                                    if (isset($_SESSION['id_dv'])) {

                                                        $douong_users = $douong_user->LS($dattiec->id_user, $dattiec->id_dv, $dattiec->id_douong);


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
                                                                        echo '- ' . $douong->tendouong . ': ' . $chitiet1->soluong . ' ' . $douong->dvt . '<br>';

                                                                        $gia = $idmonn->giadouong;
                                                                        $tong = $tong + $gia;
                                                                        ?>
                                                                <?php }
                                                                endforeach ?>

                                                                <?php endforeach;  ?><?php   }
                                                                                } ?>

                                                </td>

                                                <th>
                                                    <b>
                                                        Địa chỉ:
                                                    </b>
                                                </th>
                                                <td>
                                                    <?php echo $dattiec->diachitiec, ', ', $dattiec->phuong, ', ', $dattiec->quan, ', ', $dattiec->tinh; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <b>
                                                        Ngày thực hiện:
                                                    </b>
                                                    
                                                </th>
                                                <td>
                                                    <?php echo $dattiec->ngaythuchien; ?>
                                                </td>
                                                <th>
                                                    <b>
                                                        Tổng tiền:
                                                    </b>
                                                    
                                                </th>
                                                <td>
                                                    <?php echo number_format($dattiec->tongtien) . ' vnđ'; ?>
                                                </td>
                                                <th>
                                                    <b>
                                                        Tiền cọc:
                                                    </b>
                                                    
                                                </th>
                                                <td>
                                                    <?php echo number_format($dattiec->tongtien/2); ?> vnđ
                                                </td>

                                            </tr>
                                        </tbody>

                                    </table>



                        </div>
                        <hr><br><br><br>

                <?php }
                            endforeach; ?>


                    </div>

                </div>
    </div>
    </section>
    </main>
    </div>
</body>

</html>