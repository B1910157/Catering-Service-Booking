<?php
include "../bootstrap.php";

use CT275\Project\User;
use CT275\Project\Category;
$category = new Category($PDO);
$categorys = $category->all();
$user = new User($PDO);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop Máy Ảnh</title>
    <!-- 
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
</head>

<body>
    <!-- Main Page Content -->
    <div class="container ">
        <?php include('../partials/navbar.php');
        ?>
        <hr>
        <div id="login">
            <div  class="bg-image container p-2" style="background-image: url('img/bg.jpeg');">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="process_login.php" method="post">
                                <h3 class="text-center title">ĐĂNG NHẬP</h3>
                                <div class="form-group">
                                    <label for="username" class="text-info">Tên đăng nhập:</label><br>
                                    <input type="text" name="username" id="username" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Mật khẩu:</label><br>
                                    <input type="password" name="password" id="password" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class=" btn btn-success btn-block btn-lg gradient-custom-4 text-body" value="Đăng nhập">
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php include('../partials/footer.php'); ?>
    </div>
    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            new WOW().init();
        });
    </script>
</body>

</html>