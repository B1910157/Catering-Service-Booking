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

    $loaimon = new LoaiMon($PDO);
    $menu = new Menu($PDO);
    $monan = new MonAn($PDO);
    $chitiet = new chitiet($PDO);

    $monans = $monan->all();
    $loaimons = $loaimon->all();
    $menus = $menu->allmenu();

    // $menus = $menu->all();

    $menuID = isset($_REQUEST['id_menu']) ?
        filter_var($_REQUEST['id_menu'], FILTER_SANITIZE_NUMBER_INT) : -1;
    ?>
    ?>


    <div class="container">
        <div class="row">
            <form class="col-12" action="addMenu.php" enctype="multipart/form-data" method="post">
                <table class="table">
                    <tr>
                        <td>Tên Menu</td>
                        <td><input require type="text" name="tenmenu" placeholder="Nhập tên menu" value=""></td>
                    </tr>
                </table>



                <button type="submit">ADD MENU</button>
            </form>
            <hr><br><br>
            <h3 class="title text-center">Danh Mục menu</h3>



        </div>

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
                                 <?php echo $tong," vnd"; ?>
                            </td>
                    <td>
                        <a class="btn btn-sm btn-danger" href="delMenu.php?id=<?php echo $id; ?>"><i class="fa fa-trash" aria-hidden="true">XÓA Menu</i></a>
                        <a class="text-warning" href="editMenu.php?id_me=<?php echo $id; ?>">Sửa Menu</a>
                        <a class="text-danger" href="choose.php?id_me=<?php echo $id; ?>">Thêm món</a>
                        <a href="chitietmenu.php?id=<?php echo $menu->getId(); ?>">chi tiet <?php echo $menu->getId(); ?></a>
                    </td>
                    </form>
                        </tr>
                        <tr>

                        </tr>

                <?php }
                endforeach ?>

            </tbody>
        </table>



    </div>
</body>

</html>