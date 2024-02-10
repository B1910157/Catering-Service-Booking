<?php
include "../../bootstrap.php";
session_start();

use CT466\Project\dichvu;

$dichvu = new dichvu($PDO);

$dichvus = $dichvu->allDuyet();

if (isset($_SESSION['id_dv'])) {
    $id_dv = $_SESSION['id_dv'];
    $dichvuLogin = $dichvu->find($id_dv);
} else {
    echo '<script>alert("Bạn chưa đăng nhập!!!!!.");</script>';
    echo '<script>window.location.href= "../loginDV.php";</script>';
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
    <div class="">
        <?php include('../../partials/navAdmin.php');
        ?>
        <main>
            <section id="inner" class="inner-section section">
                <!-- SECTION HEADING -->
                <hr>
                <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s"><?php echo $dichvuLogin->ten_dv;  ?></h2>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="wow fadeIn note" data-wow-duration="2s">SDT: <?php echo $dichvuLogin->sdt;  ?></p>
                    </div>
                </div>
                <hr>
                <div>
                    <form method="post" action="xulyPass.php" id="updatePass">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="4" class="title">Đổi mật khẩu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Mật khẩu cũ: </th>
                                    <td><input type="password" name="passold" placeholder="Nhập vào mật khẩu cũ" required></td>

                                </tr>
                                <tr>
                                    <th>Mật khẩu mới: </th>
                                    <td><input type="password" name="passnew1" placeholder="Nhập vào mật khẩu mới" id="passnew1" required></td>
                                </tr>
                                <tr>
                                    <th>Nhập lại mật khẩu: </th>
                                    <td><input type="password" name="passnew2" placeholder="Nhập lại mật khẩu mới"></td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-warning">Cập nhật thay đổi</button>
                            </div>

                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script type="text/javascript" src="./jquery.validate.js"></script>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                new WOW().init();
                                $("#updatePass").validate({
                                    rules: {
                                        passold: "required",

                                        passnew1: {
                                            required: true,
                                            minlength: 5
                                        },
                                        passnew2: {
                                            required: true,
                                            minlength: 5,
                                            equalTo: "#passnew1"
                                        }
                                    },
                                    messages: {
                                        passold: "Nhập vào mật khẩu cũ",
                                        passnew1: {
                                            required: "Vui lòng nhập mật khẩu mới",
                                            minlength: "Mật khẩu ít nhất 5 kí tự"
                                        },

                                        passnew2: {
                                            required: "Vui lòng nhập lại mật khẩu",
                                            minlength: "mật khẩu ít nhất 5 kí tự",
                                            equalTo: "Nhập lại mật khẩu không trùng khớp"
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
            </section>
        </main>
    </div>

</body>

</html>