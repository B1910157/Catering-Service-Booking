<?php
include "../bootstrap.php";
session_start();


use CT466\Project\chitietdouong;
use CT466\Project\douong_user;
use CT466\Project\douong;
use CT466\Project\dichvu;

$dichvu = new dichvu($PDO);
$douong = new douong($PDO);
$douong_user = new douong_user($PDO);
$chitietdouong = new chitietdouong($PDO);



if (isset($_GET['id_dv'])) {
    $id_dv = isset($_REQUEST['id_dv']) ?
        filter_var($_REQUEST['id_dv'], FILTER_SANITIZE_NUMBER_INT) : -1;
    $id_menu = isset($_REQUEST['id_menu']) ?
        filter_var($_REQUEST['id_menu'], FILTER_SANITIZE_NUMBER_INT) : -1;
    // $douongs = $douong->alldouong_DV($id_dv);

    $douongs = $douong->findDoUongDV($id_dv);
    if (isset($_SESSION['id_user'])) {
        $douong_users = $douong_user->all($_SESSION['id_user'], $id_dv);
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
    <script src="js/validate_area.js"></script>


</head>

<body>
    <!-- Main Page Content -->
    <div class="container">
        <?php include('../partials/navbar.php');
        ?>
       <br><hr>

        <div class="container row">
            <form action="adddouong_user.php" method="post">
                <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                <input type="hidden" name="id_user" value="<?php
                                                            if (isset($_SESSION['id_user'])) {
                                                                echo $_SESSION['id_user'];
                                                            }

                                                            ?>">

                <input type="hidden" name="id_menu" value="<?php echo $id_menu ?>">

                <button class="btn btn-primary" type="submit">Tạo Gói Đồ Uống Mới</button>
            </form>

        </div>
        <div class="container row">
            <h2>Gói của bạn</h2>
            <div class="container row">

                <?php
                if (isset($_SESSION['id_user'])) {
                    if ($douong_users != null) {

                        foreach ($douong_users as $douong_user) :
                            $id_douong_user = $douong_user->getId(); ?>
                            <div class="col-4 p-3">
                                <?php
                                $tong = 0;
                                // $chitiet->getId();
                                $chitiet1 = $chitietdouong->finddouong($id_douong_user);
                                $chitiets = $chitietdouong->showdouong($id_douong_user);
                                // $chitiet2 = $chitiet->showmenu($id);
                                foreach ($chitiets as $chitiet1) : {
                                        // code...



                                ?>

                                        <?php
                                        $idmonn =  $douong->find($chitiet1->id_douong); ?>

                                        <img style="width: 20px;  height: 20px;" src="../img/upload/<?php echo $douong->image; ?>">
                                        <?php
                                        echo 'Món:' . $douong->tendouong;
                                        echo ' : ' . number_format($douong->giadouong) . ' vnđ <br>';
                                        $gia = $idmonn->giadouong;
                                        $tong = $tong + $gia;
                                        ?>

                                <?php }
                                endforeach ?>

                                <p>Tổng Menu: <i class="text-danger"><?php echo $tong; ?></i> vnd</p>
                                <input type="hidden" name="gia_menu" value="<?php echo $tong ?>">
                                <a class="btn-sm btn-primary" href="choose_drink.php?id_menu_douong=<?php echo $douong_user->getId(); ?>&id_dv=<?php echo $id_dv ?>">Thêm đồ uống</a>
                                <a class="btn-sm btn-primary" href="datTiec.php?id_menu=<?php echo $id_menu; ?>&id_dv=<?php echo $id_dv ?>&id_menu_douong=<?php echo $douong_user->getId(); ?>">Chọn gói</a>
                                <a href="" class="btn-sm btn-danger">Xóa</a>

                            </div>
                        <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="text-uppercase  font-weight-bold"><?php
                                                                $dv = $douong_user->id_dv;
                                                                $tendv = $dichvu->find($dv);
                                                                echo $tendv->ten_dv;

                                                                ?>
                </div>


            </div>


        <?php } else { ?>
            <div class="row">
                <div class="col-12 text-center">
                    Bạn chưa tạo gói nào trong dịch vụ này!!!
                </div>

            </div>

    <?php }
                } ?>


        </div>
    </div>
    <?php include('../partials/footer.php'); ?>
    </div>
    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
    <script>
        $(document).ready(function() {
            new WOW().init();

        });
    </script>

</body>

</html>