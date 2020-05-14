<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$site_url = trailingslashit(get_site_url());
$aj_gtmetrix_username = get_option('aj_gtmetrix_username', '');
$aj_gtmetrix_api_key = get_option('aj_gtmetrix_api_key', '');
$aj_gtmetrix_server = get_option('aj_gtmetrix_server', '');
if ($aj_gtmetrix_username != '' && $aj_gtmetrix_api_key != '') {
    $test = new Services_WTF_Test();
    $test->api_username($aj_gtmetrix_username);
    $test->api_password($aj_gtmetrix_api_key);
    $test->user_agent(AJ_UA);
    $status = $test->status();
    $credits = $status['api_credits'];
} else {
    $credits = 'N/A';
}
$aj_enabled = (get_option('aj_enabled', 0) == 1) ? 'Enabled' : 'Disabled';
$aj_method = (get_option('aj_method', 'async') == 'async') ? 'Async' : 'Defer';
$aj_jquery = get_option('aj_jquery', 'async');
$aj_jquery = ($aj_jquery == 'same ') ? get_option('aj_method', 'async') : $aj_jquery;
$aj_jquery = ( $aj_jquery == 'async' ) ? 'Async' : ( ( $aj_jquery == 'defer' ) ? 'Defer' : 'Excluded' );
$aj_async = get_option('aj_async', '');
$aj_defer = get_option('aj_defer', '');
$aj_exclusions = get_option('aj_exclusions', '');
$aj_plugin_exclusions = (is_array(get_option('aj_plugin_exclusions', array())) && !is_null(get_option('aj_plugin_exclusions', array())) ? get_option('aj_plugin_exclusions', array()) : explode(',', get_option('aj_plugin_exclusions', '')));
$aj_theme_exclusions = (is_array(get_option('aj_theme_exclusions', array())) && !is_null(get_option('aj_theme_exclusions', array())) ? get_option('aj_theme_exclusions', array()) : explode(',', get_option('aj_theme_exclusions', '')));
$aj_autoptimize_enabled = (get_option('aj_autoptimize_enabled', 0) == 1) ? 'Enabled' : 'Disabled';
$aj_autoptimize_method = (get_option('aj_autoptimize_method', 'async') == 'async') ? 'Async' : 'Defer';
?>


<div class="asItemDetail">
<h3><?php echo AJ_TITLE; ?></h3>
<ul>
    <li><strong><?php _e('Status', 'async-javascript'); ?>:</strong> <?php echo $aj_enabled; ?></li>
    <?php
    if ($aj_enabled == 'Enabled') {
        ?>
        <li><strong><?php _e('Method', 'async-javascript'); ?>:</strong> <?php echo $aj_method; ?></li>
        <li><strong><?php _e('jQuery', 'async-javascript'); ?>:</strong> <?php echo $aj_jquery; ?></li>
        <li><strong><?php _e('Async Scripts', 'async-javascript'); ?>:</strong> <?php echo $aj_async; ?></li>
        <li><strong><?php _e('Defer Scripts', 'async-javascript'); ?>:</strong> <?php echo $aj_defer; ?></li>
        <li><strong><?php _e('Exclusions', 'async-javascript'); ?>:</strong>
            <ul>
                <li><strong><?php _e('Scripts', 'async-javascript'); ?>:</strong> <?php echo $aj_exclusions; ?></li>
                <li><strong><?php _e('Plugins', 'async-javascript'); ?>:</strong> <?php echo implode(',', $aj_plugin_exclusions); ?></li>
                <li><strong><?php _e('Themes', 'async-javascript'); ?>:</strong> <?php echo implode(',', $aj_theme_exclusions); ?></li>
            </ul>
        </li>
        <?php
        if (is_plugin_active('autoptimize/autoptimize.php')) {
            ?>
            <li><strong><?php _e('Autoptimize Status', 'async-javascript'); ?>:</strong> <?php echo $aj_autoptimize_enabled; ?></li>
            <?php
            if ($aj_autoptimize_enabled == 'Enabled') {
                ?>
                <li><strong><?php _e('Autoptimize Method', 'async-javascript'); ?>:</strong> <?php echo $aj_autoptimize_method; ?></li>
                <?php
            }
        } else {
            ?>
            <li><?php _e('Autoptimize not installed or activated.', 'async-javascript'); ?></li>
            <?php
        }
    }
    ?>
