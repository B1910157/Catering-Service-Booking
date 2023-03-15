<?php

session_start();
include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\Menu;
use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\chitiet;


$loaimon = new LoaiMon($PDO);
$menu = new Menu($PDO);
$monan = new MonAn($PDO);
$chitiet = new chitiet($PDO);

$monans = $monan->all();
$loaimons = $loaimon->all();




$id = isset($_REQUEST['id']) ?
    filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;


$chitiets = $chitiet->showmenu($id);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop Máy ảnh</title>
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
    <table class="table table-borderd text-center ">
        <thead>
            <tr>
                <th>
                    <?php
                    echo 'MENU';
                    ?>
                </th>

            </tr>
            <tr>
                <th>STT</th>
                <th>Tên Món ăn</th>
                <th>Hình ảnh</th>

                <th>Giá</th>
                
                <th width="15%"></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $tongtien = 0;
            if ($id < 0 || !($chitiet->findMenu($id))) {
            ?>
                <tr>
                    <td colspan="5">
                        <?php
                        echo "Menu trống";
                        // redirect(BASE_URL_PATH); 
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            <?php
            $n = 1;
            // echo "<pre>";
            // print_r($chitiet);
            // echo "lhlhlhl";
            // print_r($chitiets);
            foreach ($chitiets as $chitiet) : {
                    // code...
                    // $id = $menu->getId();
            ?>

                    <tr>

                        <td><?php echo $n;
                            $n++; ?>
                        </td>
                        <td><?php $idmonn =  $monan->find($chitiet->id_mon);
                            echo $idmonn->tenmon; ?></td>

                        <td>
                            <img class="w-25 h-25" src="../img/upload/<?php $idmonn =  $monan->find($chitiet->id_mon);
                                                                        echo $idmonn->image; ?>">
                        </td>
                        <td> <?php

                                $idmonn =  $monan->find($chitiet->id_mon);
                                $gia = $idmonn->gia_mon;
                                $tongtien = $tongtien+$gia;

                                echo number_format($idmonn->gia_mon, 0, '', '.'); ?><sup> vnđ</sup></td>
                        <td>


                        </td>
                        </form>
                    </tr>
                  

            <?php }
            endforeach ?>

        </tbody>
        <tr>
            <td width="20%">
                tổng tiền: <i class="text-danger"><?php echo $tongtien?></i> VNĐ
            </td>
        </tr>
    </table>

</body>

</html>