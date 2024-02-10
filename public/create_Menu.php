<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;

use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;
use CT466\Project\chitiet;
use CT466\Project\chitietmenu;
use CT466\Project\menu_user;



$menu_user = new menu_user($PDO);
$chitietmenu = new chitietmenu($PDO);
$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);
$chitiet = new chitiet($PDO);



if (isset($_GET['id_dv'])) {
    $id_dv = isset($_REQUEST['id_dv']) ?
        filter_var($_REQUEST['id_dv'], FILTER_SANITIZE_NUMBER_INT) : -1;
    $menus = $menu->allmenu_DV($id_dv);

    $monans = $monan->findMonDV($id_dv);
    if(isset($_SESSION['id_user'])){
        $menu_users = $menu_user->all($_SESSION['id_user'], $id_dv);
       
    }
    
   

}

$dichvus = $dichvu->allDuyet();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();


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
        <h2 class="title">Món ăn</h2>
        <div class="container row">

            <?php foreach ($monans as $monan) :
                $monID = $monan->getId(); 
                
                ?>
                <div class="col-4 p-3">
                   
                    <div class="">
                        <a href="">
                            <img class="w-75" style="height: 150px;" src="../img/upload/<?= htmlspecialchars($monan->image) ?>">
                        </a>
                        <div class="text-uppercase  font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                        <div class="font-weight-bold"><?php $loai =  $loaimon->find($monan->id_loaimon);
                                                        echo $loai->tenloaimon; ?></div>
                        <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ/ 1 Bàn (10 người)</i></div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
       
<hr><br>
        <div class="container row">
            <form action="addMenu_User.php" method="post">
                <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                <input type="hidden" name="id_user" value="<?php
                                                            if (isset($_SESSION['id_user'])) {
                                                                echo $_SESSION['id_user'];
                                                            }

                                                            ?>">



                <button class="btn btn-primary" type="submit" >Tạo menu </button>
            </form>
            <?php
            // $chitietmenu1 = $chitietmenu->findMenu($chitietmenu->getId());
            // echo '<pre>';
            // print_r($chitietmenu1);
            ?>

        </div>
        <div class="container row">
            <h2>Menu của bạn</h2>
            <div class="container row">
            
                <?php
                if(isset($_SESSION['id_user'])){
                    if ($menu_users != null) {

                        foreach ($menu_users as $menu_user) :
                            $id_menu_user = $menu_user->getId(); ?>
                            <div class="col-4 p-3">
                                <?php
                                $tong = 0;
                                // $chitiet->getId();
                                $chitiet1 = $chitietmenu->findMenu($id_menu_user);
                                $chitiets = $chitietmenu->showmenu($id_menu_user);
                                // $chitiet2 = $chitiet->showmenu($id);
                                foreach ($chitiets as $chitiet1) : {
                                        // code...

                
                
                            ?>
                                    <?php
                                    $idmonn =  $monan->find($chitiet1->id_mon); ?>

                                    <img style="width: 20px;  height: 20px;" src="../img/upload/<?php echo $monan->image; ?>">
                                    <?php
                                    echo 'Món:' . $monan->tenmon;
                                    echo ' : ' . number_format($monan->gia_mon) . ' vnđ <br>';
                                    $gia = $idmonn->gia_mon;
                                    $tong = $tong + $gia;
                                    ?>
                            <?php }
                            endforeach ?>
                            <p>Tổng Menu: <i class="text-danger"><?php echo $tong; ?></i> vnd</p>
                            <input type="hidden" name="gia_menu" value="<?php echo $tong ?>">
                            <a class="btn btn-primary" href="datTiec.php?id_menu=<?php echo $menu_user->getId(); ?>&id_dv=<?php echo $id_dv ?>">Chọn menu</a>


                        </div>
                    <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="text-uppercase  font-weight-bold"><?php
                                                                $dv = $menu_user->id_dv;
                                                                $tendv = $dichvu->find($dv);
                                                                echo $tendv->ten_dv;

                                                                ?>
                </div>


            </div>


        <?php } else { ?>
            <div class="row">
                <div class="col-12 text-center">
                    Bạn chưa tạo menu nào trong dịch vụ này!!!
                </div>

            </div>

        <?php } 
    }?>


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