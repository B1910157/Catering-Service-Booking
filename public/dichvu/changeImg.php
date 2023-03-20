<?php
include "../../bootstrap.php";
session_start();

use CT466\Project\dichvu;
$dichvu = new dichvu($PDO);
$dichvus = $dichvu->allDuyet();
if (isset($_SESSION['id_dv'])) {
    $id_dv = $_SESSION['id_dv'];
    // $dattiecs = $dattiec->all();
    $dichvuLogin = $dichvu->find($id_dv);
    // $menus = $menu->allmenu_DV($id_dv);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "../loginDV.php";</script>';
}


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($dichvu->updateImg($_FILES)) {
        echo "<script>alert('Cập nhật dịch vụ thành công'); </script>";
        echo "<script>window.location.href= 'dv.php';</script>";
    } else {
        $errors = $dichvu->getValidationErrors();
        echo "<script>alert('Có lỗi xảy ra');</script>";
        print_r($errors);
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
                    <form action="changeImg.php" enctype="multipart/form-data" method="post">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Hình ảnh:</th>
                                    <td>
                                        <input type="file" name="image" id="image">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" name="submit" class="btn btn-warning">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

        </main>

    </div>
</body>

</html>