<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$site_url = trailingslashit( get_site_url() );
$aj_gtmetrix_username = get_option( 'aj_gtmetrix_username', '' );
$aj_gtmetrix_api_key = get_option( 'aj_gtmetrix_api_key', '' );
$aj_gtmetrix_server = get_option( 'aj_gtmetrix_server', '' );
$aj_enabled = ( get_option( 'aj_enabled', 0 ) == 1 ) ? 'Enabled' : 'Disabled';
$aj_method = ( get_option( 'aj_method', 'async' ) == 'async' ) ? 'Async' : 'Defer';
$aj_jquery = get_option( 'aj_jquery', 'async' );
$aj_jquery = ( $aj_jquery == 'same ' ) ? get_option( 'aj_method', 'async' ) : $aj_jquery;
$aj_jquery = ( $aj_jquery == 'async' ) ? 'Async' : (( $aj_jquery == 'defer' ) ? 'Defer' : 'Excluded');
$aj_exclusions = get_option( 'aj_exclusions', '' );
$aj_plugin_exclusions = get_option( 'aj_plugin_exclusions', array() );
$aj_theme_exclusions = get_option( 'aj_theme_exclusions', array() );
$aj_autoptimize_enabled = ( get_option( 'aj_autoptimize_enabled', 0 ) == 1 ) ? 'Enabled' : 'Disabled';
$aj_autoptimize_method = ( get_option( 'aj_autoptimize_method', 'async' ) == 'async' ) ? 'Async' : 'Defer';
?>
<div class="wrap aj">
    <h3><?php echo AJ_TITLE.__(' Status','async-javascript'); ?></h3>
    <ul>
        <li><strong><?php _e(' Status','async-javascript'); ?></strong> <?php echo $aj_enabled; ?></li>
        <?php
        if ( $aj_enabled == 'Enabled' ) {
            ?>
            <li><strong><?php _e('Method:','async-javascript'); ?></strong> <?php echo $aj_method; ?></li>
            <li><strong>jQuery:</strong> <?php echo $aj_jquery; ?></li>
            <li><strong><?php _e('Exclusions:','async-javascript'); ?></strong> <?php echo $aj_exclusions; ?></li>
            <li><strong><?php _e('Plugin Exclusions:','async-javascript'); ?></strong> <?php echo ( is_array( $aj_plugin_exclusions ) ) ? implode( ',', $aj_plugin_exclusions) : $aj_plugin_exclusions; ?></li>
            <li><strong><?php _e('Theme Exclusions:','async-javascript'); ?></strong> <?php echo ( is_array( $aj_theme_exclusions ) ) ? implode( ',', $aj_theme_exclusions) : $aj_theme_exclusions; ?></li>
            <?php
            if ( is_plugin_active( 'autoptimize/autoptimize.php' ) ) {
                ?>
                <li><strong><?php _e('Autoptimize Status:','async-javascript'); ?></strong> <?php echo $aj_autoptimize_enabled; ?></li>
                <?php
                if ( $aj_autoptimize_enabled == 'Enabled' ) {
                    ?>
                    <li><strong><?php _e('Autoptimize Method:','async-javascript'); ?></strong> <?php echo $aj_autoptimize_method; ?></li>
                    <?php
                }
            } else {
                ?>
                <li><?php _e('Autoptimize not installed or activated.','async-javascript'); ?></li>
                <?php
            }
        }
        ?>
    </ul>
    <hr />
    <h3><?php _e('Latest GTmetrix Results','async-javascript'); ?></h3>
    <?php
    $aj_gtmetrix_results = get_option( 'aj_gtmetrix_results', array() );
    if ( isset( $aj_gtmetrix_results['latest'] ) ) {
        $latest = $aj_gtmetrix_results['latest'];
        $screenshot = $latest['screenshot'];
        $pagespeed = $latest['results']['pagespeed_score'];
        $yslow = $latest['results']['yslow_score'];
        $pr = round( 255 * ( 1 - ( $pagespeed / 100 ) ), 0 );
        $yr = round( 255 * ( 1 - ( $yslow / 100 ) ), 0 );
        $pg = round( 255 * ( $pagespeed / 100 ), 0 );
        $yg = round( 255 * ( $yslow / 100 ), 0 );
        $pagespeed_style = ' style="color: rgb(' . $pr . ',' . $pg . ',0 )"';
        $yslow_style = ' style="color: rgb(' . $yr . ',' . $yg . ',0 )"';
        $flt = number_format( ( float )$latest['results']['fully_loaded_time'] / 1000, 2, '.', '' );
        $tps = number_format( ( float )$latest['results']['page_bytes'] / 1024, 0, '.', '' );
        $tps = ( $tps > 1024 ) ? number_format( ( float )$tps / 1024, 2, '.', '' ) . 'MB' : $tps . 'KB';
        $requests = $latest['results']['page_elements'];
        $report = $latest['results']['report_url'];
        $report_url = '<a href="' . $report . '" target="_blank">' . $report . '</a>';
        ?>
        <table id="aj_latest_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
            <tr>
                <td scope="row" align="center"><img src="data:image/jpeg;base64,<?php echo $screenshot; ?>" class="aj_latest_screenshot aj_gtmetrix_screenshot_dashboard">
                <td scope="row" align="center">
                    <h3><?php _e('PageSpeed Score','async-javascript'); ?></h3>
                    <span class="aj_latest_pagespeed aj_gtmetrix_result"<?php echo $pagespeed_style; ?>><?php echo $pagespeed; ?>%</span>
                </td>
                <td scope="row" align="center">
                    <h3><?php _e('YSlow Score','async-javascript'); ?></h3>
                    <span class="aj_latest_yslow aj_gtmetrix_result"<?php echo $yslow_style; ?>><?php echo $yslow; ?>%</span>
                </td>
            </tr>
            <tr>
                <td scope="row" align="center">
                    <h3><?php _e('Fully Loaded Time','async-javascript'); ?></h3>
                    <span class="aj_latest_flt aj_gtmetrix_result"><?php echo $flt; ?>s</span>
                </td>
                <td scope="row" align="center">
                    <h3><?php _e('Total Page Size','async-javascript'); ?></h3>
                    <span class="aj_latest_tps aj_gtmetrix_result"><?php echo $tps; ?></span>
                </td>
                <td scope="row" align="center">
                    <h3><?php _e('Requests','async-javascript'); ?></h3>
                    <span class="aj_latest_requests aj_gtmetrix_result"><?php echo $requests; ?></span>
                </td>
            </tr>
            <tr><td scope="row" align="left" colspan="6"><?php _e('See full report: ','async-javascript'); ?> <span class="aj_latest_report"><?php echo $report_url; ?></span></td></tr>
        </table>
        <?php
    }
    ?>
    <p><?php _e('Please click on the Settings button below to generate a new GTmetrix Report.','async-javascript'); ?></p>
    <p><button data-id="aj_goto_settings" class="aj_steps_button button"><?php _e('Settings','async-javascript'); ?></button></p>
</div>
<?php
