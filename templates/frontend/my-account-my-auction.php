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
$user_id  = get_current_user_id();
$date     = date( "Y-m-d H:i:s" );

$auctions_by_user = $instance->get_auctions_by_user( $user_id );

?>
<table class="shop_table shop_table_responsive yith_wcact_my_auctions_table">
    <tr>
        <td class="toptable"><?php echo __( 'Image', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Product', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Your bid', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Current bid', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Status', 'yith-auctions-for-woocommerce' ); ?></td>

    </tr>
    <?php
    foreach ( $auctions_by_user as $valor ) {
        $product      = wc_get_product( $valor->auction_id );
        if (!$product )
            continue;

        $product_name = get_the_title( $valor->auction_id );
        $product_url  = get_the_permalink( $valor->auction_id );
        $a            = $product->get_image( 'thumbnail' );

        ?>
        <tr class="yith-wcact-auction-endpoint" data-product="<?php echo $product->get_id() ?>" >
            <td><?php echo $a ?></td>
            <td><a href="<?php echo $product_url; ?>"><?php echo $product_name ?></a></td>
            <td class="yith-wcact-my-bid-endpoint yith-wcact-my-auctions"><?php echo wc_price( $valor->max_bid ) ?></td>
            <td class="yith-wcact-current-bid-endpoint yith-wcact-my-auctions"><?php echo wc_price( $product->get_price() ) ?></td>
            <?php
            if ( $product->is_type('auction') && $product->is_closed() ) {
                $max_bid = $instance->get_max_bid($valor->auction_id);

                if ($max_bid->user_id == $user_id && !$product->is_paid()) {
                    $url  = add_query_arg( array( 'yith-wcact-pay-won-auction' => $product->get_id() ), wc_get_checkout_url() );
                    ?>
                    <td class="yith-wcact-auctions-status yith-wcact-my-auctions">
                        <span><?php echo __('You won this auction','yith-auctions-for-woocommerce')?></span>
                        <a  href="<?php echo $url ?>" class="auction_add_to_cart_button button alt"
                            id="yith-wcact-auction-won-auction">
                            <?php echo sprintf(__('Pay now', 'yith-auctions-for-woocommerce')); ?>
                        </a>
                    </td>
                    <?php
                }else {
                    ?>
                    <td class="yith-wcact-auctions-status yith-wcact-my-auctions"><?php echo __('Closed', 'yith-auctions-for-woocommerce'); ?></td>

                    <?php
                }
            } else {
                ?>
                <td class="yith-wcact-auctions-status yith-wcact-my-auctions"><?php echo __( 'Started', 'yith-auctions-for-woocommerce' ); ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>

</table><?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

$instance = YITH_Auctions()->bids;
$user_id  = get_current_user_id();
$date     = date( "Y-m-d H:i:s" );

$auctions_by_user = $instance->get_auctions_by_user( $user_id );

?>
<table class="shop_table shop_table_responsive">
    <tr>
        <td class="toptable"><?php echo __( 'Image', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Product', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Your bid', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Current bid', 'yith-auctions-for-woocommerce' ); ?></td>
        <td class="toptable"><?php echo __( 'Status', 'yith-auctions-for-woocommerce' ); ?></td>

    </tr>
    <?php
    foreach ( $auctions_by_user as $valor ) {
        $product      = wc_get_product( $valor->auction_id );
        if ( !$product )
            continue;

        $product_name = get_the_title( $valor->auction_id );
        $product_url  = get_the_permalink( $valor->auction_id );
        $a            = $product->get_image( 'thumbnail' );

        ?>
        <tr>
            <td><?php echo $a ?></td>
            <td><a href="<?php echo $product_url; ?>"><?php echo $product_name ?></a></td>
            <td><?php echo wc_price( $valor->max_bid ) ?></td>
            <td><?php echo wc_price( $product->get_price() ) ?></td>
            <?php
            if ( $product->is_type('auction') && $product->is_closed() ) {
                $max_bid = $instance->get_max_bid($valor->auction_id);

                if ($max_bid->user_id == $user_id && !$product->is_paid()) {
                    $url  = add_query_arg( array( 'yith-wcact-pay-won-auction' => $product->id ), wc_get_checkout_url() );
                    ?>
                    <td>
                        <span><?php echo __('You won this auction','yith-auctions-for-woocommerce')?></span>
                        <a  href="<?php echo $url ?>" class="auction_add_to_cart_button button alt"
                            id="yith-wcact-auction-won-auction">
                            <?php echo sprintf(__('Pay now', 'yith-auctions-for-woocommerce')); ?>
                        </a>
                    </td>
                    <?php
                }else {
                    ?>
                    <td><?php echo __('Closed', 'yith-auctions-for-woocommerce'); ?></td>

                    <?php
                }
            } else {
                ?>
                <td><?php echo __( 'Started', 'yith-auctions-for-woocommerce' ); ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>

</table>