// handle search
$("#search").on("keyup", function () {
    var value = $(this).val();
    if (value != "") {
        search(value);
    } else {
        $("#table-body-search").html("");
        $("#search-list").css("display", "none");
    }
})

$("#search").on("focus", function () {
    $("#search").trigger("keyup");
})

$("#form-search").submit(function (e) {
    e.preventDefault();

    var value = $("#search").val();
    if (value != "") {
        search(value);
        $("#button-search").html(`<span class="fe fe-search"></span>`);
        $("#button-search").prop("disabled", false);
    } else {
        $("#table-body-search").html("");
        $("#button-search").html(`<span class="fe fe-search"></span>`);
        $("#button-search").prop("disabled", false);
        $("#search-list").css("display", "none");
    }
});

function search(value) {
    $.ajax({
        url: $("#form-search").attr("action"),
        method: "GET",
        data: {
            search: value
        },
        success: function (data) {
            let result = data.data;
            let rows = "";

            if (result.length > 0) {
                for (const key in result) {
                    rows += `
                    <tr>
                        <td>${result[key].code}</td>
                        <td>${result[key].name}</td>
                        <td>${result[key].total_qty + " " + result[key].unit}</td>
                        <td>${result[key].price} جنية</td>
                        <td>${result[key].discount}</td>
                        <td>${result[key].priceAfter} جنية</td>
                        <td><button data-id="${result[key].code}" data-name="${result[key].name}" data-price="${result[key].priceAfter}" class="btn btn-sm btn-success add-item">اضافة</button></td>
                `;

                    rows += `</tr>`;
                }
            } else {
                rows = `
                <tr><td class="text-center" colspan="6">لا يوجد منتج بهذا الكود / الاسم</td></tr>
                `;
            }

            $("#table-body-search").html(rows);
            $("#search-list").css("display", "block");
        }
    })
}

$(document).on('click', function (event) {
    if (!$("#search").is(event.target) && !$("#search-list").is(event.target) && $("#search-list").has(event
        .target)
        .length === 0) {
        $("#search-list").hide();
    }
});
