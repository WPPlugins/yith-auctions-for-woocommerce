
jQuery(document).ready(function($) {
    var timer;



    var result = parseInt($('#time').data('remaining-time'));

    //Datetimeformat in product auction
    var utcSeconds =  parseInt($('#time').data('finish'));
    var d = new Date(0); // The 0 there is the key, which sets the date to the epoch
    d.setUTCSeconds(utcSeconds);

    $("#dateend").text(d.toLocaleString());



    //Timeleft
    timer = setInterval(function() {
        timeBetweenDates(result);
        result--
    }, 1000);

    function timeBetweenDates(result) {
        if (result <= 0) {

            // Timer done

            clearInterval(timer);
            window.location.reload(true);

        } else {

            var seconds = Math.floor(result);
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);

            hours %= 24;
            minutes %= 60;
            seconds %= 60;

            $("#days").text(days);
            $("#hours").text(hours);
            $("#minutes").text(minutes);
            $("#seconds").text(seconds);
        }
    }

    //Button up or down bid
    var current = $('#time').data('current');
    $(".bid").click(function(e){
        e.preventDefault();
        var actual_bid = $('#_actual_bid').val();
        if($(this).hasClass("button_bid_add")){
            if(!actual_bid){
                actual_bid = current;
            }
            actual_bid++;
            $('#_actual_bid').val(actual_bid);
        } else {
            if(actual_bid){
                actual_bid--;
                if (actual_bid >= current){
                    $('#_actual_bid').val(actual_bid);
                }else{
                    $('#_actual_bid').val(current);
                }
            }
        }
    });

//Button bid
//
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

    $( '.yith_auction_datetime' ).each( function ( index ) {
        var datetime     = $( this ).text();
        datetime = datetime+'Z';
        /*  //datetime = datetime.replace(/-/g,'/');
         //console.log(datetime);
         //var current_date = new Date(Date.parse(datetime));*/
        var current_date = new Date( datetime );
        $( this ).text( current_date.toLocaleString() );
    } );

});

