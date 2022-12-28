<?php
session_start();
include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";

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
$menus = $menu->allmenu();



// $id = isset($_REQUEST['id']) ?
//     filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
// if ($id < 0 || !($chitiet->findMenu($id))) {
//     redirect(BASE_URL_PATH);
// }

// $chitiets = $chitiet->showmenu($id);



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
                <th>Tên Menu</th>
                <th>chi tiết</th>
                
                <th width="15%"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 1;
            foreach ($menus as $menu) : {
                    // code...
                    // $id = $menu->getId();
            ?>

                    <tr>

                        <td><?php echo $n;
                            $n++; ?>
                        </td>
                        <td>
                            <?php echo $menu->tenmenu; ?>
                        </td>
                        <td>

                           <a href="chitietmenu.php?id=<?php echo $menu->getId(); ?>">chi tiet <?php   echo $menu->getId(); ?></a>
                        </td>
                        </form>
                    </tr>
                    <tr>
                        
                    </tr>

            <?php }
            endforeach ?>

        </tbody>
    </table>

</body>

</html>