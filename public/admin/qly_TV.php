<?php

include "../../bootstrap.php";

use CT466\Project\User;

$user = new User($PDO);
$users = $user->all();


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


    <?php include "../../partials/nav_admin.php"; ?>
    <hr>
    <div>
        <h2 class="title text-center">Quản lý thành viên</h2>
    </div>
    <hr>
    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ Tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Ngày Tạo Tài Khoản</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $n=1;
                foreach ($users as $user) :
                    $userID = $user->getId();

                ?>
                    <tr>
                        <td><?= htmlspecialchars($n) ?></td>
                        <td><?= htmlspecialchars($user->fullname) ?></td>
                        <td><?= htmlspecialchars($user->sdt) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>

                        <td>
                            <?php echo $user->diachi, ', ', $user->phuong, ', ', $user->quan, ', ', $user->tinh; ?>
                        </td>
                        <td><?= htmlspecialchars($user->created_day) ?></td>


                    </tr>
                <?php
                $n = $n + 1;
                endforeach ?>

            </tbody>
        </table>
    </div>
</body>

</html>