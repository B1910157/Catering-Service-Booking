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
$dichvus = $dichvu->allDuyet();

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
    echo '<script>window.location.href= "../loginDV.php";</script>';
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
                <div>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th colspan="4" class="title">Thông tin dịch vụ</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Tên dịch vụ: </th>
                                <td><?php echo $dichvuLogin->ten_dv; ?></td>
                                <th>Địa chỉ:</th>
                                <td>
                                    <?php echo $dichvuLogin->dv_diachi; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Số tài khoản: </th>
                                <td><?php
                                    echo $dichvuLogin->stk;

                                    ?></td>
                                <th>Loại thẻ:</th>
                                <td>
                                    <?php echo $dichvuLogin->loai_the; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Email: </th>
                                <td><?php
                                    echo $dichvuLogin->email;

                                    ?></td>
                                <th>Quận/Huyện:</th>
                                <td>
                                    <?php echo $dichvuLogin->dv_quan; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>SĐT: </th>
                                <td><?php
                                    echo $dichvuLogin->sdt;

                                    ?></td>
                                <th>Phường/Xã:</th>
                                <td>
                                    <?php echo $dichvuLogin->dv_phuong; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo: </th>
                                <td><?php
                                    echo $dichvuLogin->ngaytao;

                                    ?></td>
                                <th>Tỉnh/Thành Phố:</th>
                                <td>
                                    <?php echo $dichvuLogin->dv_tinh; ?>
                                </td>
                                <th>Hình ảnh: </th>
                                <td><?php
                                    echo $dichvuLogin->image;

                                    ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="suaDV.php" class="btn btn-primary ">Cập nhật thông tin</a>
                            <a href="updatePass.php" class="btn btn-primary">Đổi mật khẩu</a>
                            <a href="changeImg.php" class="btn btn-primary">Cập nhật ảnh</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>