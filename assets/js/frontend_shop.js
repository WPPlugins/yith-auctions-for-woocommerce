jQuery(document).ready(function($) {
    $('.date_auction').each(function(index){

        var timer;
        var product = parseInt($(this).data('yith-product'));

        var utcSeconds =  parseInt($(this).text());
        var b = new Date();
        c = b.getTime()/ 1000;
        var date_remaining = utcSeconds - c;

        //Pass Utc seconds to localTime
        var d = new Date(0); // The 0 there is the key, which sets the date to the epoch
        d.setUTCSeconds(utcSeconds);
        $(this).text(d.toLocaleString());

        timer = setInterval(function() {
            timeBetweenDates(date_remaining,product);
            date_remaining--;
        }, 1000);
    });

    function timeBetweenDates(result,product) {
        if (result <= 0) {

            clearInterval(timer);
            //window.location.reload(true);

        } else {

            var seconds = Math.floor(result);
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);

            hours %= 24;
            minutes %= 60;
            seconds %= 60;

            $( 'span[class="days_product_'+product+'"]' ).text(days);
            $( 'span[class="hours_product_'+product+'"]' ).text(hours);
            $( 'span[class="minutes_product_'+product+'"]' ).text(minutes);
            $( 'span[class="seconds_product_'+product+'"]' ).text(seconds);
        }
    }


    $( document ).on( 'click', '.auction_bid', function( e ) {
        //var target = $( e.target ); // this code get the target of the click -->  $('.bid')
        var post_data = {
            'bid': $('#_actual_bid').val(),
            'product' : $('#time').data('product'),
            //security: object.search_post_nonce,
            action: 'yith_wcact_add_bid'
        };

        $.ajax({
            type    : "POST",
            data    : post_data,
            url     : object.ajaxurl,
            success : function ( response ) {
                //console.log(response.url);
                window.location = response.url;

                //window.location.reload(true);
                // On Success
            },
            complete: function () {
            }
        });
    } );

    //Disable enter in input
    $("#_actual_bid").keydown(function( event ) {
        if ( event.which == 13 ) {
            event.preventDefault();
        }
    });

});
