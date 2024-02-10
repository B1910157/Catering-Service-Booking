<?php
include "../bootstrap.php";
session_start();

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;
use CT466\Project\User;
use CT466\Project\chitiet;
use CT466\Project\chitietmenu;
use CT466\Project\chitietdouong;
use CT466\Project\menu_user;
use CT466\Project\douong_user;
use CT466\Project\douong;

$douong = new douong($PDO);
$douong_user = new douong_user($PDO);
$chitietdouong = new chitietdouong($PDO);
$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
// $menu = new Menu($PDO);
$dichvu = new dichvu($PDO);
$user = new User($PDO);
$chitietmenu = new chitietmenu($PDO);
$menu_user = new menu_user($PDO);
$chitiet = new chitiet($PDO);


$monans = $monan->all();

$dichvus = $dichvu->allDuyet();

$loaitiecs = $loaitiec->all();


if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
}
if (isset($_GET['id_dv'])) {
    $id_dv = isset($_REQUEST['id_dv']) ?
        filter_var($_REQUEST['id_dv'], FILTER_SANITIZE_NUMBER_INT) : -1;
    $id_menu = isset($_REQUEST['id_menu']) ?
        filter_var($_REQUEST['id_menu'], FILTER_SANITIZE_NUMBER_INT) : -1;
    $dichvuduocchon = $dichvu->find($id_dv);
    // $menus = $menu->allmenu_DV($id_dv);
}


$chitiets = $chitietmenu->showmenu($id_menu);

