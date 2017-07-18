jQuery(document).ready(function($) {
    $('select#product-type').on('change',function(){
        var value = $(this).val();
        if (value == 'auction'){
            $('#_regular_price').val('');
            $('#_sale_price').val('');
        }
    });
});
