<?php
session_start();
include "../../bootstrap.php";

use CT466\Project\gopy;
$gopy = new gopy($PDO);


$gopys = $gopy->all();
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
    <!-- <script src="../js/validate_area.js"></script> -->



</head>

<body>
    <!-- Main Page Content -->
    <?php include "../../partials/nav_admin.php"; ?>
    <main>
        <div class="">
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
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Nội dung</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 1;
                    foreach ($gopys as $gopy) :
                       
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($n) ?></td>
                            <td><?= htmlspecialchars($gopy->nguoigopy) ?></td>
                            <td><?= htmlspecialchars($gopy->email) ?></td>
                            <td><?= htmlspecialchars($gopy->noidung) ?></td>
                           
                        </tr>
                    <?php
                        $n = $n + 1;
                    endforeach ?>
                </tbody>
            </table>
                    
                </div>
            </section>
        </div>

    </main>

</body>

</html>