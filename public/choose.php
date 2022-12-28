<?php
session_start();
include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\Menu;
use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\thucdon;

$loaimon = new LoaiMon($PDO);
$menu = new Menu($PDO);
// $thucdon = new thucdon($PDO);
$monan = new MonAn($PDO);
$monans = $monan->all();
$loaimons = $loaimon->all();


$id_loaimon = isset($_REQUEST['id_loaimon']) ?
    filter_var($_REQUEST['id_loaimon'], FILTER_SANITIZE_NUMBER_INT) : -1;


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo $_GET['id_me'];
    $id_menu = $_GET['id_me'];
    $findmenu = $menu->findMenu($id_menu);
    // echo "<pre>"; ;
    // print_r($findmenu);
    $findmenu = $menu->findMenu($id_menu);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="inner-wrapper row">
        <div class="list-group m-3 col-md-2">
            <p class="list-group-item bg-primary">DANH MỤC</p>
            <?php foreach ($loaimons as $loaimon) :
                $loaiID = $loaimon->getId(); ?>
                <a class="list-group-item list-group-item-action" href="monan.php?id_loaimon=<?php echo $loaiID; ?>">
                    <?php htmlspecialchars($loaimon->getId());
                    echo htmlspecialchars($loaimon->tenloaimon) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="col-md-9 card-container">


            <?php foreach ($monans as $monan) :
                if (isset($_GET['id_loaimon']) && $monan->id_loaimon == $_GET['id_loaimon']) {


                    $monanID = $monan->getId();
            ?>

                    <div class="card-item">

                        <a href="detail.php?id=<?php echo $monanID; ?>">

                            <img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($monan->image) ?>">
                        </a>


                        <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                        <div class="p-3 font-weight-bold"><?php $loaimonan =  $loaimon->find($monan->id_loaimon);
                                                            echo $loaimonan->tenloaimon; ?></div>
                        <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>
                        <hr>
                        <form action="addMenu.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?php echo $monan->getId(); ?>">
                        </form>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">>ADD</button>

                        </div>
                    </div>
                <?php } elseif (!isset($_GET['id_loaimon'])) {
                    $monanID = $monan->getId();
                ?>
                    <form action="addMenu.php" method="post" enctype="multipart/form-data">
                        
                        <input type="text" name="idmenu" value="<?php echo $_GET['id_me'] ?>">
                        ID Mon: <input type="text" name="id" min="0" value="<?php echo $monan->getId(); ?>">
                        <a href="detail.php?id=<?php echo $monanID; ?>">
                            <img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($monan->image) ?>">
                        </a>
                        <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                        <div class="p-3 font-weight-bold"><?php $loaimonan =  $loaimon->find($monan->id_loaimon);
                                                            echo $loaimonan->tenloaimon; ?></div>
                        <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>
                        <hr>
                        <button class="btn btn-primary" type="submit">ADDa</button>


                    </form>

            <?php }
            endforeach; ?>
        </div>
    </div>


</body>

</html>