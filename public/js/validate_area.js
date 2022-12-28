$(document).ready(function () {

    const tp = $('#tinh')
    const qh = $('#quan')
    const px = $('#phuong')
    $.getJSON(`https://provinces.open-api.vn/api/?depth=3`, function (data) {
        console.log(data);
        $.each(data, function (index, elementType) {
            tp.append(`<option value="${elementType.name}">${elementType.name}</option>`);
        })
        if (tp.val() !== "") {
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
        console.log(error)
    });

    
})