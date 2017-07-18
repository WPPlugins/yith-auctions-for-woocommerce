<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( !defined( 'YITH_WCACT_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

$post_id = $post->ID;
$auction_product = wc_get_product($post_id);

do_action('yith_before_auction_tab',$post_id);

$from_auction = ( $datetime = yit_get_prop($auction_product,'_yith_auction_for',true) ) ? absint( $datetime ) : '';
$from_auction = $from_auction ? get_date_from_gmt( date( 'Y-m-d H:i:s', $from_auction ) ) : '';
$to_auction   = ( $datetime = yit_get_prop($auction_product,'_yith_auction_to',true) ) ? absint( $datetime ) : '';
$to_auction   = $to_auction ? get_date_from_gmt( date( 'Y-m-d H:i:s', $to_auction ) ) : '';

echo '<p class="form-field wc_auction_dates">
                        <label for="wc_auction_dates_from">' . __( 'Auction Dates', 'yith-auctions-for-woocommerce' ) . '</label>
                        <input type="text" name="_yith_auction_for" class="wc_auction_datepicker" id="_yith_auction_for" value="' . $from_auction . '" placeholder="' . __( 'From', 'yith-auctions-for-woocommerce' ) . '"
                        pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01]) (0[0-9]|1[0-9]|2[0-3]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])"
						title="YYYY-MM-DD hh:mm:ss" data-related-to="#_yith_auction_to">
                        <input type="text" name="_yith_auction_to" class="wc_auction_datepicker" id="_yith_auction_to" value="' . $to_auction . '" placeholder="' . __( 'To', 'yith-auctions-for-woocommerce' ) . '"
                        pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01]) (0[0-9]|1[0-9]|2[0-3]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])"
						title="YYYY-MM-DD hh:mm:ss">


		</p>';

do_action('yith_after_auction_tab',$post_id);