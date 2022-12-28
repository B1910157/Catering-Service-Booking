<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    include __DIR__ . "/../bootstrap.php";
    require_once __DIR__ . "/../bootstrap.php";

    use CT466\Project\Menu;
    use CT466\Project\LoaiMon;
    use CT466\Project\MonAn;


    $loaimon = new LoaiMon($PDO);
    $menu = new Menu($PDO);
    $monan = new MonAn($PDO);
    $monans = $monan->all();
    $loaimons = $loaimon->all();


    $id_loaimon = isset($_REQUEST['id_loaimon']) ?
        filter_var($_REQUEST['id_loaimon'], FILTER_SANITIZE_NUMBER_INT) : -1;
    ?>

    <div class="container">
        <div class="row">
            <form action="test.php" enctype="multipart/form-data" method="post">
                <tr>
                    <td>Chon</td>
                    <td><input require type="text" name="tenmenu" placeholder="Nhập tên menu" value="<?php if (isset($_GET['tenmenu'])) {
                                                                                                                    echo $_GET['tenmenu'];
                                                                                                                } ?>"></td>
                </tr>


                <button type="submit">ADD MENU</button>
            </form>


        </div>

    </div>
</body>

</html>







$(document).ready(function () {

$('#frmQLCS').validate({
    rules: {
        id_loaitiec: {
            required: true,

        },
        soluongban: {
            required: true, minlength: 10

        },
        giodat: {
            required: true,

        },
        ngaydat: {
            required: true,

        },

        tinh: {
            required: true
        },
        quan: {
            required: true
        },
        phuong: {
            required: true
        },
        diachitiec: {
            required: true
        },
        
    },
    messages: {
        id_loaitiec: {
            required: "Bạn chưa chọn loại tiệc",

        },
        soluongban: {
            required: "Bạn chưa nhập số lượng bàn",
            minlengh: "Số lượng bàn phải lớn hơn 10"

        },
        giodat: {
            required: "Bạn chưa chọn giờ đặt tiệc",

        },
        ngaydat: {
            required: "Bạn chưa chọn ngày đặt tiệc",

        },



        tinh: {
            required: "Bạn chưa nhập Tỉnh hoặc Thành Phố",
        },
        quan: {
            required: "Bạn chưa nhập Quận hoặc Huyện",
        },
        phuong: {
            required: "Bạn chưa nhập Phường hoặc Xã",
        },
        diachitiec: {
            required: "Bạn chưa nhập địa chỉ",
        },


    },
    errorElement: "div",
    errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        if (element.prop("name") === "rdGioiTinh") {
            error.insertAfter(element.parent("div").siblings("label.gioitinh"));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).addClass("is-valid").removeClass("is-invalid");
    }
});

const tp = $('#tinh')
const qh = $('#quan')
const px = $('#phuong')

$.getJSON(`https://provinces.open-api.vn/api/?depth=3`, function (data) {
    console.log(data);
    $.each(data, function (index, elementType) {
        
        tp.append(`<option value="${elementType.name}">${elementType.name}</option>`);
        
    })


    if(tp.val() !== ""){
        var indexTP
        var arrQH
        var tenPX
        var indexQH
        var arrPX
        indexTP = data.indexOf(data.find((data) => data.name === tp.val()))
        console.log(indexTP)
        arrQH = data[indexTP].districts
        $.each(arrQH, function (index, elementQH) {
            qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
        })
        indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === qh.val()))

        arrPX = arrQH[indexQH].wards
        $.each(arrPX, function (index, elementPX) {
            px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
        })

        tp.on("change", function () {
          
            qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            var tenTP = $(this).val()
            indexTP = data.indexOf(data.find((data) => data.name === tenTP))
            console.log(indexTP)
            arrQH = data[indexTP].districts
            $.each(arrQH, function (index, elementQH) {
               
                qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
             

            })

        })
        qh.on("change", function () {
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            tenPX = $(this).val()
            indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
            
            arrPX = arrQH[indexQH].wards
            $.each(arrPX, function (index, elementPX) {
                px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
            })
        })
    } else {
        var indexTP
        var arrQH

        tp.on("change", function () {
            
            qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            var tenTP = $(this).val()
            indexTP = data.indexOf(data.find((data) => data.name === tenTP))
            console.log(indexTP)
            arrQH = data[indexTP].districts
            $.each(arrQH, function (index, elementQH) {
                var quanhuyen = elementQH.name
                qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
                

            })

        })
        qh.on("change", function () {
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            var tenPX = $(this).val()
            var indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
            console.log(indexQH)
            var arrPX = arrQH[indexQH].wards
            $.each(arrPX, function (index, elementPX) {
                px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
            })
        })

    }




    

}).fail(function (error) {

});
})
