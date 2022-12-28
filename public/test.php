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

echo "hello";

//Menu////////
?>

<table width id="menu" class="table table-bordered table-striped text-center">
<thead class="text-center">
    <tr>
        <th>ID</th>
        <th>id Menu</th>
        <th width="15%">id mon</th>
        <th></th>
        <th></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($chitiets as $chitiet) :
        $menuID = $chitiet->id_menu;
    ?>
        <tr>
            <td><?= htmlspecialchars($menuID) ?></td>
            <td>
                <?= htmlspecialchars($chitiet->id_menu) ?>

            </td>
            <td>
                <?= htmlspecialchars($chitiet->id_mon) ?>

            </td>
            <td>
                <a href="choose.php?id_me=<?php echo $menuID; ?>">Them mon</a>
            </td>
            <td><a class="btn btn-sm btn-danger" href="test.php?id=<?php echo $menuID; ?>"><i class="fa fa-trash" aria-hidden="true"> XÓA</i></a>
                <a id="edit" class="btn btn-sm btn-warning" href="test.php?id=<?php echo $menuID; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"> SỬA</i></a>
                <a href="chitietmenu.php?id=<?php echo $menuID; ?>">Chi tiết <?php echo $menuID; ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>