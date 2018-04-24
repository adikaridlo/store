$(function() {
    $('input#merchantcallback-list_merchant').autocomplete({
        source: "/merchant-callback/data-merchant",
        select: function( event, ui ) {
            $("input#merchantcallback-list_merchant").val( ui.item.label );
            $("input#merchantcallback-merchant_id").val( ui.item.value );
            return false;
        }
    });
});