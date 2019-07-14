<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
 * this contains style & logic to display partner information
 * which is fetched as RSS-feed and cached automagically by WordPress
 * this remote fetch can be disabled with a filter
 */

?>
<style>
.itemDetail {
    list-style-type: none;
    background: #fff;
    width: 250px;
    min-height: 290px;
    border: 1px solid #ccc;
    float: left;
    padding: 15px;
    position: relative;
    margin: 0 10px 10px 0;
}
.itemTitle {
    margin-top:0px;
    margin-bottom:10px;
}
.itemImage {
    text-align: center;
}
.itemImage img {
    max-width: 95%;
    max-height: 150px;
}
.itemDescription {
    margin-bottom:30px;
}
.itemButtonRow {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width:100%;
}
.itemButton {
    float:right;
}
.itemButton a {
    text-decoration: none;
    color: #555;
}
.itemButton a:hover {
    text-decoration: none;
    color: #23282d;
}
</style>
<?php
    echo '<h2>'. __("These related services can improve your site's performance even more!",'async-javascript') . '</h2>';
?>
<div>
    <?php getasyncJSPartnerFeed(); ?>
</div>

<?php
function getasyncJSPartnerFeed() {
    $noFeedText=__( 'Have a look at <a href="http://optimizingmatters.com/">optimizingmatters.com</a> for tools that can help you speed up your site even more!', 'async-javascript');

    if (apply_filters('asyncJS_settingsscreen_remotehttp',true)) {
        $rss = fetch_feed( "http://feeds.feedburner.com/OptimizingMattersDownloads" );
        $maxitems = 0;

        if ( ! is_wp_error( $rss ) ) {
            $maxitems = $rss->get_item_quantity( 20 );
            $rss_items = $rss->get_items( 0, $maxitems );
        } ?>
        <ul>
            <?php
            if ( $maxitems == 0 ) {
                echo $noFeedText;
            } else {
                foreach ( $rss_items as $item ) :
                    $itemURL = esc_url( $item->get_permalink() ); ?>
                    <li class="itemDetail">
                        <h3 class="itemTitle"><a href="<?php echo $itemURL; ?>" target="_blank"><?php echo esc_html( $item->get_title() ); ?></a></h3>
                        <?php
                        if (($enclosure = $item->get_enclosure()) && (strpos($enclosure->get_type(),"image")!==false) ) {
                            $itemImgURL=esc_url($enclosure->get_link());
                            echo "<div class=\"itemImage\"><a href=\"".$itemURL."\" target=\"_blank\"><img src=\"".$itemImgURL."\"/></a></div>";
                        }
                        ?>
                        <div class="itemDescription"><?php echo wp_kses_post($item -> get_description() ); ?></div>
                        <div class="itemButtonRow"><div class="itemButton button-secondary"><a href="<?php echo $itemURL; ?>" target="_blank">More info</a></div></div>
                    </li>
                <?php endforeach; ?>
            <?php } ?>
        </ul>
        <?php
    } else {
        echo $noFeedText;
    }
}
