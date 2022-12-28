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
    include __DIR__ . "/../bootstrap.php";
    require_once __DIR__ . "/../bootstrap.php";

    use CT466\Project\Menu;
    use CT466\Project\LoaiMon;
    use CT466\Project\MonAn;


    $loaimon = new LoaiMon($PDO);
    $menu = new Menu($PDO);
    $monan = new MonAn($PDO);
    $monans = $monan->all();
    $loaimons = $loaimon->all();

    $menus = $menu->allmenu();



    $id_loaimon = isset($_REQUEST['id_loaimon']) ?
        filter_var($_REQUEST['id_loaimon'], FILTER_SANITIZE_NUMBER_INT) : -1;
    ?>

    <div class="container">
        <div class="row">
            <form class="col-12" action="addMenu.php" enctype="multipart/form-data" method="post">
                <table class="table">
                    <tr>
                        <td>Tên Menu</td>
                        <td><input require type="text" name="tenmenu" placeholder="Nhập tên menu" value=""></td>
                    </tr>
                    <tr>
                        
                        <a href="index.php">them mon</a>
                    </tr>

                </table>



                <button type="submit">ADD MENU</button>
            </form>
            <hr><br>
            <h3 class="title text-center">Danh Mục menu</h3>
            <div>
                <table width id="menu" class="table table-bordered table-striped text-center">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Tên Menu</th>
                            <th width="15%">Tùy Chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $menu) :
                            $menuID = $menu->getId();
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($menuID) ?></td>
                                <td><?= htmlspecialchars($menu->tenmenu) ?></td>
                                <td>
                                    <a href="choose.php?id_me=<?php echo $menuID;?>">Them mon</a>
                                </td>
                                <td><a class="btn btn-sm btn-danger" href="test.php?id=<?php echo $menuID; ?>"><i class="fa fa-trash" aria-hidden="true"> XÓA</i></a>
                                    <a id="edit" class="btn btn-sm btn-warning" href="test.php?id=<?php echo $menuID; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"> SỬA</i></a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</body>

</html>