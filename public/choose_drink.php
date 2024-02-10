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
    $id_menu_douong = isset($_REQUEST['id_menu_douong']) ?
        filter_var($_REQUEST['id_menu_douong'], FILTER_SANITIZE_NUMBER_INT) : -1;
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
        <h2 class="title">Đồ Uống</h2>
        <div class="container row">
            <?php
            if ($douongs != null) {
                foreach ($douongs as $douong) :
                    $monID = $douong->getId();
            ?>
                    <div class="col-4 p-3">

                        <div class="">
                            <a href="">
                                <img class="w-75" style="height: 150px;" src="../img/upload/<?= htmlspecialchars($douong->image) ?>">
                            </a>
                            <div class="text-uppercase  font-weight-bold"><?= htmlspecialchars($douong->tendouong) ?></div>

                            <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($douong->giadouong, 0, '', '.'); ?> VNĐ/<?php echo $douong->dvt; ?></i></div>
                            <div>
                                <form action="addDoUongVaoMenu.php" method="POST">Số lượng: <input type="number" name="soluong" min="0" value="1"><input type="hidden" name="id_douong" min="0" value="<?php echo $douong->getId(); ?>"> <?php echo $douong->dvt ?>
                                    <input type="hidden" name="id_menu" value="<?php echo $_GET['id_menu'] ?>">
                                    <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                                    <input type="hidden" name="id_menu_douong" value="<?php echo $id_menu_douong; ?>">
                                    <button class="btn btn-primary" type="submit"> <i class="fa fa-plus" aria-hidden="true"></i> </button>

                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            }
            ?>
        </div>
        <a href="datTiec.php?id_menu=<?php echo $_GET['id_menu'] ?>&id_dv=<?php echo $id_dv; ?>&id_menu_douong=<?php echo $id_menu_douong ?>" class="btn btn-primary">Hoàn thành</a>
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