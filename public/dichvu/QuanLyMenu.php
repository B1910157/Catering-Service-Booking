<!DOCTYPE html>
<html lang="en">

<!-- <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiệc lưu động</title>
</head> -->

<body>
    <?php
    session_start();
    // include __DIR__ . "/../../bootstrap.php";
    require_once __DIR__ . "/../../bootstrap.php";

    use CT466\Project\Menu;
    use CT466\Project\LoaiMon;
    use CT466\Project\MonAn;
    use CT466\Project\chitiet;
    use CT466\Project\dichvu;
    use CT466\Project\dattiec;

    $loaimon = new LoaiMon($PDO);
    $menu = new Menu($PDO);
    $monan = new MonAn($PDO);
    $chitiet = new chitiet($PDO);
    $dichvu = new dichvu($PDO);
    $dattiec = new dattiec($PDO);


    $monans = $monan->all();
    $dichvus = $dichvu->all();
    $loaimons = $loaimon->all();
    $menus = $menu->allmenu();

    // $menus = $menu->all();
    if (isset($_SESSION['id_dv'])) {
        $id_dv = $_SESSION['id_dv'];
        // echo  $_SESSION['id_dv'];
        $dattiecs = $dattiec->all();
        $dichvuLogin = $dichvu->find($id_dv);
        $menus = $menu->allmenu_DV($id_dv);
    } else {
        echo '<script>alert("Bạn chưa đăng nhập!!!.");</script>';
        echo '<script>window.location.href= "loginDV.php";</script>';
    }
    ?>

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
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">Quản Lý Menu</h2>
                <div class="row">
                    <form class="col-12" action="addMenu.php" enctype="multipart/form-data" method="post">
                        <table class="table">
                            <tr>
                                <th class="text-right">THÊM MENU MỚI: </th>
                                <td>
                                    <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                                </td>
                                <td>
                                    <input require type="text" name="tenmenu" placeholder="Nhập tên menu" value="">
                                    <button type="submit" class="btn-primary">THÊM</button>
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
            </section>
            <h3 class="title text-center">Danh Mục menu</h3>
            <table class="table table-borderd text-center border">
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
                        <th>Giá Menu</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 1;
                    foreach ($menus as $menu) : {
                            // code...
                            $id = $menu->getId();
                    ?>
                            <tr>
                                <td><?php echo $n;
                                    $n++; ?>
                                </td>
                                <td>
                                    <?php echo $menu->tenmenu; ?>
                                </td>
                                <td>
                                    <?php
                                    $tong = 0;
                                    $chitiet->getId();
                                    $chitiet1 = $chitiet->findMenu($id);
                                    $chitiets = $chitiet->all1($id);
                                    foreach ($chitiets as $chitiet1) : {
                                            // code...
                                    ?>
                                            <?php
                                            $idmonn =  $monan->find($chitiet1->id_mon);
                                            $gia = $idmonn->gia_mon;
                                            $tong = $tong + $gia;
                                            // echo $gia;
                                            ?>
                                    <?php }
                                    endforeach ?>
                                    <?php echo $tong, " vnđ"; ?>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="editMenu.php?id_me=<?php echo $id; ?>">Sửa Tên Menu</a>
                                    <a class="btn btn-sm btn-primary" href="choose.php?id_me=<?php echo $id; ?>">Thêm món</a>
                                    <a class="btn btn-sm btn-info" href="chitietmenu.php?id=<?php echo $menu->getId(); ?>">Xem chi tiết</a>
                                    <a class="btn btn-sm btn-danger" href="delMenu.php?id=<?php echo $id; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa Menu</i></a>
                                </td>
                            </tr>
                    <?php }
                    endforeach ?>
                </tbody>
            </table>
        </main>

    </div>
</body>

</html>