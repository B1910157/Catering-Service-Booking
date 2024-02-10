<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\loaitiec;

$loaitiec = new loaitiec($PDO);

$id = isset($_REQUEST['id_loaitiec']) ?
    filter_var($_REQUEST['id_loaitiec'], FILTER_SANITIZE_NUMBER_INT) : -1;
// echo "<script>alert('".$id."');</script>";
if ($id < 0 || !($loaitiec->find($id))) {
    // redirect(BASE_URL_PATH);
    // echo "<script>alert('checker');</script>";
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($loaitiec->update($_POST)) {
        // Cập nhật dữ liệu thành công
        //redirect(BASE_URL_PATH);
        echo "<script>alert('Cập nhật loại tiệc thành công'); </script>";
        echo "<script>window.location.href= 'qly_LT.php';</script>";
    } else {
        // Cập nhật dữ liệu không thành công
        $errors = $loaitiec->getValidationErrors();
        echo "<script>alert('Có lỗi xảy ra');</script>";
        print_r($errors);
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiệc Lưu Động</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
</head>

<div class="">
    <?php include('../../partials/nav_admin.php'); ?>

    <main>
        <hr>
        <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">CHỈNH SỬA LOẠI MÓN</h2>
        <div class="row">
            <form class="col-12" action="edit_LT.php" enctype="multipart/form-data" method="post">
                <table class="table">
                    <tr>
                        <input hidden type="text" name="id_loaitiec" value="<?php echo $id; ?>">
                        <td>Tên Loại Tiệc</td>
                        <td>
                            <input require type="text" name="ten_loai" placeholder="Nhập tên loại tiệc" value="<?php echo $loaitiec->ten_loai; ?>">
                            <button type="submit" class="btn-warning">SỬA</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>

</div>
</body>

</html>