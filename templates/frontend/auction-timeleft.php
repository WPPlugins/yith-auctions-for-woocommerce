<?php
$auction_finish = ($datetime = yit_get_prop($product, '_yith_auction_to', true)) ? $datetime : NULL;
$date = strtotime('now');
$total = $auction_finish - $date;
?>
<div class="timer" id="timer_auction" data-remaining-time=" <?php echo $total ?>" data-finish="<?php echo $auction_finish?>">
    <span id="days"
          class="days_product_<?php echo $product->get_id() ?>"></span><?php _e('days', 'yith-auctions-for-woocommerce'); ?>
    <span id="hours"
          class="hours_product_<?php echo $product->get_id() ?>"></span><?php _e('hours', 'yith-auctions-for-woocommerce'); ?>
    <span id="minutes"
          class="minutes_product_<?php echo $product->get_id() ?>"></span><?php _e('minutes', 'yith-auctions-for-woocommerce'); ?>
    <span id="seconds"
          class="seconds_product_<?php echo $product->get_id() ?>"></span><?php _e('seconds', 'yith-auctions-for-woocommerce'); ?>
</div>
<div id="auction_end">
    <label
        for="_yith_auction_end"><?php _e('Auction end: ', 'yith-auctions-for-woocommerce') ?></label>
    <?php
    $auction_end_formatted = date(wc_date_format() . ' ' . wc_time_format(), $auction_finish);
    ?>
    <p id="dateend"><?php echo $auction_end_formatted ?></p>
</div>