</ul>
</div>
<div class="asItemDetail">
<h3><?php _e('Latest GTmetrix Results', 'async-javascript'); ?></h3>
<?php
$aj_gtmetrix_results = get_option('aj_gtmetrix_results', array());
if (isset($aj_gtmetrix_results['latest'])) {
    $latest = $aj_gtmetrix_results['latest'];
    $screenshot = $latest['screenshot'];
    $pagespeed = $latest['results']['pagespeed_score'];
    $yslow = $latest['results']['yslow_score'];
    $pr = round(255 * (1 - ($pagespeed / 100)), 0);
    $yr = round(255 * (1 - ($yslow / 100)), 0);
    $pg = round(255 * ($pagespeed / 100), 0);
    $yg = round(255 * ($yslow / 100), 0);
    $pagespeed_style = ' style="color: rgb(' . $pr . ',' . $pg . ',0 )"';
    $yslow_style = ' style="color: rgb(' . $yr . ',' . $yg . ',0 )"';
    $flt = number_format(( float )$latest['results']['fully_loaded_time'] / 1000, 2, '.', '');
    $tps = number_format(( float )$latest['results']['page_bytes'] / 1024, 0, '.', '');
    $tps = ($tps > 1024) ? number_format(( float )$tps / 1024, 2, '.', '') . 'MB' : $tps . 'KB';
    $requests = $latest['results']['page_elements'];
    $report = $latest['results']['report_url'];
    $report_url = '<a href="' . $report . '" target="_blank">' . $report . '</a>'; ?>
    <div id="aj_latest_please_wait"><div class="aj_loader"><h3 class="aj_loader_loading_text"><?php _e('Please Wait', 'async-javascript'); ?></h3></div></div>
    <table id="aj_latest_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
        <tr>
            <td scope="row" align="center"><img src="data:image/jpeg;base64,<?php echo $screenshot; ?>" class="aj_latest_screenshot aj_gtmetrix_screenshot">
            <td scope="row" align="center">
                <h3><?php _e('PageSpeed Score', 'async-javascript'); ?></h3>
                <span class="aj_latest_pagespeed aj_gtmetrix_result"<?php echo $pagespeed_style; ?>><?php echo $pagespeed; ?>%</span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('YSlow Score', 'async-javascript'); ?></h3>
                <span class="aj_latest_yslow aj_gtmetrix_result"<?php echo $yslow_style; ?>><?php echo $yslow; ?>%</span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('Fully Loaded Time', 'async-javascript'); ?></h3>
                <span class="aj_latest_flt aj_gtmetrix_result"><?php echo $flt; ?>s</span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('Total Page Size', 'async-javascript'); ?></h3>
                <span class="aj_latest_tps aj_gtmetrix_result"><?php echo $tps; ?></span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('Requests', 'async-javascript'); ?></h3>
                <span class="aj_latest_requests aj_gtmetrix_result"><?php echo $requests; ?></span>
            </td>
        </tr>
        <tr><td scope="row" align="left" colspan="6"><?php _e('See full report:', 'async-javascript'); ?> <span class="aj_latest_report"><?php echo $report_url; ?></span></td></tr>
    </table>
    </div>
    <?php
} else {
    ?>
    <table id="aj_latest_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10" style="display: none;">
        <tr>
            <td scope="row" align="center"><img src="" class="aj_latest_screenshot aj_gtmetrix_screenshot">
            <td scope="row" align="center">
                <h3><?php _e('PageSpeed Score', 'async-javascript'); ?></h3>
                <span class="aj_latest_pagespeed aj_gtmetrix_result"></span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('YSlow Score', 'async-javascript'); ?></h3>
                <span class="aj_latest_yslow aj_gtmetrix_result"></span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('Fully Loaded Time', 'async-javascript'); ?></h3>
                <span class="aj_latest_flt aj_gtmetrix_result"></span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('Total Page Size', 'async-javascript'); ?></h3>
                <span class="aj_latest_tps aj_gtmetrix_result"></span>
            </td>
            <td scope="row" align="center">
                <h3><?php _e('Requests', 'async-javascript'); ?></h3>
                <span class="aj_latest_requests aj_gtmetrix_result"></span>
            </td>
        </tr>
        <tr><td scope="row" align="center" colspan="6"><?php _e('See full report:', 'async-javascript'); ?> <span class="aj_latest_report"></span></td></tr>
    </table>
</div>
    <?php
}
?>
<div class="asItemDetail">
<h3><?php _e('Generate New Report', 'async-javascript'); ?></h3>
<p><?php _e('Please click on the button below to generate a new GTmetrix Report.', 'async-javascript'); ?></p>
<p><?php _e('<strong>Please Note:</strong> By clicking the button below you acknowledge that you understand that one (1) GTmetrix API credit will be used.', 'async-javascript'); ?></p>
<p><button data-id="aj_gtmetrix_test" class="aj_steps_button button"><?php _e('Run GTmetrix Test', 'async-javascript'); ?></button></p>
</div>
<div class="asItemDetail">
<h3><?php _e('GTmetrix API Key', 'async-javascript'); ?></h3>
<p><?php _e("If you haven't already done so, grab an API Key from GTmetrix so that Async JavaScript can obtain your PageSpeed / YSlow results.  Here's how:", 'async-javascript'); ?></p>
<ol>
    <li><?php _e('Navigate to <a href="https://gtmetrix.com/api/" target="_blank">https://gtmetrix.com/api/</a> (link opens in a new tab)', 'async-javascript'); ?></li>
    <li><?php _e("If you do not already have an account with GTmetrix, go ahead and sign up (it's FREE!).", 'async-javascript'); ?></li>
    <li><?php _e('Log in to your GTmetrix account.', 'async-javascript'); ?></li>
    <li><?php _e("If you haven't yet generated your API Key, click on <strong>Generate API Key</strong>", 'async-javascript'); ?></li>
    <li><?php _e('Copy your Username and API Key into the fields below:', 'async-javascript'); ?><br /><input type="text" id="aj_gtmetrix_username" value="<?php echo $aj_gtmetrix_username; ?>" placeholder="GTmetrix Username"><input type="text" id="aj_gtmetrix_api_key" value="<?php echo $aj_gtmetrix_api_key; ?>" placeholder="GTmetrix API Key"></li>
    <li><?php _e('Select the desired server.', 'async-javascript'); ?><br />
        <select id="aj_gtmetrix_server">
            <?php
            $gtmetrix_locations = array(
                'Vancouver, Canada' => 1,
                'London, United Kingdom' => 2,
                'Sydney, Australia' => 3,
                'Dallas, United States' => 4,
                'Mumbai, India' => 5
            );
            foreach ($gtmetrix_locations as $location => $value) {
                $selected = ($aj_gtmetrix_server == $value) ? ' selected="selected"' : '';
                echo '<option value="' . $value . '"' . $selected . '>' . $location . '</option>';
            }
            ?>
        </select>
    </li>
    <li><?php _e('GTmetrix Credits Available:', 'async-javascript'); ?> <span class="aj_gtmetrix_credits"><?php echo $credits; ?></span></li>
</ol>
</div>
<?php
