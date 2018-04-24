function previewFile(file) {

    var selector = getFile(file);

    if (selector == '' || !selector) {
        return false;
    }    

    var fileId = selector.split('#')[1];

    if (fileId == '' || !fileId) {
        return false;
    }

    var preview = document.querySelector(selector);
    var file    = document.querySelector('input[type=file]#merchantrequest-'+ fileId).files[0];
    var reader  = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = preview.dataset.old;
    }
}

function getFile(file){

    var selector = 'img#';

    switch (file) { 
        case 'logo_image': 
            selector += file;
            break;
        case 'ktp_image': 
            selector += file;
            break;
        case 'npwp_image': 
            selector += file;
            break;    
        case 'siup_image': 
            selector += file;
            break;      
        case 'other_document': 
            selector += file;
            break;
        default:
            selector = '';
    }

    return selector;
}


$(document).ready(function(){
    $('body').append($('<script src="/theme/assets/global/plugins/jquery.min.js"></script>'));

    $('#merchantrequest-province').select2({
        // placeholder: 'Pilih Provinsi',
        allowClear: false,
        width: '100%'
    });

    $('#field-city').select2({
        // placeholder: 'Pilih Kota',
        allowClear: false,
        width: '100%'
    });

    var ownerStatus = $('#merchantrequest-ownership_status');
    var bussinesLocation = $('#merchantrequest-business_location');
    var bussinesType = $('#merchantrequest-business_type');
    // if (ownerStatus) {   
    if ((ownerStatus.length > 0)){
        ownerStatus.select2({
            placeholder: 'Pilih Status Kepemilikan',
            allowClear: false,
            width: '100%'
        });

        ownerStatus.css('width', '100%');
    }

    if (bussinesLocation.length > 0) {
        bussinesLocation.select2({
            placeholder: 'Pilih Lokasi Usaha',
            allowClear: false,
            width: '100%'
        });
        bussinesLocation.css('width', '100%');
    }
  
    if (bussinesType.length > 0) {
        bussinesType.select2({
            placeholder: 'Pilih Tipe Usaha',
            allowClear: false,
            width: '100%'
        });
        bussinesType.css('width', '100%');
    }
  
    $(function(){
        $('#approve').click(function(){
            $('.modal').modal('show')
                .find('.model-content')
                .load($(this).attr('value'));
        });
    });
});

    