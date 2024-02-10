<?php
session_start();
include "../../bootstrap.php";

use CT466\Project\dichvu;
use CT466\Project\loaitiec;

$dichvu = new dichvu($PDO);
$loaitiec = new loaitiec($PDO);

$dichvus = $dichvu->all();
$loaitiecs = $loaitiec->all();



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
    <!-- <script src="../js/validate_area.js"></script> -->



</head>

<body>
    <!-- Main Page Content -->
    <?php include "../../partials/nav_admin.php"; ?>
    <main>
        <div class="container">
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">QUẢN LÝ LOẠI TIỆC</h2>
            <div class="row">
                <form class="col-12" action="add_LT.php" enctype="multipart/form-data" method="post">
                    <table class="table">
                        <tr>
                            <th class="text-right">THÊM LOẠI TIỆC: </th>
                           
                            <td>
                                <input require type="text" name="ten_loai" placeholder="Nhập loại tiệc" value="">
                                <button type="submit" class="btn-primary">THÊM</button>
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
            <div>

                <table class="table">
                    <thead>
                        <th>
                            STT
                        </th>
                        <th>
                            Tên loại món
                        </th>
                        <th>
                            Thao tác
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        foreach ($loaitiecs as $loaitiec) :
                            $loaitiecID = $loaitiec->getId();
                            $n++;
                        ?>
                            <tr>
                                <td>
                                    <?php echo $n; ?>
                                </td>
                                <td>
                                    <?php
                                    // echo  $loaitiec->getId();
                                    echo htmlspecialchars($loaitiec->ten_loai) ?>
                                </td>
                                <td>
                                    <a href="edit_LT.php?id_loaitiec=<?php echo $loaitiecID; ?>" class="btn btn-warning btn-sm " >Sửa</a>
                                    <a href="del_LT.php?id_loaitiec=<?php echo $loaitiecID; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                                </td>
                            </tr>
                    </tbody>
                <?php
                        endforeach; ?>

                </table>

            </div>
        </div>

    </main>

</body>

</html>