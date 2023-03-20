<?php
include "../bootstrap.php";

use CT466\Project\dattiec;
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
$lichsu = $dattiec->getUser($userID);
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
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Lịch sử đặt tiệc</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s"> ----------------- </p>
                </div>
            </div>
            <hr>



        </section>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày Diễn ra</th>
                    <th>Giờ</th>
                    <th>Loại tiệc</th>
                    <th>Số bàn</th>
                    <th>Dịch vụ hỗ trợ</th>
                    <th>Menu</th>
                    <th>Giá Menu</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Ngày thực hiện</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 1;
                foreach ($lichsu as $dattiec) : {

                ?>
                        <tr>

                            <td><?php echo $n;
                                $n++; ?>
                            </td>
                            <td>
                                <?php echo $dattiec->ngaydat; ?>
                            </td>
                            <td>
                                <?php echo $dattiec->giodat; ?>

                            </td>
                            <td>
                                <?php $lt = $loaitiec->find($dattiec->id_loaitiec);
                                echo $lt->ten_loai; ?>

                            </td>
                            <td>
                                <?php echo $dattiec->soluongban; ?> bàn
                            </td>
                            <td>
                                <?php $tenDV = $dichvu->find($dattiec->id_dv);
                                echo $tenDV->ten_dv; ?>

                            </td>
                            <td>
                                <?php $tenMenu = $menu->findMenu($dattiec->id_menu);
                                echo $tenMenu->tenmenu; ?>
                            </td>
                            <td>
                                <?php echo $dattiec->giamenu; ?> vnđ
                            </td>
                            <td>
                                <?php echo $dattiec->diachitiec, ', ', $dattiec->phuong, ', ', $dattiec->quan, ', ', $dattiec->tinh; ?>
                            </td>

                            <td>
                                <?php echo $dattiec->giamenu; ?>
                            </td>
                            <td>
                                <?php echo $dattiec->ngaythuchien; ?>
                            </td>
                            <td>
                                <?php
                                if ($dattiec->trangthai == 1) {
                                    echo "<p class='text-primary'>Đã duyệt</p>";
                                }
                                if ($dattiec->trangthai == 0) {
                                    echo "<p class='text-warning'>Chờ duyệt</p> <br> ";
                                ?>
                                    <a href="huyDon.php?id_don=<?php echo $dattiec->getId();  ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Xác nhận hủy đơn đặt tiệc?')">Hủy tiệc</a>
                                <?php
                                }
                                if ($dattiec->trangthai == 2) {
                                    echo "<p class='text-danger'>Đơn đặt tiệc đã bị hủy!!!</p>";
                                }
                                if ($dattiec->trangthai == 3) {
                                    echo "<p class='text-danger'>Bạn đã hủy đơn!!!</p>";
                                }

                                ?>
                            </td>

                            </form>
                        </tr>
                        <tr>

                        </tr>
                <?php
                    }
                endforeach;
                ?>


            </tbody>
        </table>

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