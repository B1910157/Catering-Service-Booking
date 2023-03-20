<?php
include "../../bootstrap.php";




use CT466\Project\user;
use CT466\Project\dattiec;
use CT466\Project\dichvu;

$user = new user($PDO);
$dichvu = new dichvu($PDO);
$dattiec = new dattiec($PDO);
$users = $user->all();
$dichvus = $dichvu->allNgungHoatDong();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Amdin</title>
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
    <main>
        <div class="">
            <h2 class="title text-center">
                Quản lý dịch vụ
            </h2>
            <hr>
            <div class="row">
                <div class="col-12 text-right">
                    <a href="qly_DV.php" class="btn btn-success">Dịch vụ đang hoạt động</a>
                    <a href="DVChoDuyet.php" class="btn btn-warning">Dịch vụ đang chờ duyệt</a>
                    <a href="DVNgungHoatDong.php" class="btn btn-danger">Dịch vụ ngưng hoạt động</a>
                    <a href="DVHuy.php" class="btn btn-danger">Dịch vụ đã hủy</a>
                </div>
            </div>
            <h2>Dịch vụ Đang Chờ Duyệt</h2>
            <br>
            <hr>
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>
                            STT
                        </th>
                        <th>
                            Tên dịch vụ
                        </th>
                        <th>
                            SĐT
                        </th>
                        <th>
                            Địa chỉ
                        </th>
                        <th>
                            Phường/Xã
                        </th>
                        <th>
                            Quận/Huyện
                        </th>
                        <th>
                            Tỉnh/Thành Phố
                        </th>
                        
                        <th>
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    foreach ($dichvus as $dichvu) :
                        $dichvuID = $dichvu->getId();

                        $n = $n + 1; ?>
                        <tr>
                            <td>
                                <?php echo $n; ?>
                            </td>
                            <td>
                                <?php
                                // echo  $dichvu->getId();
                                echo htmlspecialchars($dichvu->ten_dv) ?>
                            </td>
                            <td>
                                <?php
                                echo htmlspecialchars($dichvu->sdt) ?>
                            </td>
                            <td>
                                <?php
                                echo htmlspecialchars($dichvu->dv_diachi) ?>
                            </td>
                            <td>
                                <?php
                                echo htmlspecialchars($dichvu->dv_phuong) ?>
                            </td>
                            <td>
                                <?php
                                echo htmlspecialchars($dichvu->dv_quan) ?>
                            </td>
                            <td>
                                <?php
                                echo htmlspecialchars($dichvu->dv_tinh) ?>
                            </td>
                            <td>
                                <a href="xulyDuyet.php?duyet=<?php echo $dichvuID;?>" class="btn btn-success" onclick="return confirm('Xác nhận cho <?php echo $dichvu->ten_dv ?> hoạt động?')">Cho hoạt động</a>
                            </td>
                        </tr>
                </tbody>
            <?php

                    endforeach; ?>
            </table>
    </main>


</body>

</html>