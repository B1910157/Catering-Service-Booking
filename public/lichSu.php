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
                    <th>Sự kiện</th>
                    <th>Dịch vụ hỗ trợ</th>
                    <th>Tổng tiền</th>
                    <th>Tiền cần cọc</th>
                    <th>Ngày thực hiện</th>
                    <th width='12%'>Trạng thái</th>
                    <th>Chi tiết</th>
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
                                <?php $tenDV = $dichvu->find($dattiec->id_dv);
                                echo $tenDV->ten_dv; ?>

                            </td>


                            <td>
                                <?php echo  number_format($dattiec->tongtien); ?> vnđ
                            </td>
                            <td>
                                <?php echo number_format($dattiec->tongtien / 2); ?> vnđ
                            </td>
                            <td>
                                <?php echo $dattiec->ngaythuchien; ?>
                            </td>
                            <td>
                                <?php
                                if ($dattiec->trangthai == 1) {
                                    echo "<i class='text-success fa fa-check'> Đã xác nhận</i>";
                                }
                                if ($dattiec->trangthai == 0) {
                                    echo "<i class='text-warning'>Chờ xác nhận</i> <br> ";
                                ?>
                                    <a href="huyDon.php?id_don=<?php echo $dattiec->getId();  ?>" class="btn btn-danger" onclick="return confirm('Xác nhận hủy đơn đặt tiệc?')"> <i class="fa fa-times" aria-hidden="true"> Hủy</i></a>
                                <?php
                                }
                                if ($dattiec->trangthai == 2) {
                                    echo "<i class='text-danger'>Đơn đặt tiệc đã bị hủy!!!</i>";
                                }
                                if ($dattiec->trangthai == 3) {
                                    echo "<i class='text-danger'>Bạn đã hủy đơn!!!</i>";
                                ?>
                                    <!-- <a href="datLai.php?id_don=<?php
                                                                    //   echo $dattiec->getId(); 
                                                                    ?>" class="btn btn-outline-primary btn-sm" onclick="return confirm('Xác nhận đặt lại đơn đặt tiệc?')"> <i class="fa fa-refresh" aria-hidden="true"> Đặt lại</i></a> -->
                                <?php
                                }

                                ?>
                            </td>
                            <td>
                                <a href="chitietLS.php?id_ls=<?php echo $dattiec->getId(); ?>" class="btn btn-primary"><i class="fa fa-info" aria-hidden="true"></i></a>
                            </td>

                            </form>
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