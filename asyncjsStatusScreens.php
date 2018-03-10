<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$site_url = trailingslashit( get_site_url() );
$aj_gtmetrix_username = get_option( 'aj_gtmetrix_username', '' );
$aj_gtmetrix_api_key = get_option( 'aj_gtmetrix_api_key', '' );
$aj_gtmetrix_server = get_option( 'aj_gtmetrix_server', '' );
if ( $aj_gtmetrix_username != '' && $aj_gtmetrix_api_key != '' ) {
    $test = new Services_WTF_Test();
    $test->api_username( $aj_gtmetrix_username );
    $test->api_password( $aj_gtmetrix_api_key );
    $test->user_agent( AJ_UA );
    $status = $test->status();
    $credits = $status['api_credits'];
} else {
    $credits = 'N/A';
}
$aj_enabled = ( get_option( 'aj_enabled', 0 ) == 1 ) ? 'Enabled' : 'Disabled';
$aj_method = ( get_option( 'aj_method', 'async' ) == 'async' ) ? 'Async' : 'Defer';
$aj_jquery = get_option( 'aj_jquery', 'async' );
$aj_jquery = ( $aj_jquery == 'same ' ) ? get_option( 'aj_method', 'async' ) : $aj_jquery;
$aj_jquery = ( $aj_jquery == 'async' ) ? 'Async' : ( $aj_jquery == 'defer' ) ? 'Defer' : 'Excluded';
$aj_async = get_option( 'aj_async', '' );
$aj_defer = get_option( 'aj_defer', '' );
$aj_exclusions = get_option( 'aj_exclusions', '' );
$aj_plugin_exclusions = ( is_array( get_option( 'aj_plugin_exclusions', array() ) ) && !is_null( get_option( 'aj_plugin_exclusions', array() ) ) ? get_option( 'aj_plugin_exclusions', array() ) : explode( ',', get_option( 'aj_plugin_exclusions', '' ) ) );
$aj_theme_exclusions = ( is_array( get_option( 'aj_theme_exclusions', array() ) ) && !is_null( get_option( 'aj_theme_exclusions', array() ) ) ? get_option( 'aj_theme_exclusions', array() ) : explode( ',', get_option( 'aj_theme_exclusions', '' ) ) );
$aj_autoptimize_enabled = ( get_option( 'aj_autoptimize_enabled', 0 ) == 1 ) ? 'Enabled' : 'Disabled';
$aj_autoptimize_method = ( get_option( 'aj_autoptimize_method', 'async' ) == 'async' ) ? 'Async' : 'Defer';
?>
<table class="form-table" width="100%" cellpadding="10">
    <tr>
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/finger_point_out_punch_hole_400_clr_17860.png" title="Most Recent GTmetrix Results" alt="Most Recent GTmetrix Results"  class="aj_step_img"></td>
        <td scope="row" align="left">
            <h3><?php echo AJ_TITLE; ?></h3>
            <ul>
                <li><strong>Status:</strong> <?php echo $aj_enabled; ?></li>
                <?php
                if ( $aj_enabled == 'Enabled' ) {
                    ?>
                    <li><strong>Method:</strong> <?php echo $aj_method; ?></li>
                    <li><strong>jQuery:</strong> <?php echo $aj_jquery; ?></li>
                    <li><strong>Async Scripts:</strong> <?php echo $aj_async; ?></li>
                    <li><strong>Defer Scripts:</strong> <?php echo $aj_defer; ?></li>
                    <li><strong>Exclusions:</strong>
                        <ul>
                            <li><strong>Scripts:</strong> <?php echo $aj_exclusions; ?></li>
                            <li><strong>Plugins:</strong> <?php echo implode( ',', $aj_plugin_exclusions ); ?></li>
                            <li><strong>Themes:</strong> <?php echo implode( ',', $aj_theme_exclusions ); ?></li>
                        </ul>
                    </li>
                    <?php
                    if ( is_plugin_active( 'autoptimize/autoptimize.php' ) ) {
                        ?>
                        <li><strong>Autoptimize Status:</strong> <?php echo $aj_autoptimize_enabled; ?></li>
                        <?php
                        if ( $aj_autoptimize_enabled == 'Enabled' ) {
                            ?>
                            <li><strong>Autoptimize Method:</strong> <?php echo $aj_autoptimize_method; ?></li>
                            <?php
                        }
                    } else {
                        ?>
                        <li>Autoptimize not installed or activated.</li>
                        <?php
                    }
                }
                ?>
            </ul>
            <hr />
            <h3>Latest GTmetrix Results</h3>
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
                <p id="aj_latest_please_wait"><img src="<?php echo AJ_PLUGIN_URL; ?>images/loading.gif" title="Please Wait" alt="Please Wait" class="aj_step_img"></p>
                <table id="aj_latest_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                    <tr>
                        <td scope="row" align="center"><img src="data:image/jpeg;base64,<?php echo $screenshot; ?>" class="aj_latest_screenshot aj_gtmetrix_screenshot">
                        <td scope="row" align="center">
                            <h3>PageSpeed Score</h3>
                            <span class="aj_latest_pagespeed aj_gtmetrix_result"<?php echo $pagespeed_style; ?>><?php echo $pagespeed; ?>%</span>
                        </td>
                        <td scope="row" align="center">
                            <h3>YSlow Score</h3>
                            <span class="aj_latest_yslow aj_gtmetrix_result"<?php echo $yslow_style; ?>><?php echo $yslow; ?>%</span>
                        </td>
                        <td scope="row" align="center">
                            <h3>Fully Loaded Time</h3>
                            <span class="aj_latest_flt aj_gtmetrix_result"><?php echo $flt; ?>s</span>
                        </td>
                        <td scope="row" align="center">
                            <h3>Total Page Size</h3>
                            <span class="aj_latest_tps aj_gtmetrix_result"><?php echo $tps; ?></span>
                        </td>
                        <td scope="row" align="center">
                            <h3>Requests</h3>
                            <span class="aj_latest_requests aj_gtmetrix_result"><?php echo $requests; ?></span>
                        </td>
                    </tr>
                    <tr><td scope="row" align="left" colspan="6">See full report: <span class="aj_latest_report"><?php echo $report_url; ?></span></td></tr>
                </table>
                <hr />
                <?php
            } else {
                ?>
                <table id="aj_latest_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10" style="display: none;">
                    <tr>
                        <td scope="row" align="center"><img src="" class="aj_latest_screenshot aj_gtmetrix_screenshot">
                        <td scope="row" align="center">
                            <h3>PageSpeed Score</h3>
                            <span class="aj_latest_pagespeed aj_gtmetrix_result"></span>
                        </td>
                        <td scope="row" align="center">
                            <h3>YSlow Score</h3>
                            <span class="aj_latest_yslow aj_gtmetrix_result"></span>
                        </td>
                        <td scope="row" align="center">
                            <h3>Fully Loaded Time</h3>
                            <span class="aj_latest_flt aj_gtmetrix_result"></span>
                        </td>
                        <td scope="row" align="center">
                            <h3>Total Page Size</h3>
                            <span class="aj_latest_tps aj_gtmetrix_result"></span>
                        </td>
                        <td scope="row" align="center">
                            <h3>Requests</h3>
                            <span class="aj_latest_requests aj_gtmetrix_result"></span>
                        </td>
                    </tr>
                    <tr><td scope="row" align="center" colspan="6">See full report: <span class="aj_latest_report"></span></td></tr>
                </table>
                <hr />
                <?php
            }
            ?>
            <p>Please click on the button below to generate a new GTmetrix Report.</p>
            <p><strong>Please Note:</strong> By clicking the button below you acknowledge that you understand that one (1) GTmetrix API credit will be used.</p>
            <p><button data-id="aj_gtmetrix_test" class="aj_steps_button">Run GTmetrix Test</button></p>
            <h3>GTmetrix API Key</h3>
            <p>If you haven't already done so, grab an API Key from GTmetrix so that <?php echo AJ_TITLE; ?> can obtain your PageSpeed / YSlow results.  Here's how:</p>
            <ol>
                <li>Navigate to <a href="https://gtmetrix.com/api/" target="_blank">https://gtmetrix.com/api/</a> (link opens in a new tab)</li>
                <li>If you do not already have an account with GTmetrix, go ahead and sign up (it's FREE!).</li>
                <li>Log in to your GTmetrix account.</li>
                <li>If you haven't yet generated your API Key, click on <strong>Generate API Key</strong></li>
                <li>Copy your Username and API Key into the fields below:<br /><input type="text" id="aj_gtmetrix_username" value="<?php echo $aj_gtmetrix_username; ?>" placeholder="GTmetrix Username"><input type="text" id="aj_gtmetrix_api_key" value="<?php echo $aj_gtmetrix_api_key; ?>" placeholder="GTmetrix API Key"></li>
                <li>Select the desired server.<br />
                    <select id="aj_gtmetrix_server">
                        <?php
                        $gtmetrix_locations = array(
                            'Vancouver, Canada' => 1,
                            'London, United Kingdom' => 2,
                            'Sydney, Australia' => 3,
                            'Dallas, United States' => 4,
                            'Mumbai, India' => 5
                        );
                        foreach ( $gtmetrix_locations as $location => $value ) {
                            $selected = ( $aj_gtmetrix_server == $value ) ? ' selected="selected"' : '';
                            echo '<option value="' . $value . '"' . $selected . '>' . $location . '</option>';
                        }
                        ?>
                    </select>
                </li>
                <li>GTmetrix Credits Available: <span class="aj_gtmetrix_credits"><?php echo $credits; ?></span></li>
            </ol>
            <hr />
            <?php echo $this->hints_tips(); ?>
        </td>
    </tr>
</table>
<?php
