<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

// use CT466\Project\LoaiMon;
use CT466\Project\douong;
use CT466\Project\dichvu;

$douong = new douong($PDO);
// $loaimon = new LoaiMon($PDO);
$dichvu = new dichvu($PDO);


if (isset($_SESSION['id_dv'])) {
    $id_dv =  $_SESSION['id_dv'];
} else {
    echo '<script>alert("Phiên đăng nhập hết hạn!!!Vui lòng đăng nhập lại.");</script>';
    echo '<script>window.location.href= "../index.php";</script>';
}
$dichvus = $dichvu->all();
$douongs = $douong->findDoUongDV($id_dv);


if (isset($_GET['id_mon'])) {
    // echo $_GET['id_mon'];
    $id_mon = $_GET['id_mon'];
    $douong->find($id_mon);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($douong->update($_POST, $_FILES)) {
            echo '<script>alert("Cập nhật thành công");</script>';
            echo '<script>window.location.href= "QuanLyDoUong.php";</script>';
        }
        $errors = $douong->getValidationErrors();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiệc Lưu Động</title>
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
    <div class="">
        <?php include('../../partials/navAdmin.php');
        ?>
        <main>
            <section id="inner" class="inner-section section">
                <!-- SECTION HEADING -->
                <hr>
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Chỉnh Sửa Đồ Uống</h2>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="wow fadeIn note" data-wow-duration="2s">Đảm bảo chất lượng <i class="fa fa-check" aria-hidden="true"></i></p>
                    </div>
                </div>
                <hr>
                <form action="" method="post" enctype="multipart/form-data" class="col-md-6 col-md-offset-3">

                    <input type="hidden" name="id_dv" value="<?php echo $id_dv  ?>">

                    <div class="form-group<?= isset($errors['tendouong']) ? ' has-error' : '' ?>">
                        <label for="tendouong">Tên đồ uống:</label>
                        <input type="text" name="tendouong" class="form-control" maxlen="255" id="tendouong" placeholder="Enter Name" value="<?= $douong->tendouong; ?>" />

                        <?php if (isset($errors['tendouong'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['tendouong']) ?></strong>
                            </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group<?= isset($errors['dvt']) ? ' has-error' : '' ?>">
                        <label for="dvt">Đơn vị tính:</label>
                        <input type="text" name="dvt" class="form-control" maxlen="255" id="dvt" placeholder="Enter Name" value="<?= $douong->dvt; ?>" />

                        <?php if (isset($errors['dvt'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['dvt']) ?></strong>
                            </span>
                        <?php endif ?>
                    </div>
                    
                    <div class="form-group<?= isset($errors['giadouong']) ? ' has-error' : '' ?>">
                        <label for="giadouong">Giá:</label>
                        <input type="text" name="giadouong" class="form-control" maxlen="255" id="giadouong" placeholder="Nhập giá..." value="<?= $douong->giadouong; ?>" />

                        <?php if (isset($errors['giadouong'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['giadouong']) ?></strong>
                            </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group<?= isset($errors['image']) ? ' has-error' : '' ?>">
                        <label for="image">Hình ảnh:</label>
                        <input type="file" name="image" class="form-control" maxlen="255" id="image" placeholder="Enter Name" />

                        <?php if (isset($errors['image'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['image']) ?></strong>
                            </span>
                        <?php endif ?>
                    </div>
                    <!-- Submit -->
                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Sửa món</button>
                </form>
                <hr>
            </section>
        </main>
    </div>
  
</body>

</html>