<?php
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\dichvu;

$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$dichvu = new dichvu($PDO);

$dichvus = $dichvu->all();
$monans = $monan->all();
$loaimons = $loaimon->all();


$id_loaimon = isset($_REQUEST['id_loaimon']) ?
    filter_var($_REQUEST['id_loaimon'], FILTER_SANITIZE_NUMBER_INT) : -1;
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
    <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
</head>

<body>
    <!-- Main Page Content -->
    <div class="container">
        <?php include('../../partials/navbar.php');
        ?>
        <section id="inner" class="inner-section section">
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">SẢN PHẨM</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s">Đảm bảo chất lượng <i class="fa fa-check" aria-hidden="true"></i></p>
                </div>
            </div>
            <hr>


            <form action="addmon.php" method="post" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">
            <div class="form-group<?= isset($errors['id_dv']) ? ' has-error' : '' ?>">
                    <label for="id_dv">Dịch vụ(Lấy khi đăng nhập):</label>
                    <select name="id_dv">
                        <option hidden>--- Chọn dịch vụ --- </option>
                        <?php foreach ($dichvus as $dichvu) :
                            $dichvuID = $dichvu->getId(); ?>
                            <option> <?php echo htmlspecialchars($dichvu->getId());
                                        echo htmlspecialchars($dichvu->ten_dv) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group<?= isset($errors['tenmon']) ? ' has-error' : '' ?>">
                    <label for="tenmon">Tên món:</label>
                    <input type="text" name="tenmon" class="form-control" maxlen="255" id="tenmon" placeholder="Enter Name" value="<?= isset($_POST['tenmon']) ? htmlspecialchars($_POST['tenmon']) : '' ?>" />

                    <?php if (isset($errors['tenmon'])) : ?>
                        <span class="help-block">
                            <strong><?= htmlspecialchars($errors['tenmon']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>
                <div class="form-group<?= isset($errors['id_loaimon']) ? ' has-error' : '' ?>">
                    <label for="loaimon">Loại món:</label>
                    <select name="id_loaimon">
                        <option hidden>--- Chọn loại món --- </option>
                        <?php foreach ($loaimons as $loaimon) :
                            $loaimonID = $loaimon->getId(); ?>
                            <option> <?php echo htmlspecialchars($loaimon->getId());
                                        echo htmlspecialchars($loaimon->tenloaimon) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group<?= isset($errors['gia_mon']) ? ' has-error' : '' ?>">
                    <label for="gia_mon">Giá món ăn:</label>
                    <input type="text" name="gia_mon" class="form-control" maxlen="255" id="gia_mon" placeholder="Nhập giá món..." value="<?= isset($_POST['gia_mon']) ? htmlspecialchars($_POST['gia_mon']) : '' ?>" />

                    <?php if (isset($errors['gia_mon'])) : ?>
                        <span class="help-block">
                            <strong><?= htmlspecialchars($errors['gia_mon']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>
                <div class="form-group<?= isset($errors['image']) ? ' has-error' : '' ?>">
                    <label for="image">Hình ảnh:</label>
                    <input type="file" name="image" class="form-control" maxlen="255" id="image" placeholder="Enter Name" value="<?= isset($_POST['image']) ? htmlspecialchars($_POST['image']) : '' ?>" />

                    <?php if (isset($errors['image'])) : ?>
                        <span class="help-block">
                            <strong><?= htmlspecialchars($errors['image']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>


                <!-- Submit -->
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Thêm món</button>
            </form>


        </section>
        <?php include('../../partials/footer.php'); ?>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
    <script>
        $(document).ready(function() {
            new WOW().init();
        });
    </script>
</body>

</html>