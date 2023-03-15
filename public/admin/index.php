<?php
include "../../bootstrap.php";




use CT466\Project\user;
use CT466\Project\dattiec;
use CT466\Project\dichvu;

$user = new user($PDO);
$dichvu = new dichvu($PDO);
$dattiec = new dattiec($PDO);
$users = $user->all();
$dichvus = $dichvu->all();


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
    <?php include "../../partials/nav_admin.php"; ?>
    <div class="container">
        <?php
        //  include('../../partials/nav_admin.php');
        ?>
        <section id="inner" class="inner-section section">
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">QUẢN LÝ ĐẶT TIỆC TRỰC TUYẾN</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s">Tận tình chu đáo </p>
                </div>
            </div>
            <hr>
            <div class=" container">
                <div class="row text-center ">
                    <a href="qly_DV.php" class="col-4 btn btn-outline-success p-3" style="height: 150px; ">
                        Số lượng dịch vụ <br>
                        <?php
                       echo $dichvu->count_DV_ON();
                        ?>
                       <br> Chờ duyệt <br>
                        <?php
                       echo $dichvu->count_DV_OFF();
                        ?>
                    </a>
                    <a href="qly_TV.php" class="col-4 btn btn-outline-success p-3" style="height: 150px;">
                        Số lượng người dùng <br>
                        <?php
                        echo $user->countUser();
                        ?>
                    </a>
                    <a href="" class="col-4 btn btn-outline-success p-3" style="height: 150px;">
                        Tổng số lượt đặt tiệc <br>
                        <?php
                        echo $dattiec->count_tongLuot();
                        ?>
                    </a>


                </div>
            </div>
           
        </section>
        <?php include('../../partials/footer.php'); ?>
    </div>

    <script src="<?= BASE_URL_PATH . "../js/wow.min.js" ?>"></script>


    <script>
        $(document).ready(function() {
            new WOW().init();

        });
    </script>

</body>

</html>