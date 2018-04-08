<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/*
 * this displays the wizard screen
 * uses the AJAX functions
 */

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
?>
<table class="form-table" style="width:100%;margin-top:0px;">
    <tr id="aj_step1">
        <td style="padding-top:0px;">
        <div class="asItemDetail">
            <h3><?php _e('Step 1: GTmetrix API Key', 'asyncjs'); ?></h3>
            <p><?php _e('<strong><em>Please Note:</em></strong> You do not have to use this Wizard. All settings can be changed under the', 'asyncjs'); ?> <a href="<?php echo menu_page_url(AJ_ADMIN_MENU_SLUG, false) . '&tab=settings'; ?>"><?php _e('Settings', 'asyncjs'); ?></a> <?php _e('tab.', 'asyncjs'); ?></p>
            <hr />
            <p><?php _e("If you haven't already done so, grab an API Key from GTmetrix so that Async JavaScript can obtain your PageSpeed / YSlow results.  Here's how:", 'asyncjs'); ?></p>
            <ol>
                <li><?php _e('Navigate to ', 'asyncjs'); ?><a href="https://gtmetrix.com/api/" target="_blank">https://gtmetrix.com/api/</a> <?php _e('(link opens in a new tab)', 'asyncjs'); ?></li>
                <li><?php _e("If you do not already have an account with GTmetrix, go ahead and sign up (it's FREE!).", 'asyncjs'); ?></li>
                <li><?php _e('Log in to your GTmetrix account.', 'asyncjs'); ?></li>
                <li><?php _e("If you haven't yet generated your API Key, click on <strong>Generate API Key</strong>", 'asyncjs'); ?></li>
                <li><?php _e('Copy your Username and API Key into the fields below:', 'asyncjs'); ?><br /><input type="text" id="aj_gtmetrix_username" value="<?php echo $aj_gtmetrix_username; ?>" placeholder="GTmetrix Username"><input type="text" id="aj_gtmetrix_api_key" value="<?php echo $aj_gtmetrix_api_key; ?>" placeholder="GTmetrix API Key"></li>
                <li><?php _e('Select the desired server.', 'asyncjs'); ?><br />
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
                <li><?php _e('GTmetrix Credits Available: ', 'asyncjs'); ?><span class="aj_gtmetrix_credits"><?php echo $credits; ?></span></li>
            </ol>
            <p><?php _e('<strong>Please Note:</strong> By clicking the button below you acknowledge that you understand that five (5) GTmetrix API credits will be used.', 'asyncjs'); ?></p>
            <p><button data-id="aj_step2" class="aj_steps_button button"><?php _e('Proceed to Step 2', 'asyncjs'); ?></button></p>
        </div>
        </td>
    </tr>
    <tr id="aj_step2" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Step 2: Initial Test Results', 'asyncjs'); ?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e('will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores.', 'asyncjs'); ?></p>
            <div id="aj_step2_please_wait"><div class="aj_loader"><h3 class="aj_loader_loading_text"><?php _e('Please Wait', 'asyncjs'); ?></h3></div></div>
            <table id="aj_step2_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3><?php _e('PageSpeed Score', 'asyncjs'); ?></h3>
                        <span class="aj_step2_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('YSlow Score', 'asyncjs'); ?></h3>
                        <span class="aj_step2_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Fully Loaded Time', 'asyncjs'); ?></h3>
                        <span class="aj_step2_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Total Page Size', 'asyncjs'); ?></h3>
                        <span class="aj_step2_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Requests', 'asyncjs'); ?></h3>
                        <span class="aj_step2_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('See full report:', 'asyncjs'); ?> <span class="aj_step2_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('Simulate', 'asyncjs'); ?> <span class="aj_step2_gtmetrix"></span>: <a href="" class="aj_step2_url" target="_blank"></a></tr>
                <p></p>
            </table>
        </div>
        </td>
    </tr>
    <tr id="aj_step2b" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Testing: Async', 'asyncjs');?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e("will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'async' method.", 'asyncjs'); ?></p>
            <div id="aj_step2b_please_wait"><div class="aj_loader"><h3 class="aj_loader_loading_text"><?php _e('Please Wait', 'asyncjs'); ?></h3></div></div>
            <table id="aj_step2b_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2b_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3><?php _e('PageSpeed Score', 'asyncjs');?></h3>
                        <span class="aj_step2b_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('YSlow Score', 'asyncjs');?></h3>
                        <span class="aj_step2b_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Fully Loaded Time', 'asyncjs');?></h3>
                        <span class="aj_step2b_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Total Page Size', 'asyncjs');?></h3>
                        <span class="aj_step2b_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Requests', 'asyncjs');?></h3>
                        <span class="aj_step2b_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('See full report:', 'asyncjs');?> <span class="aj_step2b_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2b_gtmetrix"></span>: <a href="" class="aj_step2b_url" target="_blank"></a></tr>
            </table>
        </div>
        </td>
    </tr>
    <tr id="aj_step2c" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Testing: Defer', 'asyncjs');?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e("will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'defer' method.", 'asyncjs');?></p>
            <div id="aj_step2c_please_wait"><div class="aj_loader"><h3 class="aj_loader_loading_text"><?php _e('Please Wait', 'asyncjs'); ?></h3></div></div>
            <table id="aj_step2c_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2c_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3><?php _e('PageSpeed Score', 'asyncjs');?></h3>
                        <span class="aj_step2c_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('YSlow Score', 'asyncjs');?></h3>
                        <span class="aj_step2c_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Fully Loaded Time', 'asyncjs');?></h3>
                        <span class="aj_step2c_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Total Page Size', 'asyncjs');?></h3>
                        <span class="aj_step2c_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Requests', 'asyncjs');?></h3>
                        <span class="aj_step2c_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('See full report:', 'asyncjs');?> <span class="aj_step2c_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2c_gtmetrix"></span>: <a href="" class="aj_step2c_url" target="_blank"></a></tr>
            </table>
        </div>
        </td>
    </tr>
    <tr id="aj_step2d" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Testing: Async (jQuery excluded)', 'asyncjs');?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e("will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'async' method but excluding jQuery.", 'asyncjs');?></p>
            <div id="aj_step2d_please_wait"><div class="aj_loader"><h3 class="aj_loader_loading_text"><?php _e('Please Wait', 'asyncjs'); ?></h3></div></div>
            <table id="aj_step2d_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2d_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3><?php _e('PageSpeed Score', 'asyncjs');?></h3>
                        <span class="aj_step2d_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('YSlow Score', 'asyncjs');?></h3>
                        <span class="aj_step2d_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Fully Loaded Time', 'asyncjs');?></h3>
                        <span class="aj_step2d_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Total Page Size', 'asyncjs');?></h3>
                        <span class="aj_step2d_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Requests', 'asyncjs');?></h3>
                        <span class="aj_step2d_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('See full report:', 'asyncjs');?> <span class="aj_step2d_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2d_gtmetrix"></span>: <a href="" class="aj_step2d_url" target="_blank"></a></tr>
            </table>
        </div>
        </td>
    </tr>
    <tr id="aj_step2e" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Testing: Defer (jQuery excluded)', 'asyncjs');?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e("will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'defer' method but excluding jQuery.", 'asyncjs');?></p>
            <div id="aj_step2e_please_wait"><div class="aj_loader"><h3 class="aj_loader_loading_text"><?php _e('Please Wait', 'asyncjs'); ?></h3></div></div>
            <table id="aj_step2e_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2e_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3><?php _e('PageSpeed Score', 'asyncjs');?></h3>
                        <span class="aj_step2e_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('YSlow Score', 'asyncjs');?></h3>
                        <span class="aj_step2e_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Fully Loaded Time', 'asyncjs');?></h3>
                        <span class="aj_step2e_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Total Page Size', 'asyncjs');?></h3>
                        <span class="aj_step2e_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3><?php _e('Requests', 'asyncjs');?></h3>
                        <span class="aj_step2e_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('See full report:', 'asyncjs');?> <span class="aj_step2e_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6"><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2e_gtmetrix"></span>: <a href="" class="aj_step2e_url" target="_blank"></a></tr>
            </table>
        </div>
        </td>
    </tr>
    <tr id="aj_step_results" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Step 3: Results &amp; Recommendations', 'asyncjs');?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e('has finished testing your site with the most common configuration options.', 'asyncjs');?></p>
            <p><?php _e('Based on the tests Async JavaScript has determined that <span class="aj_gtmetrix_config"></span> has resuled in <span id="aj_gtmetrix_inde_pagespeed"></span> in PageSpeed from <span id="aj_gtmetrix_baseline_pagespeed"></span> to <span id="aj_gtmetrix_best_pagespeed"></span> and <span id="aj_gtmetrix_inde_yslow"></span> in YSlow from <span id="aj_gtmetrix_baseline_yslow"></span> to <span id="aj_gtmetrix_best_yslow"></span>, with a Fully Loaded time of', 'asyncjs');?> <span id="aj_gtmetrix_best_fullyloaded"></span>.</p>
            <p><?php _e('Before applying these settings it is important to check your site is still functioning correctly.  Click the link below to open your site in a new tab / window to simulate the <?php echo AJ_TITLE; ?> settings and check that everything is working, and also be sure to check the console for any JavaScript errors (see <a href="https://codex.wordpress.org/Using_Your_Browser_to_Diagnose_JavaScript_Errors" target="_blank">Using Your Browser to Diagnose JavaScript Errors</a>)', 'asyncjs');?></p>
            <ul>
                <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_gtmetrix_config"></span>: <a href="" id="aj_gtmetrix_best_url" target="_blank"></a></li>
            </ul>
            <p><?php _e('Once you have simulated', 'asyncjs');?> <span class="aj_gtmetrix_config"></span> <?php _e('click on the button below to continue.', 'asyncjs');?></p>
            <p><button data-id="aj_step4" class="aj_steps_button button"><?php _e('Proceed to Step 4', 'asyncjs');?></button></p>
        </div>
        </td>
    </tr>
    <tr id="aj_step4" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <h3><?php _e('Step 4: Apply Settings', 'asyncjs');?></h3>
            <p><?php _e('Is your site still functioning properly and are there no JavaScript errors in the console?', 'asyncjs');?></p>
            <p><input type="radio" name="aj_step4_check" value="y"> <?php _e('Yes', 'asyncjs');?> <input type="radio" name="aj_step4_check" value="n"> <?php _e('No', 'asyncjs');?></p>
            <div id="aj_step4_y">
                <p><?php _e('Great to hear! To apply these settings click the button below.', 'asyncjs');?></p>
                <p><button data-id="aj_apply_settings" class="aj_steps_button button"><?php _e('Apply Settings', 'asyncjs');?></button></p>
            </div>
            <div id="aj_step4_n">
                <p><?php _e('Ok, so you have run the simulation on <span class="aj_gtmetrix_config"></span> and although there has been an improvement in reported performance, the simulation shows that something is not right with your site.', 'asyncjs');?></p>
                <div id="aj_step4_jquery_excluded">
                    <p><?php _e('In most cases the issue being experienced relates to jQuery (usually due to inline JavaScript which relies on jQuery) and the solution is to exclude jQuery.  However, in this simulation jQuery has already been exculded.  As a result a different configuration may work better with a marginal sacrifice in site speed improvement.', 'asyncjs');?></p>
                    <p><?php _e('Below are links that can be used to run simulations on each of the basic configurations.  Click on each of the links and check the functionality of your site as well as the console for errors.', 'asyncjs');?></p>
                    <ul>
                        <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2b_gtmetrix"></span>: <a href="" class="aj_step2b_url" target="_blank"></a></li>
                        <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2c_gtmetrix"></span>: <a href="" class="aj_step2c_url" target="_blank"></a></li>
                        <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2d_gtmetrix"></span>: <a href="" class="aj_step2d_url" target="_blank"></a></li>
                        <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2e_gtmetrix"></span>: <a href="" class="aj_step2e_url" target="_blank"></a></li>
                    </ul>
                    <p><?php _e('Click one of the buttons below to apply these settings or click the Settings button to go to the settings page for manual configuration.', 'asyncjs');?></p>
                    <p>
                        <button data-id="aj_step2b_apply" class="aj_steps_button button"><?php _e('Apply', 'asyncjs');?> <span class="aj_step2b_gtmetrix"></button>
                        <button data-id="aj_step2c_apply" class="aj_steps_button button"><?php _e('Apply', 'asyncjs');?> <span class="aj_step2c_gtmetrix"></button>
                        <button data-id="aj_step2d_apply" class="aj_steps_button button"><?php _e('Apply', 'asyncjs');?> <span class="aj_step2d_gtmetrix"></button>
                        <button data-id="aj_step2e_apply" class="aj_steps_button button"><?php _e('Apply', 'asyncjs');?> <span class="aj_step2e_gtmetrix"></button>
                    </p>
                    <p>
                        <button data-id="aj_goto_settings" class="aj_steps_button button"><?php _e('Settings', 'asyncjs');?></button>
                    </p>
                </div>
                <div id="aj_step4_jquery_not_excluded">
                    <p><?php _e('In most cases the issue being experienced relates to jQuery (usually due to inline JavaScript which relies on jQuery) and the solution is to exclude jQuery.', 'asyncjs');?></p>
                    <p><?php _e('Below are links that can be used to run simulations on each of the configurations with jQuery excluded.  Click on each of the links and check the functionality of your site as well as the console for errors.', 'asyncjs');?></p>
                    <ul>
                        <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2d_gtmetrix"></span>: <a href="" class="aj_step2d_url" target="_blank"></a></li>
                        <li><?php _e('Simulate', 'asyncjs');?> <span class="aj_step2e_gtmetrix"></span>: <a href="" class="aj_step2e_url" target="_blank"></a></li>
                    </ul>
                    <p><?php _e('Click one of the buttons below to apply these settings or click the Settings button to go to the settings page for manual configuration.', 'asyncjs');?></p>
                    <p>
                        <button data-id="aj_step2d_apply" class="aj_steps_button button"><?php _e('Apply', 'asyncjs');?> <span class="aj_step2d_gtmetrix"></button>
                        <button data-id="aj_step2e_apply" class="aj_steps_button button"><?php _e('Apply', 'asyncjs');?> <span class="aj_step2e_gtmetrix"></button>
                    </p>
                    <p>
                        <button data-id="aj_goto_settings" class="aj_steps_button button"><?php _e('Settings', 'asyncjs');?></button>
                    </p>
                </div>
            </div>
        </div>
        </td>
    </tr>
    <tr id="aj_step5" class="aj_steps_hidden">
        <td scope="row" align="left">
        <div class="asItemDetail">
            <?php echo $this->hints_tips(); ?>
            <p><button data-id="aj_goto_settings" class="aj_steps_button button">Settings</button></p>
            </div>
        </td>
    </tr>
</table>
<?php
