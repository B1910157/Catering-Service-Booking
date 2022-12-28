<?php
include "../bootstrap.php";
session_start();
use CT275\Project\Product;
use CT275\Project\Category;
$category = new Category($PDO);
$product = new Product($PDO);
$products = $product->getNewProducts();
use CT275\Project\User;
$user = new User($PDO);
$categorys = $category->all();
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
    <div class="container">
        <?php include('../partials/navbar.php');
        ?>
        <section id="inner" class="inner-section section">
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">LIÊN HỆ</h2>
            <hr>
            <div class="row">
                <div class="col-8">
                    <p>Chúng tôi rất vui khi được nghe ý kiến từ các bạn!!!</p>
                    Nội dung liên hệ của bạn:
                    <form action="#">
                        <div class="form-group m-3">
                            <label class="font-weight-bold">Họ tên của bạn:</label>
                            <input type="text" class="form-control" placeholder="Nhập vào họ tên của bạn">
                        </div>
                        <div class="form-group m-3">
                            <label class="font-weight-bold">Email:</label>
                            <input type="email" class="form-control" placeholder="Nhập vào email">
                        </div>
                        <div class="form-group m-3">
                            <label class="font-weight-bold">Nội dung liên hệ:</label><br>
                            <textarea name="noidung" id="noidung" cols="92" rows="5" placeholder="Nội dung liên hệ ..."></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary m-3 ">Gửi liên hệ</button>
                        </div>

                    </form>
                </div>
                <div class="col-4 text-center">
                    <h5 class="mt-5 text-secondary">Bản đồ</h5>
                    <p>
                        <a href="#">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15729855.42909206!2d96.7382165931671!3d15.735434000981483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31157a4d736a1e5f%3A0xb03bb0c9e2fe62be!2zVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1445179448264" width="200" height="200" frameborder="0" style="border:0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                            <br />
                        </a>
                        <br />
                        <a href="#">Xem bản đồ</a>
                    </p>
                    <p>
                    <br>
                    <i>Đường 30/2, Phường Xuân Khánh, Quận Ninh Kiều, TP. Cần Thơ</i>
                    </p>
                </div>

            </div>



        </section>
        <?php include('../partials/footer.php'); ?>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
    <script>
        $(document).ready(function() {
            new WOW().init();
        });
    </script>
</body>

</html>