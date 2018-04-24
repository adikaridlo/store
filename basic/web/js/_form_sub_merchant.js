
function getParent(prov) 
{
    if (prov == "" || prov == "0") {
        defaultParent();
    } else {
        $.ajax({
            url: "/merchant/mid-lists?id=" + prov,
            data: {},
            success: function (data) {
                dataParent(data);
                if(data){
                    $.ajax({
                        url: "/merchant/opg-lists?id=" + data,
                        data: {},
                        success: function (opg) {
                            if(opg == 0){
                               dataOpg(data);

                            }else{
                                allowOpg(data);
                            }
                        }
                    });
                }
            }
        });
    }
}

function defaultParent() {
    $('#merchant-mid').val("");
}

function dataParent(data) {
    return (!data) ? defaultParent() : $('#merchant-mid').val(data);
}

function dataOpg(data){
    $.ajax({
    type: 'POST',
    url: "/merchant/mdr-aggregator-lists?id=" + data,
    dataType: 'JSON',
    success: function (result) {
        $("#merchant-emoney_bni").attr("readonly",true);
        $("#merchant-emoney_bni").val("0");

        $("#merchant-cc_bni").attr("readonly",true);
        $("#merchant-cc_bni").val("0");

        $("#merchant-dc_bni").attr("readonly",true);
        $("#merchant-dc_bni").val("0");

    }
});
    
}


function allowOpg(data)
{    
        $.ajax({
        type: 'POST',
        url: "/merchant/mdr-aggregator-lists?id=" + data,
        dataType: 'JSON',
        success: function (result) {

            $("#merchant-emoney_bni").val(result['emoney_aggregator']);
            $("#merchant-emoney_bni").attr("readonly",false);

            $("#merchant-cc_bni").val(result['cc_aggregator']);
            $("#merchant-cc_bni").attr("readonly",false);

            $("#merchant-dc_bni").val(result['dc_aggregator']);
            $("#merchant-dc_bni").attr("readonly",false);

        }
    });
    
}

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

$(document).ready(function(){
    $('body').append($('<script src="/theme/assets/global/plugins/jquery.min.js"></script>'));

    $('#merchant-province').select2({
        // placeholder: 'Pilih Provinsi',
        allowClear: false,
        width: '100%'
    });

    $('#merchant-city').select2({
        // placeholder: 'Pilih Kota',
        allowClear: false,
        width: '100%'
    });

    var bussinesType = $('#merchant-business_type');

    var parentName = $('#merchant-parent_name');

    if ((parentName.length > 0)) {
        parentName.select2({
            placeholder: 'Pilih Parent Name',
            allowClear: false,
            width: '100%'
        });
    }
  
    if (bussinesType.length > 0) {
        bussinesType.select2({
            placeholder: 'Pilih Tipe Usaha',
            allowClear: false,
            width: '100%'
        });
        bussinesType.css('width', '100%');
    }
});