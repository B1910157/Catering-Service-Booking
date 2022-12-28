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


    $id_loaimon = isset($_REQUEST['id_loaimon']) ?
        filter_var($_REQUEST['id_loaimon'], FILTER_SANITIZE_NUMBER_INT) : -1;
    ?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <?php foreach ($monans as $monan) :
                    if (isset($_GET['id_loaimon']) && $monan->id_loaimon == $_GET['id_loaimon']) {
                        $monanID = $monan->getId();
                ?>
                        <form action="test.php" method="post">ID Mon: <input type="number" name="id" min="0" value="<?php echo $monan->getId(); ?>">
                            <a href="detail.php?id=<?php echo $monanID; ?>">
                                <img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($monan->image) ?>">
                            </a>
                            <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                            <div class="p-3 font-weight-bold"><?php $loaimonan =  $loaimon->find($monan->id_loaimon);
                                                                echo $loaimonan->tenloaimon; ?></div>
                            <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>
                            <hr>
                            <button class="btn btn-primary" type="submit">ADD</button>


                        </form>


                    <?php } elseif (!isset($_GET['id_loaimon'])) {
                        $monanID = $monan->getId();
                    ?>
                        <form action="test.php" method="post">ID Mon: <input type="number" name="id" min="0" value="<?php echo $monan->getId(); ?>">
                            <a href="detail.php?id=<?php echo $monanID; ?>">
                                <img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($monan->image) ?>">
                            </a>
                            <div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($monan->tenmon) ?></div>
                            <div class="p-3 font-weight-bold"><?php $loaimonan =  $loaimon->find($monan->id_loaimon);
                                                                echo $loaimonan->tenloaimon; ?></div>
                            <div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($monan->gia_mon, 0, '', '.'); ?> VNĐ</i></div>
                            <hr>
                            <button class="btn btn-primary" type="submit">ADD</button>


                        </form>

                <?php }
                endforeach; ?>
            </div>
            <div class="col-6">
                menu

            </div>

        </div>

    </div>
</body>

</html>