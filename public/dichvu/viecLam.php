<?php
include "../../bootstrap.php";
session_start();


use CT466\Project\dichvu;
use CT466\Project\vieclam;

$vieclam = new vieclam($PDO);
$dichvu = new dichvu($PDO);
$dichvus = $dichvu->all();
if (isset($_SESSION['id_dv'])) {
    $id_dv = $_SESSION['id_dv'];
    $dichvuLogin = $dichvu->find($id_dv);
    $vieclams = $vieclam->get_DV($id_dv);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "../loginDV.php";</script>';
}
// echo "<pre>";
// print_r($dichvuLogin);
// print_r($dattiec->all_DV($id_dv));
// print_r($users);
// print_r($menus);
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
    <div class="m-2">
        <?php include('../../partials/navAdmin.php');
        ?>
        <main>
            <hr>
            <section id="inner" class="inner-section section">
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s"><?php echo $dichvuLogin->ten_dv;  ?></h2>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="wow fadeIn note" data-wow-duration="2s">SDT: <?php echo $dichvuLogin->sdt;  ?></p>
                    </div>
                </div>
                <hr>
                <div>
                    <form action="add_vl.php" method="POST">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="4" class="title">TUYỂN THỜI VỤ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Số lượng vé: </th>
                                    <td>
                                        <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                                        <input type="text" name="soluongve" placeholder="Nhập vào số lượng vé...">
                                    </td>
                                    <th>Giá vé:</th>
                                    <td>
                                        <input type="text" name="giave" placeholder="Nhập vào giá vé">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Giờ làm việc: </th>
                                    <td><input type="time" name="giolam"></td>
                                    <th>Ngày làm việc:</th>
                                    <td>
                                        <input type="date" name="ngaylam">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ:</th>
                                    <td>
                                        <input type="text" name="diachi" placeholder="Nhập vào địa chỉ">
                                    </td>
                                    <th>Yêu cầu: </th>
                                    <td>
                                        <textarea name="yeucau" id="yeucau" cols="30" rows="5" placeholder="Nhập vào yêu cầu"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-5"></div>
                            <button class="col-2 btn btn-primary" type="submit">Đăng bài</button>
                            <div class="col-5"></div>
                        </div>
                    </form>
                </div>
                <hr><br>
                <div class="inner-wrapper row">
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
                                    <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($vieclam->price, 0, '', '.'); ?> VNĐ</i></div>
                                    <hr>
                                    <div class="card-footer">
                                        <a class="btn btn-primary" href="detail.php?id=<?php echo $vieclamID; ?>">Xem chi tiết</a>
                                    </div>
                                </div>
                            <?php } elseif (!isset($_GET['id_vl'])) {
                                $vieclamID = $vieclam->getId();
                            ?>
                                <div class="card-item">
                                    <div class="text-uppercase p-3 font-weight-bold"><?php $dv = $vieclam->id_dv;
                                                                                        $ten = $dichvu->find($dv);
                                                                                        echo    $ten->ten_dv;  ?></div>
                                    <div class="text-uppercase p-3 font-weight-bold"> Số lượng vé: <?= htmlspecialchars($vieclam->soluongve) ?> </div>
                                    <div class="text-uppercase p-3 font-weight-bold"> Vé đã đăng ký: <?= htmlspecialchars($vieclam->vedabook) ?> </div>
                                    <div class="text-uppercase p-3 font-weight-bold"> Ngày làm: <?= htmlspecialchars($vieclam->ngaylam) ?> </div>
                                    <div class="text-uppercase p-3 font-weight-bold"> Giờ làm: <?= htmlspecialchars($vieclam->giolam) ?> </div>
                                    <div class="text-uppercase p-3 font-weight-bold"> Địa chỉ: <?= htmlspecialchars($vieclam->diachi) ?> </div>
                                    <div class="text-uppercase p-3 font-weight-bold"> Yêu Cầu: <?= htmlspecialchars($vieclam->yeucau) ?> </div>
                                    <hr>
                                    <div class="card-footer">
                                        <a class="btn btn-primary" href="chitietDV.php?id_vl=<?php echo $vieclamID; ?>">Đăng ký vé</a>
                                    </div>
                                </div>
                        <?php }
                        endforeach; ?>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>