$douong_users = $douong_user->all($_SESSION['id_user'], $id_dv);
// $chitietdouongs = $chitietdouong->showdouong($id_douong);
// $chitiets = $chitiet->showmenu($id_menu);
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
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">HỖ TRỢ ĐẶT TIỆC TRỰC TUYẾN</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s"> ----------------- </p>
                </div>
            </div>
            <hr>
            <div class="inner-wrapper row">
                <table class="table table-borderd text-center ">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <?php
                                echo 'MENU ĐỒ ĂN';
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <th>STT</th>
                            <th>Tên Món ăn</th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>

                            <th width="15%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tongtien = 0;
                        if ($id_menu < 0 || !($chitietmenu->findMenu($id_menu))) {
                        ?>
                            <tr>
                                <td colspan="5">
                                    <?php
                                    echo "Menu trống";
                                    // redirect(BASE_URL_PATH); 
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <?php
                        $n = 1;
                        // echo "<pre>";
                        // print_r($chitiet);
                        // echo "lhlhlhl";
                        // print_r($chitiets);
                        foreach ($chitiets as $chitiet) : {
                                // code...
                                // $id = $menu->getId();
                        ?>
                                <tr>
                                    <td><?php echo $n;
                                        $n++; ?>
                                    </td>
                                    <td><?php $idmonn =  $monan->find($chitiet->id_mon);
                                        echo $idmonn->tenmon; ?></td>
                                    <td>
                                        <img class="w-25 h-25" src="../img/upload/<?php $idmonn =  $monan->find($chitiet->id_mon);
                                                                                    echo $idmonn->image; ?>">
                                    </td>
                                    <td> <?php
                                            $idmonn =  $monan->find($chitiet->id_mon);
                                            $gia = $idmonn->gia_mon;
                                            $tongtien = $tongtien + $gia;
                                            echo number_format($idmonn->gia_mon, 0, '', '.'); ?><sup> vnđ</sup></td>
                                    <td>
                                        <a href="xoaMonKhoiMenu.php?id_menu=<?php echo $id_menu; ?>&id_mon=<?php echo $monan->getId(); ?>" class="btn btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                                    </td>
                                    </form>
                                </tr>
                        <?php }
                        endforeach ?>
                    </tbody>

                </table>
                <div class="row col-12">
                    <div class="m-2 p-2">
                        <a class="btn btn-sm btn-primary" href="choose_mon.php?id_me=<?php echo $id_menu; ?>&id_dv=<?php echo $id_dv ?>">Thêm món</a>
                    </div>
                </div>

                <div class="row">
                    <div class="m-5">

                        <p> <b> Tổng tiền của Menu:</b> <i class="text-danger"><?php echo  number_format($tongtien) ?></i> VNĐ</p>
                    </div>
                </div>


                <?php
                $tongtiendouong = 0;
                if (isset($_GET['id_menu_douong'])) {
                    $id_menu_douong = $_GET['id_menu_douong'];

                    $chitietdouongs = $chitietdouong->showdouong($id_menu_douong);

                ?>
                    <table class="table table-borderd text-center ">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <?php
                                    echo 'MENU ĐỒ UỐNG';
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Hình ảnh</th>
                                <th width="15%">Giá</th>
                                <th width="15%">Số lượng</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ($id_menu_douong < 0) {
                            ?>
                                <tr>
                                    <td colspan="6">
                                        Menu trống
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <?php

                            $n = 1;
                            // echo "<pre>";
                            // print_r($chitiet);
                            // echo "lhlhlhl";
                            // print_r($chitiets);
                            foreach ($chitietdouongs as $chitiet) : {
                                    // code...
                                    // $id = $menu->getId();
                            ?>
                                    <tr>
                                        <td><?php echo $n;
                                            $n++; ?>
                                        </td>
                                        <td><?php $idmonn =  $douong->find($chitiet->id_douong);
                                            echo $idmonn->tendouong; ?></td>
                                        <td>
                                            <img class="w-25 h-25" src="../img/upload/<?php $idmonn =  $douong->find($chitiet->id_douong);
                                                                                        echo $idmonn->image; ?>">
                                        </td>
                                        <td> <?php
                                                $idmonn =  $douong->find($chitiet->id_douong);
                                                $gia = $idmonn->giadouong;
                                                $tongtiendouong = $tongtiendouong + $gia * ($chitiet->soluong);
                                                echo number_format($idmonn->giadouong, 0, '', '.'); ?><sup> vnđ</sup>/<?php echo $idmonn->dvt ?></td>
                                        <td>
                                            <form action="edit_menu_douong.php" method="post">
                                                <input type="hidden" name="id_douong_user" value="<?php echo $chitiet->id_douong_user; ?>">
                                                <input type="number" name="soluong" value="<?php echo $chitiet->soluong; ?>" placeholder=" <?php echo $chitiet->soluong; ?>" min="1"><?php echo $idmonn->dvt ?>
                                                <input type="hidden" name="id_douong" value="<?php echo $chitiet->id_douong; ?>">

                                                <button type="submit" class="btn-sm btn-warning">Sửa</button>


                                            </form>


                                        </td>
                                        <td>
                                            <a href="xoaMonKhoiMenu.php?id_douong_user=<?php echo $chitiet->id_douong_user; ?>&id_douong=<?php echo $chitiet->id_douong; ?>" class="btn btn-danger" onclick="return confirm('Xác nhận xóa ?')">Xóa</a>
                                        </td>
                                        </form>
                                    </tr>
                            <?php }
                            endforeach ?>
                        </tbody>

                    </table>
                    <?php
                    if (isset($_GET['id_menu_douong'])) {
                        $chitietdouong2 = $chitietdouong->finddouong($_GET['id_menu_douong']);
                        $douong2 = $douong_user->find($_GET['id_menu_douong']);
                        // if($douong2==null){
                        //     echo 'nulll';
                        // }else{
                        //     echo 'co gia tri';
                        // }

                        if (($chitietdouong2 == null && $douong2 != null) || $chitietdouong2 != null) {
                            // echo '<pre>';
                            // print_r($chitietdouong2);
                    ?>
                            <div class=" col-12">
                                <a class="btn btn-sm btn-primary" href="choose_drink.php?id_menu=<?php echo $id_menu; ?>&id_menu_douong=<?php echo $_GET['id_menu_douong'] ?>&id_dv=<?php echo $id_dv ?>">Thêm Đồ Uống</a>

                            </div>

                    <?php
                        }
                    }
                    ?>

                    <div class="container row col-12">
                        <div class="">

                            <p> <b> Tổng tiền Đồ Uống:</b> <i class="text-danger"><?php echo number_format($tongtiendouong)  ?></i> VNĐ</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                        <?php
                    }
                    $tongcong = $tongtiendouong + $tongtien;
                        ?>




                        <?php
                        if (!isset($_GET['id_menu_douong'])) {
                            $_GET['id_menu_douong'] = -1;
                        }
                        $chitietdouong2 = $chitietdouong->finddouong($_GET['id_menu_douong']);
                        $douong2 = $douong_user->find($_GET['id_menu_douong']);
                        if ($douong2 == null && $chitietdouong2 == null) {
                        ?>
                            <div class="container row">

                                <form action="adddouong_user.php" method="post">
                                    <input type="hidden" name="id_dv" value="<?php echo $id_dv; ?>">
                                    <input type="hidden" name="id_user" value="<?php
                                                                                if (isset($_SESSION['id_user'])) {
                                                                                    echo $_SESSION['id_user'];
                                                                                }
                                                                                ?>">
                                    <input type="hidden" name="id_menu" value="<?php echo $id_menu ?>">

                                    <button class="btn btn-primary" type="submit">Tạo Gói Đồ Uống Mới</button>
                                </form>
                            </div>
                            <hr><br><br>
                        <?php
                        }
                        ?>

                        </div>
                    </div>

                    <div class="col-md-12 card-container row ">
                        <div class="col-12 text-center">
                            <form id="dattiec" action="addtiec.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="id_dv" value="<?php echo $id_dv ?>">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id_menu" value="<?php echo $id_menu ?>">
                                </div>
                                <table style="width: 100%;" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                Thông tin đặt tiệc
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                <label for="id_loaitiec">Loại tiệc:</label>
                                            </th>
                                            <td>
                                                <select require name="id_loaitiec" id="id_loaitiec" class="custom-select">
                                                    <option value="" hidden>--Chọn--</option>
                                                    <!-- <option value="">--- Chọn loại tiệc --- </option> -->
                                                    <?php foreach ($loaitiecs as $loaitiec) :
                                                        $loaitiecID = $loaitiec->getId();  ?>
                                                        <option value="<?php echo $loaitiec->getId() ?>">
                                                            <?php
                                                            // echo htmlspecialchars($loaitiec->getId());
                                                            echo htmlspecialchars($loaitiec->ten_loai); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </td>
                                            <th> <label for="tinh">Tỉnh/ Thành phố</label></th>
                                            <td><select require name="tinh" id="tinh" class="custom-select">
                                                    <option value="">--Chọn--</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="giodat">Giờ bắt đầu:</label>
                                            </th>
                                            <td>
                                                <input require type="time" name="giodat" class="form-control" id="giodat" value="<?= isset($_POST['giodat']) ? htmlspecialchars($_POST['giodat']) : '' ?>" />

                                                <?php if (isset($errors['giodat'])) : ?>
                                                    <span class="help-block">
                                                        <strong><?= htmlspecialchars($errors['giodat']) ?></strong>
                                                    </span>
                                                <?php endif ?>
                                            </td>
                                            <th><label for="quan">Quận/ Huyện</label>
                                            </th>
                                            <td>
                                                <select require name="quan" id="quan" class="custom-select">
                                                    <option value="">--Chọn--</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="ngaydat">Ngày diễn ra:</label>

                                            </th>
                                            <td>
                                                <input require type="date" name="ngaydat" class="form-control" id="ngaydat" value="<?= isset($_POST['ngaydat']) ? htmlspecialchars($_POST['ngaydat']) : '' ?>" />

                                                <?php if (isset($errors['ngaydat'])) : ?>
                                                    <span class="help-block">
                                                        <strong><?= htmlspecialchars($errors['ngaydat']) ?></strong>
                                                    </span>
                                                <?php endif ?>

                                            </td>
                                            <th>
                                                <label for="phuong">Phường/ Xã</label>

                                            </th>
                                            <td> <select require name="phuong" id="phuong" class="custom-select">
                                                    <option value="">--Chọn--</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="soluongban">Số lượng bàn:</label>

                                            </th>
                                            <td>
                                                <input type="text" name="soluongban" class="form-control" id="soluongban" placeholder="nhập số lượng bàn" />

                                                <?php if (isset($errors['soluongban'])) : ?>
                                                    <span class="help-block">
                                                        <strong><?= htmlspecialchars($errors['soluongban']) ?></strong>
                                                    </span>
                                                <?php endif ?>
                                            </td>
                                            <th>
                                                <label for="diachitiec">Địa chỉ:</label>

                                            </th>
                                            <td> <input require type="text" name="diachitiec" class="form-control" id="diachitiec" placeholder="Địa chỉ" value="<?= isset($_POST['diachitiec']) ? htmlspecialchars($_POST['diachitiec']) : '' ?>" />

                                                <?php if (isset($errors['diachitiec'])) : ?>
                                                    <span class="help-block">
                                                        <strong><?= htmlspecialchars($errors['diachitiec']) ?></strong>
                                                    </span>
                                                <?php endif ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                                <input type="hidden" name="gia_menu" value="<?php echo $tongtien ?>">
                                <input type="hidden" name="giadouong" value="<?php echo $tongcong - $tongtien ?>">
                                <input type="hidden" name="id_douong" value="<?php if (!isset($_GET['id_menu_douong']) || $chitietdouong2 == null) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $_GET['id_menu_douong'];
                                                             
                                                             } ?>">

                                <div class="row ">
                                    <p class="m-3 col-12"> <b> Đặt cọc 50%</b>, quý khách vui lòng chuyển khoảng 50% để được xác nhận tiệc</p>
                                    
                                    <p class="col-12">STK: <?php echo $dichvuduocchon->stk; ?> - <?php echo $dichvuduocchon->loai_the;?></p>

                                </div>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary" onclick="return confirm('Xác nhận đặt tiệc');">Đặt tiệc</button>

                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                <script type="text/javascript" src="jquery.validate.js"></script>
                                <script>
                                    $.validator.addMethod("ngaydat", function(value) {
                                        var ngayDienRa = new Date();
                                        var ngayDat = new Date(value);
                                        ngayDienRa.setDate(ngayDienRa.getDate() + 1);
                                        if (ngayDat > ngayDienRa) {
                                            return true;
                                        }
                                    });
                                </script>
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
                                                ngaydat: {
                                                    required: true,
                                                    ngaydat: 1,

                                                },
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
                                                ngaydat: {
                                                    required: "Chọn ngày đặt",
                                                    ngaydat: "Ngày đặt không hợp lệ! Vui lòng đặt trước 2 ngày!!!"
                                                },
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
            </div>
        </section>
    </div>
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