<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;

$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$dichvu = new dichvu($PDO);

$monans = $monan->all();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();
$dichvus = $dichvu->allDuyet();

$id_loaitiec = isset($_REQUEST['id_loaitiec']) ?
    filter_var($_REQUEST['id_loaitiec'], FILTER_SANITIZE_NUMBER_INT) : -1;
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
    <script src="js/validate_area.js"></script>


</head>

<body>
    <!-- Main Page Content -->
    <div class="container">
        <?php include('../partials/navbar.php');
        ?>
        <section id="inner" class="inner-section section">
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">SẢN PHẨM</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s">Đảm bảo chất lượng <i class="fa fa-check" aria-hidden="true"></i></p>
                </div>
            </div>
            <hr>
            <div class="inner-wrapper row">
                <div class="list-group m-3 col-md-2">
                    <p class="list-group-item bg-primary">DANH MỤC</p>
                    <?php foreach ($loaimons as $loaimon) :
                        $loaiID = $loaimon->getId(); ?>
                        <a class="list-group-item list-group-item-action" href="monan.php?id_loaimon=<?php echo $loaiID; ?>">
                            <?php htmlspecialchars($loaimon->getId());
                            echo htmlspecialchars($loaimon->tenloaimon) ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="col-md-9 card-container">
                    <form  action="xuly_DK_DV.php" id="dkiDV"  enctype="multipart/form-data" method="post">
                        <div class="form-outline mb-4">
                            <label class="form-label text-info">Tên Dịch Vụ </label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" name="ten_dv" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label text-info">Email</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" name="email" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label text-info">Mật khẩu</label>
                            <input autocomplete="off" type="password" class="form-control form-control-lg" name="password" id="password" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label text-info">Nhập lại mật khẩu</label>
                            <input autocomplete="off" type="password" class="form-control form-control-lg" name="password2" />
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label text-info">Số điện thoại</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" name="sdt" />
                        </div>
                        <div class="form-group">
                            <label for="tinh">Tỉnh/ Thành phố</label>
                            <select require name="tinh" id="tinh" class="custom-select">
                                <option value="">--Chọn--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quan">Quận/ Huyện</label>
                            <select require name="quan" id="quan" class="custom-select">
                                <option value="">--Chọn--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phuong">Phường/ Xã</label>
                            <select require name="phuong" id="phuong" class="custom-select">
                                <option value="">--Chọn--</option>
                            </select>
                        </div>
                        <div class="form-group<?= isset($errors['diachi']) ? ' has-error' : '' ?>">
                            <label for="diachi">Địa chỉ:</label>
                            <input require type="text" name="diachi" class="form-control" id="diachi" placeholder="Địa chỉ" value="<?= isset($_POST['diachi']) ? htmlspecialchars($_POST['diachi']) : '' ?>" />

                            <?php if (isset($errors['diachi'])) : ?>
                                <span class="help-block">
                                    <strong><?= htmlspecialchars($errors['diachi']) ?></strong>
                                </span>
                            <?php endif ?>
                        </div>
                        <div class="form-group<?= isset($errors['image']) ? ' has-error' : '' ?>">
                            <label for="image">Hình ảnh Dịch Vụ:</label>
                            <input type="file" name="image" class="form-control" maxlen="255" id="image"  value="<?= isset($_POST['image']) ? htmlspecialchars($_POST['image']) : '' ?>" />

                            <?php if (isset($errors['image'])) : ?>
                                <span class="help-block">
                                    <strong><?= htmlspecialchars($errors['image']) ?></strong>
                                </span>
                            <?php endif ?>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Đăng ký</button>
                        </div>

                        <p class="text-center text-muted mt-5 mb-0">Bạn đã có tài khoản? <a href="loginDV.php" class="fw-bold text-body"><u>Đăng nhập</u></a></p>


                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script type="text/javascript" src="./js/jquery.validate.js"></script>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                new WOW().init();
                                $("#dkiDV").validate({
                                    rules: {
                                        ten_dv: "required",
                                        email: "required",
                                        password: {
                                            required: true,
                                            minlength: 5
                                        },
                                        password2: {
                                            required: true,
                                            minlength: 5,
                                            equalTo: "#password"
                                        },
                                        sdt: "required",
                                        tinh: "required",
                                        quan: "required",
                                        phuong: "required",
                                        diachi: {
                                            required: true
                                        }
                                    },

                                    messages: {
                                        ten_dv: "Nhập vào tên dịch vụ",
                                        email: "Nhập vào email",


                                        password: {
                                            required: "Vui lòng nhập mật khẩu",
                                            minlength: "Mật khẩu ít nhất 5 kí tự"
                                        },

                                        password2: {
                                            required: "Vui lòng nhập lại mật khẩu",
                                            minlength: "mật khẩu ít nhất 5 kí tự",
                                            equalTo: "Nhập lại mật khẩu không trùng khớp"
                                        },
                                        sdt: "Nhập vào số điện thoại",
                                        tinh: "Vui lòng chọn tỉnh/thành phố",
                                        quan: "Vui lòng chọn Quận/Huyện",
                                        phuong: "Vui lòng chọn Phường/Xã",
                                        diachi: {
                                            required: "Nhập vào địa chỉ của bạn"
                                        }

                                    },
                                    errorElement: "div",
                                    errorPlacement: function(error, element) {
                                        error.addClass("invalid-feedback");
                                        if (element.prop("type") === "checkbox") {
                                            error.insertAfter(element.siblings("label"));
                                        } else {
                                            error.insertAfter(element);
                                        }
                                    },
                                    highlight: function(element, errorClass, validClass) {
                                        $(element).addClass("is-invalid").removeClass("is-valid");
                                    },
                                    unhighlight: function(element, errorClass, validClass) {
                                        $(element).addClass("is-valid").removeClass("is-invalid");
                                    }
                                });
                            });
                        </script>
                    </form>
                </div>


            </div>


        </section>
        <?php include('../partials/footer.php'); ?>
    </div>

    <script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>


    <script>
        $(document).ready(function() {
            new WOW().init();

        });
    </script>

</body>

</html>