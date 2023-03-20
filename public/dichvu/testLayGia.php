<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    include __DIR__ . "/../../bootstrap.php";
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
    ?>


    <div class="container">
        <div class="row">
            <form class="col-12" action="addMenu.php" enctype="multipart/form-data" method="post">
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
                            <th>chi tiết</th>


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
                                        <?php echo $tong, " vnd"; ?>




                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-danger" href="delMenu.php?id=<?php echo $id; ?>"><i class="fa fa-trash" aria-hidden="true">XÓA Menu</i></a>
                                        <a class="text-warning" href="editMenu.php?id_me=<?php echo $id; ?>">Sửa Menu</a>
                                        <a class="text-danger" href="choose.php?id_me=<?php echo $id; ?>">Thêm món</a>
                                        <a href="chitietmenu.php?id=<?php echo $menu->getId(); ?>">chi tiet <?php echo $menu->getId(); ?></a>
                                    </td>

                                </tr>
                                <tr>

                                </tr>

                        <?php }
                        endforeach ?>

                    </tbody>
                </table>
                <input type="text" name="giamenu" value="<?php echo $tong;?>">
                <button type="submit">ADD MENU</button>

            </form>


            <hr><br><br>
            <h3 class="title text-center">Danh Mục menu</h3>



        </div>





    </div>

</body>

</html>