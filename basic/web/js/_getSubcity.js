
function getCity(prov) {


    if (prov == "" || prov == "0") {
        defaultCity();
    } else {

        $.ajax({
            url: "/merchant-request/city-lists?id=" + prov,
            data: {},
            // cache: false,
            success: function (data) {
                dataCity(data);
                // console.log(data);
            }
        });
    }
}


function defaultCity() {
    $("#merchant-city").html("<option value>Pilih Kota/Kabupaten</option>");
}

function dataCity(data) {
    return (!data) ? defaultCity() : $("#merchant-city").html(data);
}