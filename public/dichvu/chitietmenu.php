<?php
session_start();
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";

use CT466\Project\Menu;
use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\dichvu;
use CT466\Project\chitiet;

$dichvu = new dichvu($PDO);
$loaimon = new LoaiMon($PDO);
$menu = new Menu($PDO);
$monan = new MonAn($PDO);
$chitiet = new chitiet($PDO);

$monans = $monan->all();
$loaimons = $loaimon->all();
$id = isset($_REQUEST['id']) ?
    filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
$chitiets = $chitiet->showmenu($id);
$menu->findMenu($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi Tiết Menu</title>
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


<div class="">
    <?php include('../../partials/navAdmin.php');
    ?>
    <main>
        <section id="inner" class="inner-section section">
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Chi Tiết Menu</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s">Đảm bảo chất lượng <i class="fa fa-check" aria-hidden="true"></i></p>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-8">
                <table class="table table-borderd text-center">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <?php
                                echo $menu->tenmenu;
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <th>STT</th>
                            <th>Tên Món ăn</th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>
                            <th>Tùy chọn</th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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

                                    <td class="row">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-6">
                                            <img class="w-100 h-100" src="../img/upload/<?php $idmonn =  $monan->find($chitiet->id_mon);
                                                                                        echo $idmonn->image; ?>">
                                        </div>
                                        <div class="col-3">
                                        </div>
                                    </td>
                                    <td> <?php
                                            $idmonn =  $monan->find($chitiet->id_mon);
                                            $gia = $idmonn->gia_mon;
                                            echo number_format($idmonn->gia_mon, 0, '', '.'); ?><sup> vnđ</sup></td>
                                    <td> <a class="btn btn-sm btn-danger" href="XoaMonMenu.php?idmenu=<?php echo $id; ?>&idmon=<?php echo $chitiet->id_mon ?>"><i class="fa fa-trash" aria-hidden="true" onclick="return confirm('Xác nhận xóa?')"> XÓA</i></a> </td>
                                    <td>
                                    </td>
                                    </form>
                                </tr>
                        <?php }
                        endforeach ?>
                    </tbody>
                </table>
                <a class="btn btn-primary" href="choose.php?id_me=<?php echo $id; ?>">Thêm món mới</a>
            </div>
            <div class="col-2">
            </div>
        </div>
    </main>
</div>


</html>