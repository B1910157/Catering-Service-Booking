<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\dichvu;

$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$dichvu = new dichvu($PDO);

if (isset($_SESSION['id_dv'])) {
    $id_dv =  $_SESSION['id_dv'];
} else {
    echo '<script>alert("Phiên đăng nhập hết hạn!!!Vui lòng đăng nhập lại.");</script>';
    echo '<script>window.location.href= "../index.php";</script>';
}
$dichvus = $dichvu->all();
$monans = $monan->findMonDV($id_dv);
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
            <section class="inner-section section ">
                <!-- SECTION HEADING -->
                <hr>
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Quản Lý Món Ăn</h2>
                <hr>
                <div class="row">

                </div>
                <button onclick="showForm()" class="btn btn-primary m-5">Thêm món mới <i class="fa fa-plus" aria-hidden="true"></i> </button>
                <form action="addmon.php" method="post" enctype="multipart/form-data" class="col-md-6 m-auto" style="display:none;" >

                    <input type="hidden" name="id_dv" value="<?php echo $id_dv  ?>">

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
                        <select name="id_loaimon" class="custom-select">
                            <option hidden>--- Chọn loại món --- </option>
                            <?php foreach ($loaimons as $loaimon) :
                                $loaimonID = $loaimon->getId(); ?>
                                <option> <?php
                                            echo htmlspecialchars($loaimon->getId());
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
                <hr>
            </section>
            <h2 class="title">Tất cả món ăn</h2>
            <div class="container row">
                <?php foreach ($monans as $monan) :
                    $monID = $monan->getId(); ?>
                    <div class="col-4 p-3">
                        <div class="border">
                            <a href="">
                                <img class="w-75 m-auto" style="height: 150px;" src="../img/upload/<?= htmlspecialchars($monan->image) ?>">
                            </a>
                            <div class="text-uppercase  font-weight-bold m-3"><?= htmlspecialchars($monan->tenmon) ?></div>
                            <div class="font-weight-bold m-3"><?php $loai =  $loaimon->find($monan->id_loaimon);
                                                            echo $loai->tenloaimon; ?></div>
                            <div class="m-3"><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>
                            <div class="m-3">
                                <a class="btn btn-warning" href="edit_Mon.php?id_mon=<?php echo $monID; ?>">Sửa</a>
                                <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa món ăn?')" href="del_Mon.php?id_mon=<?php echo $monID; ?>">Xóa</a>

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