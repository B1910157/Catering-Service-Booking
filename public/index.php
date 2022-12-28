<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;


$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);

$menus = $menu->allmenu();
$monans = $monan->all();

$dichvus = $dichvu->all();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();

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
                    <form id="dattiec" action="addtiec.php" method="post" enctype="multipart/form-data">




                        <div class="form-group">
                            <label for="id_dv">Chọn dịch vụ</label>
                            <select require name="id_dv" id="id_dv" class="custom-select">
                                <option value="">--Chọn--</option>
                                <?php foreach ($dichvus as $dichvu) :

                                    $dichvuID = $dichvu->getId(); ?>

                                    <option>
                                        <?php
                                        echo  $dichvu->getId();
                                        echo htmlspecialchars($dichvu->ten_dv) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_menu">Chọn Menu</label>
                            <select require name="id_menu" id="id_menu" class="custom-select">
                                <option value="">--Chọn--</option>
                                <?php foreach ($menus as $menu) :

                                    $menuID = $menu->getId(); ?>

                                    <option>
                                        <?php
                                        echo  $menu->getId();
                                        echo htmlspecialchars($menu->tenmenu) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="form-group<?= isset($errors['id_loaitiec']) ? ' has-error' : '' ?>">
                            <label for="id_loaitiec">Loại tiệc:</label>

                            <select require name="id_loaitiec" id="id_loaitiec" class="custom-select">
                                <option value="">--Chọn--</option>
                                <!-- <option value="">--- Chọn loại tiệc --- </option> -->
                                <?php foreach ($loaitiecs as $loaitiec) :

                                    $loaitiecID = $loaitiec->getId(); ?>

                                    <option>
                                        <?php
                                        echo  $loaitiec->getId();;
                                        echo htmlspecialchars($loaitiec->ten_loai) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group<?= isset($errors['soluongban']) ? ' has-error' : '' ?>">
                            <label for="soluongban">Số lượng bàn:</label>
                            <input type="text" name="soluongban" class="form-control" id="soluongban" placeholder="nhập số lượng bàn" />

                            <?php if (isset($errors['soluongban'])) : ?>
                                <span class="help-block">
                                    <strong><?= htmlspecialchars($errors['soluongban']) ?></strong>
                                </span>
                            <?php endif ?>
                        </div>
                        <div class="form-group<?= isset($errors['giodat']) ? ' has-error' : '' ?>">
                            <label for="giodat">Giờ bắt đầu:</label>
                            <input require type="time" name="giodat" class="form-control" id="giodat" value="<?= isset($_POST['giodat']) ? htmlspecialchars($_POST['giodat']) : '' ?>" />

                            <?php if (isset($errors['giodat'])) : ?>
                                <span class="help-block">
                                    <strong><?= htmlspecialchars($errors['giodat']) ?></strong>
                                </span>
                            <?php endif ?>
                        </div>
                        <div class="form-group<?= isset($errors['ngaydat']) ? ' has-error' : '' ?>">
                            <label for="ngaydat">Ngày diễn ra:</label>
                            <input require type="date" name="ngaydat" class="form-control" id="ngaydat" value="<?= isset($_POST['ngaydat']) ? htmlspecialchars($_POST['ngaydat']) : '' ?>" />

                            <?php if (isset($errors['ngaydat'])) : ?>
                                <span class="help-block">
                                    <strong><?= htmlspecialchars($errors['ngaydat']) ?></strong>
                                </span>
                            <?php endif ?>
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
                        <div class="form-group<?= isset($errors['diachitiec']) ? ' has-error' : '' ?>">
                            <label for="diachitiec">Địa chỉ:</label>
                            <input require type="text" name="diachitiec" class="form-control" id="diachitiec" placeholder="Địa chỉ" value="<?= isset($_POST['diachitiec']) ? htmlspecialchars($_POST['diachitiec']) : '' ?>" />

                            <?php if (isset($errors['diachitiec'])) : ?>
                                <span class="help-block">
                                    <strong><?= htmlspecialchars($errors['diachitiec']) ?></strong>
                                </span>
                            <?php endif ?>
                        </div>


                        
                        <input hidden type="text" name="id_user" value="<?php echo "999"; ?>">


                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Đặt tiệc</button>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script type="text/javascript" src="jquery.validate.js"></script>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#dattiec").validate({
                                    rules: {
                                        id_dv: "required",
                                        id_loaitiec: "required",

                                        soluongban: {
                                            required: true,
                                            min: 10,
                                            max: 500
                                        },
                                        giodat: "required",
                                        ngaydat: "required",
                                        tinh: "required",
                                        quan: "required",
                                        phuong: "required",
                                        diachitiec: "required"
                                    },

                                    messages: {
                                        id_dv: "Chọn dịch vụ",
                                        id_loaitiec: "Chọn loại tiệc",
                                        soluongban: {
                                            required: "Nhập số lượng bàn",
                                            min: "Phục vụ từ 10 bàn",
                                            max: "Số bàn quá lớn"
                                        },
                                        giodat: "Chọn giờ đặt",
                                        ngaydat: "Chọn ngày đặt",
                                        tinh: "Chọn Tỉnh/Thành Phố ",
                                        quan: "Chọn Quận/Huyện thành",
                                        phuong: "Chọn Phường/Xã",
                                        diachitiec: "Vui lòng nhập địa chỉ"



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