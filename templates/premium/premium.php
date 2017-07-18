<style>
    .section{
        margin-left: -20px;
        margin-right: -20px;
        font-family: "Raleway",san-serif;
    }
    .section h1{
        text-align: center;
        text-transform: uppercase;
        color: #808a97;
        font-size: 35px;
        font-weight: 700;
        line-height: normal;
        display: inline-block;
        width: 100%;
        margin: 50px 0 0;
    }
    .section ul{
        list-style-type: disc;
        padding-left: 15px;
    }
    .section:nth-child(even){
        background-color: #fff;
        background-repeat: no-repeat;
        background-position: 85% 75%
    }
    .section:nth-child(odd){
        background-color: #f1f1f1;
        background-repeat: no-repeat;
        background-position: 15% 100%;
    }
    .section:nth-child(2){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/01-bg.png);
    }
    .section:nth-child(3){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/02-bg.png);
    }
    .section:nth-child(4){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/03-bg.png);
    }
    .section:nth-child(5){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/04-bg.png);
    }
    .section:nth-child(6){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/05-bg.png);
    }
    .section:nth-child(7){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/06-bg.png);
    }
    .section:nth-child(8){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/07-bg.png);
    }
    .section:nth-child(9){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/08-bg.png);
    }
    .section:nth-child(10){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/09-bg.png);
    }
    .section:nth-child(11){
        background-image: url(<?php echo YITH_WCACT_ASSETS_URL ?>images/10-bg.png);
    }
    .section .section-title img{
        display: table-cell;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }
    .section h2,
    .section h3 {
        display: inline-block;
        vertical-align: middle;
        padding: 0;
        font-size: 24px;
        font-weight: 700;
        color: #808a97;
        text-transform: uppercase;
    }

    .section .section-title h2{
        display: table-cell;
        vertical-align: middle;
        line-height: 25px;
    }

    .section-title{
        display: table;
    }

    .section h3 {
        font-size: 14px;
        line-height: 28px;
        margin-bottom: 0;
        display: block;
    }

    .section p{
        font-size: 13px;
        margin: 25px 0;
    }
    .section ul li{
        margin-bottom: 4px;
    }
    .landing-container{
        max-width: 750px;
        margin-left: auto;
        margin-right: auto;
        padding: 50px 0 30px;
    }
    .landing-container:after{
        display: block;
        clear: both;
        content: '';
    }
    .landing-container .col-1,
    .landing-container .col-2{
        float: left;
        box-sizing: border-box;
        padding: 0 15px;
    }
    .landing-container .col-1 img{
        width: 100%;
    }
    .landing-container .col-1{
        width: 55%;
    }
    .landing-container .col-2{
        width: 45%;
    }
    .premium-cta{
        background-color: #808a97;
        color: #fff;
        border-radius: 6px;
        padding: 20px 15px;
    }
    .premium-cta:after{
        content: '';
        display: block;
        clear: both;
    }
    .premium-cta p{
        margin: 7px 0;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        width: 60%;
    }
    .premium-cta a.button{
        border-radius: 6px;
        height: 60px;
        float: right;
        background: url(<?php echo YITH_WCACT_ASSETS_URL?>images/upgrade.png) #ff643f no-repeat 13px 13px;
        border-color: #ff643f;
        box-shadow: none;
        outline: none;
        color: #fff;
        position: relative;
        padding: 9px 50px 9px 70px;
    }
    .premium-cta a.button:hover,
    .premium-cta a.button:active,
    .premium-cta a.button:focus{
        color: #fff;
        background: url(<?php echo YITH_WCACT_ASSETS_URL?>images/upgrade.png) #971d00 no-repeat 13px 13px;
        border-color: #971d00;
        box-shadow: none;
        outline: none;
    }
    .premium-cta a.button:focus{
        top: 1px;
    }
    .premium-cta a.button span{
        line-height: 13px;
    }
    .premium-cta a.button .highlight{
        display: block;
        font-size: 20px;
        font-weight: 700;
        line-height: 20px;
    }
    .premium-cta .highlight{
        text-transform: uppercase;
        background: none;
        font-weight: 800;
        color: #fff;
    }

    @media (max-width: 768px) {
        .section{margin: 0}
        .premium-cta p{
            width: 100%;
        }
        .premium-cta{
            text-align: center;
        }
        .premium-cta a.button{
            float: none;
        }
    }

    @media (max-width: 480px){
        .wrap{
            margin-right: 0;
        }
        .section{
            margin: 0;
        }
        .landing-container .col-1,
        .landing-container .col-2{
            width: 100%;
            padding: 0 15px;
        }
        .section-odd .col-1 {
            float: left;
            margin-right: -100%;
        }
        .section-odd .col-2 {
            float: right;
            margin-top: 65%;
        }
    }

    @media (max-width: 320px){
        .premium-cta a.button{
            padding: 9px 20px 9px 70px;
        }

        .section .section-title img{
            display: none;
        }
    }
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH Auctions for WooCommerce%2$s to benefit from all features!','yith-auctions-for-woocommerce'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-auctions-for-woocommerce');?></span>
                    <span><?php _e('to the premium version','yith-auctions-for-woocommerce');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <h1><?php _e('Premium Features','yith-auctions-for-woocommerce');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/01.png" alt="" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Starting price','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Auctions always have a starting price under which the buyer can’t make the first bid. %3$s %1$sNow you can do it for your auction products too:%2$s the lower the starting price is, the more your users will make their bids.', 'yith-auctions-for-woocommerce'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Reserve price','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('An auction product can be a big opportunity for buyers and a loss for sellers. This is why we give you the possibility to %1$sset a reserve price%2$s: when the auction ends and the higher bid is lower than the amount you specified, the product won’t be sold.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/02.png" alt="" />
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/03.png" alt="" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/03-icon.png" alt="icon 03"/>
                    <h2><?php _e('Automatic bid up','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('To improve the %1$suser experience%2$s during the auction, the system will automatically manage the bid up and will check it doesn’t exceed the maximum amount the user intended to spend.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php echo sprintf(__('This behavior gives %1$stwo benefits%2$s: it prevents the users to miss the product if they can’t manually raise and the auction becomes more fluid.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('Direct selling','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('There are users ready to spend the required amount and complete the purchase right away even if the auction is still open. ', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php echo sprintf(__('%1$sDo you want to miss this chance?%2$s We have thought about this too. Set your product price and if the user decides to pay the required amount, the product will be sold and the auction will end.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/04.png" alt="" />
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/05.png" alt="" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/05-icon.png" alt="icon 05"/>
                    <h2><?php _e('Shop page','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Manage the view of the auction products on your site %1$sshop page%2$s in an easy way. Choose to show them all or only those for which the auction is open or ended.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('Notification email','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('The specific %1$snotification emails%2$s will allow your users to be %1$sup-to-date about the auction%2$s. %3$s You can send them when the auction is about to expire or when an overbid has been made.', 'yith-auctions-for-woocommerce'), '<b>', '</b>','<br>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/06.png" alt="" />
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/07.png" alt="" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/07-icon.png" alt="icon 07"/>
                    <h2><?php _e('Custom badge','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Each auction product can be highlighted thanks to a custom badge to %1$scatch the user’s eye%2$s among all the products of your shop.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php _e('If the default icon doesn’t fit your needs, you are free to use a custom one that adjusts to your theme. ', 'yith-auctions-for-woocommerce');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/08-icon.png" alt="icon 08" />
                    <h2><?php _e('Widget','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('The latest auctions are shown within your site %1$ssidebars%2$s. %3$sAn additional way to inform your users about the possibility to purchase specific products through an auction. %1$sToo advantageous to miss it.%2$s', 'yith-auctions-for-woocommerce'), '<b>', '</b>','<br>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/08.png" alt="" />
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/09.jpg" alt="" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/09-icon.png" alt="icon 09"/>
                    <h2><?php _e('Extend the expiration date','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('You can extend the %1$sexpiration date%2$s for an auction if a customer bids a few minutes before it closes.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php echo sprintf(__('This is the only way someone who’s really interested can place their %1$slast minute%2$s bids to get what they are after.', 'yith-auctions-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/10-icon.png" />
                    <h2><?php _e('Auction product list','yith-auctions-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Through the specific shortcode, you can show the complete list of the auction products of your shop on any page of the site. The perfect chance to build a tailor-made page for all the users interested in purchasing an auction product. ', 'yith-auctions-for-woocommerce'), '<b>', '</b>','<br>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCACT_ASSETS_URL ?>images/10.png" alt="" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH Auctions for WooCommerce%2$s to benefit from all features!','yith-auctions-for-woocommerce'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-auctions-for-woocommerce');?></span>
                    <span><?php _e('to the premium version','yith-auctions-for-woocommerce');?></span>
                </a>
            </div>
        </div>
    </div>
</div>