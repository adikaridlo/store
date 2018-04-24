

    // $( document ).load(function() {
    //     // $($('.custom')).each(function (i, v) {
    //     //     if(i == 0){
    //     //         $('.btn-remove-0').remove();
    //     //     }
    //     // });
    // });

    $($('.btn-remove-0')).remove();

    $('.dynamicform_wrapper').on('limitReached', function(e, item) {
        $('.add-item').prop('disabled', true);
        // $('.add-item').hide('fast');
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $("input[data-email]").each(function(i){
            if ($(this).val() == '') {
                $('#pic-'+i+'-pic_email').prop('readonly', false);
                $('#pic-'+i+'-master_position option:selected').prop('selected', false);
            }
        });

        $('.phone-key').keyup(function(e)
                                {
          if (/\D/g.test(this.value))
          {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
          }
        });
    });

    $('.dynamicform_wrapper').on('afterDelete', function(e) {
        // $('.add-item').show('fast');
        $('.add-item').prop('disabled', false);
    });
   
