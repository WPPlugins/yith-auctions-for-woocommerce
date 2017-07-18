<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

$instance = YITH_Auctions()->bids;
$auction_list = $instance->get_bids_auction($product->get_id());

?>
<?php
if (count($auction_list) == 0){
    ?>

    <p id="single-product-no-bid"><?php _e('There is no bid for this product','yith-auctions-for-woocommerce');?></p>

    <?php
}else {
    ?>
    <table id="datatable">
        <tr>
            <td class="toptable"><?php echo __('Username','yith-auctions-for-woocommerce'); ?></td>
            <td class="toptable"><?php echo __('Bid Amount','yith-auctions-for-woocommerce'); ?></td>
            <td class="toptable"><?php echo __('Datetime','yith-auctions-for-woocommerce'); ?></td>
        </tr>
        <?php
        $option = get_option('yith_wcact_settings_tab_auction_show_name');
        foreach ($auction_list as $object => $id) {
            $user = get_user_by('id', $id->user_id);
            $username = $user->data->user_nicename;
            if ('no' == $option) {
                $len = strlen($username);
                $start = 1;
                $end = 1;
                $username = substr($username, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($username, $len - $end, $end);
            }
            if ($object == 0) {
                $bid = $product->get_price();
                ?>
                <tr>
                    <td><?php echo $username ?></td>
                    <td><?php echo wc_price($bid) ?></td>
                    <td class="yith_auction_datetime"><?php echo $id->date ?></td>
                </tr>
                <?php
            } elseif ($id->bid < $product->get_price()) {
                $bid = $id->bid;
                ?>
                <tr>
                    <td><?php echo $username ?></td>
                    <td><?php echo wc_price($bid) ?></td>
                    <td class="yith_auction_datetime"><?php echo $id->date ?></td>
                </tr>
                <?php
            }
        }
        if ($product->is_start() && $auction_list) {
            ?>
            <tr>
                <td><?php _e('Start auction', 'yith-auctions-for-woocommerce') ?></td>
                <td><?php echo wc_price($product->get_start_price()) ?></td>
                <td></td>
            </tr>
            <?php
        }
        ?>

    </table>
    <?php
    if (count($auction_list) == 0) {
        ?>

        <p id="single-product-no-bid"><?php _e('There is no bid for this product', 'yith-auctions-for-woocommerce'); ?></p>

        <?php
    }
}