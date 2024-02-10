<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\douong;
use CT466\Project\dichvu;

$douong = new douong($PDO);
$loaimon = new LoaiMon($PDO);
$dichvu = new dichvu($PDO);

if (isset($_SESSION['id_dv'])) {
    $id_dv =  $_SESSION['id_dv'];
} else {
    echo '<script>alert("Phiên đăng nhập hết hạn!!!Vui lòng đăng nhập lại.");</script>';
    echo '<script>window.location.href= "../index.php";</script>';
}
$dichvus = $dichvu->all();
$douongs = $douong->findDoUongDV($id_dv);
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
    <div class="">
        <?php include('../../partials/navAdmin.php');
        ?>
        <main>
            <section id="inner" class="inner-section section">
                <!-- SECTION HEADING -->
                <hr>
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Quản Lý Đồ Uống</h2>
                <hr>
                <button onclick="showForm()"  class="btn btn-primary m-5">Thêm đồ uống mới <i class="fa fa-plus" aria-hidden="true"></i></button>
                <form action="add_douong.php" method="post" enctype="multipart/form-data" class="col-md-6 m-auto" style="display:none;">

                    <input type="hidden" name="id_dv" value="<?php echo $id_dv  ?>">

                    <div class="form-group<?= isset($errors['tendouong']) ? ' has-error' : '' ?>">
                        <label for="tendouong">Tên Đồ Uống:</label>
                        <input type="text" name="tendouong" class="form-control" maxlen="255" id="tendouong" placeholder="Enter Name" value="<?= isset($_POST['tendouong']) ? htmlspecialchars($_POST['tendouong']) : '' ?>" />

                        <?php if (isset($errors['tendouong'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['tendouong']) ?></strong>
                            </span>
                        <?php endif ?>
                    </div>
                    <div class="form-group<?= isset($errors['dvt']) ? ' has-error' : '' ?>">
                        <label for="dvt">Đơn vị tính:</label>
                        <input type="text" name="dvt" class="form-control" maxlen="255" id="dvt" placeholder="Enter Name" value="<?= isset($_POST['dvt']) ? htmlspecialchars($_POST['dvt']) : '' ?>" />

                        <?php if (isset($errors['dvt'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['dvt']) ?></strong>
                            </span>
                        <?php endif ?>
                    </div>
                   
                    <div class="form-group<?= isset($errors['giadouong']) ? ' has-error' : '' ?>">
                        <label for="giadouong">Giá :</label>
                        <input type="text" name="giadouong" class="form-control" maxlen="255" id="giadouong" placeholder="Nhập giá ..." value="<?= isset($_POST['giadouong']) ? htmlspecialchars($_POST['giadouong']) : '' ?>" />

                        <?php if (isset($errors['giadouong'])) : ?>
                            <span class="help-block">
                                <strong><?= htmlspecialchars($errors['giadouong']) ?></strong>
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
                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Thêm</button>
                </form>
                <hr>
            </section>
            <h2 class="title">Tất cả đồ uống</h2>
            <div class="container row">
                <?php foreach ($douongs as $douong) :
                    $monID = $douong->getId(); ?>
                    <div class="col-4 p-3">
                        <div class="border">
                            <a href="">
                                <img class="w-75 m-auto" style="height: 230px;" src="../img/upload/<?= htmlspecialchars($douong->image) ?>">
                            </a>
                            <div class="text-uppercase  font-weight-bold m-3"><?= htmlspecialchars($douong->tendouong) ?></div>
                            
                            <div class="m-3"><b>Giá:</b> <i class="text-danger"> <?php echo number_format($douong->giadouong, 0, '', '.'); ?> VNĐ /1 <?php echo $douong->dvt?></i></div>
                            <div class="m-3">
                                <a class="btn btn-warning" href="edit_DoUong.php?id_mon=<?php echo $monID; ?>">Sửa</a>
                                <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')" href="del_DoUong.php?id_mon=<?php echo $monID; ?>">Xóa</a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
<script>
function showForm() {
    var form = document.querySelector('form');
    form.style.display = 'block';
}
</script>
</html>