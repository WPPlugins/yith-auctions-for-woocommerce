<?php
/**
 * Auction product add to cart
 *
 * @author 		Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

$product = apply_filters('yith_wcact_get_auction_product',$product);
?>

<?php
// Availability
$availability      = $product->get_availability();
$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
    <?php
        if(apply_filters('yith_wcact_before_add_to_cart',true,$product)) {

            if ($product->is_start() && !$product->is_closed()) {

                $auction_finish = ($datetime = yit_get_prop($product, '_yith_auction_to', true)) ? $datetime : NULL;
                $date = strtotime('now');
                ?>
                <form class="cart" method="post" enctype='multipart/form-data'>

                    <?php
                    $bid_increment = 1;
                    $total = $auction_finish - $date;

                    do_action('yith_wcact_in_to_form_add_to_cart',$product);
                    
                    ?>

                    <div id="time" class="timetito" data-remaining-time=" <?php echo $total ?>" data-bid-increment="<?php echo $bid_increment ?>" data-product="<?php echo $product->get_id()?>"data-current="<?php echo $product->get_price()?>"data-finish="<?php echo $auction_finish?>">
                        <label for="yith_time_left"><?php _e('Time left:', 'yith-auctions-for-woocommerce') ?></label>
                        <div id="yith-wcact-auction-timeleft">
                            <?php do_action('yith_wcact_auction_before_set_bid',$product) ?>
                        </div>
                        <div name="form_bid" id="yith-wcact-form-bid">
                            <label
                                for="_yith_your_bid"><?php _e('Your bid:', 'yith-auctions-for-woocommerce') ?></label>
                            <br/>
                            <?php
                            if ('yes' == get_option('yith_wcact_settings_tab_auction_show_button_plus_minus')) {
                                ?>
                                <input type="button" class="bid button_bid_subtr" value="-">
                                <?php
                            }
                            ?>

                            <input type="number" id="_actual_bid" name="_section" value="" size="4" min="0">
                            <?php
                            if ('yes' == get_option('yith_wcact_settings_tab_auction_show_button_plus_minus')) {
                                ?>
                                <input type="button" class="bid button_bid_add" value="+">

                                <?php
                            }
                                
                                do_action('yith_wcact_after_form_bid',$product);
                            ?>
                            
                        </div>
                    </div>
                    <?php do_action('yith_wcact_before_add_button_bid',$product) ?>
                    <div id="yith-wcact-aution-buttons">
                        <button type="button"
                                class="auction_bid button alt"><?php _e('Bid', 'yith-auctions-for-woocommerce'); ?></button>
                        
                        <?php do_action('yith_wcact_after_add_button_bid',$product) ?>
                        
                    </div>
                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </form>
                <?php
            } elseif (!$product->is_closed() || !$product->is_start()) {

                $for_auction = ($datetime = yit_get_prop($product, '_yith_auction_for', true)) ? $datetime : NULL;
                $auction_start = $for_auction;
                $date = strtotime('now');
                $total = $auction_start - $date;
                ?>
                <h3><?php _e('The auction is not available', 'yith-auctions-for-woocommerce') ?></h3>
                <div id="time" data-remaining-time=" <?php echo $total ?>">
                    <label
                        for="yith_time_left"><?php _e('Time left to start auction:', 'yith-auctions-for-woocommerce') ?></label>
                    <div class="timer" id="timer_auction">
                        <span id="days"
                              class="days_product_<?php echo $product->get_id() ?>"></span><?php _e('days', 'yith-auctions-for-woocommerce'); ?>
                        <span id="hours"
                              class="hours_product_<?php echo $product->get_id() ?>"></span><?php _e('hours', 'yith-auctions-for-woocommerce'); ?>
                        <span id="minutes"
                              class="minutes_product_<?php echo $product->get_id() ?>"></span><?php _e('minutes', 'yith-auctions-for-woocommerce'); ?>
                        <span id="seconds"
                              class="seconds_product_<?php echo $product->get_id() ?>"></span><?php _e('seconds', 'yith-auctions-for-woocommerce'); ?>
                    </div>
                </div>
                <?php
                //The auction end
            } else {
                
                do_action('yith_wcact_auction_end',$product);

            }
        }
    ?>
    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif;

