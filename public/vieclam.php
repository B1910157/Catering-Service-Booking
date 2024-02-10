<?php
include "../bootstrap.php";
session_start();

use CT466\Project\chitiet;
use CT466\Project\dichvu;

use CT466\Project\User;
use CT466\Project\vieclam;
use CT466\Project\chitietVL;

$chitietvl = new chitietVL($PDO);
$vieclam = new vieclam($PDO);
$user = new User($PDO);
$vieclams = $vieclam->all();

$dichvu = new dichvu($PDO);

$dichvus = $dichvu->allDuyet();

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
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">VIỆC LÀM THÊM</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s"> ----------------- </p>
                </div>
            </div>
            <hr>
        </section>
        <div class="col-12 row">
            <?php foreach ($vieclams as $vieclam) :
                if (isset($_GET['id_vl']) && $vieclam->getId() == $_GET['id_vl']) {
                    $vieclamID = $vieclam->getId();
            ?>
                    <div class="col-4">
                        <div class="text-uppercase p-3 font-weight-bold"> <?php $dv = $vieclam->id_dv;
                                                                            $ten = $dichvu->find($dv);
                                                                            echo    $ten->ten_dv . 'hello';  ?> </div>
                        <div class="p-3 font-weight-bold"><?php $ct =  $vieclam->find($vieclam->getId());
                                                            echo $ct->ten_dv; ?></div>
                        <div><b>Giá: </b> <i class="text-danger"> <?php echo number_format($vieclam->price, 0, '', '.'); ?> VNĐ</i></div>
                        <hr>
                        <div class="card-footer">
                            <a class="btn btn-primary" href="detail.php?id=<?php echo $vieclamID; ?>">Xem chi tiết</a>

                        </div>
                    </div>
                <?php } elseif (!isset($_GET['id_vl'])) {
                    $vieclamID = $vieclam->getId();
                    $chitietVLID = $chitietvl->find($vieclamID);

                ?>
                    <div class="card-item">
                        <div class="text-uppercase p-3 font-weight-bold"><?php $dv = $vieclam->id_dv;
                                                                            $ten = $dichvu->find($dv);
                                                                            echo    $ten->ten_dv;  ?></div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p> Số lượng vé: <?= htmlspecialchars($vieclam->soluongve) ?></p>
                        </div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p>Vé đã đăng ký: <?php
                                                if (isset($chitietVLID)) {
                                                    echo htmlspecialchars($chitietVLID->soluongbook);
                                                } else {
                                                    echo "0";
                                                }

                                                ?>
                            </p>
                        </div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p>Giá vé: <?= number_format($vieclam->giave, 0, '', '.') ?> vnđ </p>
                        </div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p>Ngày làm: <?= htmlspecialchars($vieclam->ngaylam) ?></p>
                        </div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p> Giờ làm: <?= htmlspecialchars($vieclam->giolam) ?></p>
                        </div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p> Địa chỉ: <?= htmlspecialchars($vieclam->diachi) ?></p>
                        </div>
                        <div class="text-left " style="margin-left: 20px;">
                            <p>Yêu cầu: <?= htmlspecialchars($vieclam->yeucau) ?></p>
                        </div>
                        <hr>
                        <form action="add_ve.php" method="post">
                            Số lượng vé: <input type="number" name="soluongbook" min="0" max="" value="1"><br>
                            <input type="hidden" name="id_dv" value="<?php echo $dichvu->getId(); ?>">
                            <input type="hidden" name="id_vl" value="<?php echo $vieclam->getId(); ?>">
                            <?php
                            if (isset($_SESSION['id_user'])) {
                            ?>
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user'] ?>">
                            <?php
                            }

                            ?>

                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Đăng ký vé</button>
                            </div>
                        </form>
                    </div>
            <?php }
            endforeach; ?>
        </div>
        <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
        <script>
            $(document).ready(function() {
                new WOW().init();

            });
        </script>
</body>

</html>