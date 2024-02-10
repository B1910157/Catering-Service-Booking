<?php
include "../bootstrap.php";
session_start();

use CT466\Project\user;

$user = new user($PDO);
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $userLogin = $user->find($id_user);
   
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "login.php";</script>';
}


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "pre";
    print_r($_POST);
    if ($user->updateInfo($_POST)) {
        // Cập nhật dữ liệu thành công
        //redirect(BASE_URL_PATH);
        echo "<script>alert('Cập nhật thông tin thành công'); </script>";
        echo "<script>window.location.href= 'thongtincanhan.php';</script>";
    } else {
        // Cập nhật dữ liệu không thành công
        $errors = $user->getValidationErrors();
        echo "<script>alert('Có lỗi xảy ra');</script>";
        print_r($errors);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

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

    <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
    <script src="../js/validate_area.js"></script>


</head>

<body>
    <!-- Main Page Content -->
    <div class="container">
        <?php include('../partials/navbar.php');
        ?>
        <main>
            <section id="inner" class="inner-section section">
                <!-- SECTION HEADING -->
                <hr>
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s"><?php echo $userLogin->fullname;  ?></h2>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="wow fadeIn note" data-wow-duration="2s">SDT: <?php echo $userLogin->sdt;  ?></p>
                    </div>
                </div>
                <hr>
                <div>
                    <form action="edit_info.php" enctype="multipart/form-data" method="post">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Tên dịch vụ: </th>
                                    <td> <input type="text" name="username" value="<?php echo $userLogin->username; ?>"></td>
                                    <th>Địa chỉ:</th>
                                    <td>
                                        <input type="text" name="diachi" value="<?php echo $userLogin->diachi ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email: </th>
                                    <td><input type="text" name="email" value="<?php
                                                                                echo $userLogin->email;

                                                                                ?>"></td>
                                    <th>Quận/Huyện:</th>
                                    <td>
                                        <input type="text" name="quan" value=" <?php echo $userLogin->quan; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>SĐT: </th>
                                    <td><input type="text" name="sdt" value="<?php
                                                                                echo $userLogin->sdt;

                                                                                ?>"></td>
                                    <th>Phường/Xã:</th>
                                    <td>
                                        <input type="text" name="phuong" value=" <?php echo $userLogin->phuong; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tỉnh/Thành Phố:</th>
                                    <td>
                                        <input type="text" name="tinh" value=" <?php echo $userLogin->tinh; ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-warning">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>

</html>