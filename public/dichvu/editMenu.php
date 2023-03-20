<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();

use CT466\Project\Menu;

$menu = new menu($PDO);

$id = isset($_REQUEST['id_me']) ?
    filter_var($_REQUEST['id_me'], FILTER_SANITIZE_NUMBER_INT) : -1;
// echo "<script>alert('".$id."');</script>";
if ($id < 0 || !($menu->findMenu($id))) {
    redirect(BASE_URL_PATH);
    // echo "<script>alert('checker');</script>";
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($menu->update($_POST)) {
        // Cập nhật dữ liệu thành công
        //redirect(BASE_URL_PATH);
        echo "<script>alert('Cập nhật tên menu thành công'); </script>";
        echo "<script>window.location.href= 'QuanLyMenu.php';</script>";
    } else {
        // Cập nhật dữ liệu không thành công
        $errors = $menu->getValidationErrors();
        echo "<script>alert('Có lỗi xảy ra');</script>";
        print_r($errors);
    }
}
?>
<div class="">
    <?php include('../../partials/navAdmin.php'); ?>
    <main>
        <div class="row">
            <form class="col-12" action="editMenu.php" enctype="multipart/form-data" method="post">
                <table class="table">
                    <tr>
                        <input hidden type="text" name="id_me" value="<?php echo $id; ?>">
                        <td>Tên Menu</td>
                        <td>
                            <input require type="text" name="tenmenu" placeholder="Nhập tên menu" value="<?php echo $menu->tenmenu; ?>">
                        </td>
                    </tr>
                </table>
                <button type="submit">Sửa menu</button>
            </form>
        </div>
    </main>

</div>
</body>

</html>