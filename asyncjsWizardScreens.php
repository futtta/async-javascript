<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* 
 * this displays the wizard screen
 * uses the AJAX functions
 */
 
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
?>
<table class="form-table" width="100%" cellpadding="10">
    <tr id="aj_intro">
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/finger_point_out_punch_hole_400_clr_17860.png" title="<?php echo AJ_TITLE; ?>" alt="<?php echo AJ_TITLE; ?>"  class="aj_step_img"></td>
        <td scope="row" align="left" style="vertical-align: top !important;">
            <h3><?php echo AJ_TITLE; ?></h3>
            <?php echo $this->about_aj(); ?>
        </td>
    </tr>
    <tr id="aj_step1">
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/number_one_break_hole_150_clr_18741.gif" title="Step 1" alt="GTmetrix API Key" class="aj_step_img"></td>
        <td scope="row" align="left" style="vertical-align: top !important;">
            <h3>Step 1: GTmetrix API Key</h3>
            <p><strong><em>Please Note:</em></strong> You do not have to use this Wizard.  All settings can be changed under the <a href="<?php echo menu_page_url( AJ_ADMIN_MENU_SLUG, false ) . '&tab=settings'; ?>">Settings</a> tab.</p>
            <hr />
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
            <p><strong>Please Note:</strong> By clicking the button below you acknowledge that you understand that five (5) GTmetrix API credits will be used.</p>
            <p><button data-id="aj_step2" class="aj_steps_button">Proceed to Step 2</button></p>
        </td>
    </tr>
    <tr id="aj_step2" class="aj_steps_hidden">
        <td scope="row" align="center"><img src="<?php echo AJ_PLUGIN_URL; ?>images/number_two_break_hole_150_clr_18753.gif" title="Step 2" alt="Initial Test Results" class="aj_step_img"></td>
        <td scope="row" align="left">
            <h3>Step 2: Initial Test Results</h3>
            <p><?php echo AJ_TITLE; ?> will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores.</p>
            <p id="aj_step2_please_wait"><img src="<?php echo AJ_PLUGIN_URL; ?>images/loading.gif" title="Please Wait" alt="Please Wait" class="aj_step_img"></p>
            <table id="aj_step2_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3>PageSpeed Score</h3>
                        <span class="aj_step2_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>YSlow Score</h3>
                        <span class="aj_step2_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Fully Loaded Time</h3>
                        <span class="aj_step2_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Total Page Size</h3>
                        <span class="aj_step2_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Requests</h3>
                        <span class="aj_step2_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6">See full report: <span class="aj_step2_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6">Simulate <span class="aj_step2_gtmetrix"></span>: <a href="" class="aj_step2_url" target="_blank"></a></tr>
                <p></p>
            </table>
        </td>
    </tr>
    <tr id="aj_step2b" class="aj_steps_hidden">
        <td scope="row" align="center"></td>
        <td scope="row" align="left">
            <h3>Testing: Async</h3>
            <p><?php echo AJ_TITLE; ?> will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'async' method.</p>
            <p id="aj_step2b_please_wait"><img src="<?php echo AJ_PLUGIN_URL; ?>images/loading.gif" title="Please Wait" alt="Please Wait" class="aj_step_img"></p>
            <table id="aj_step2b_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2b_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3>PageSpeed Score</h3>
                        <span class="aj_step2b_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>YSlow Score</h3>
                        <span class="aj_step2b_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Fully Loaded Time</h3>
                        <span class="aj_step2b_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Total Page Size</h3>
                        <span class="aj_step2b_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Requests</h3>
                        <span class="aj_step2b_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6">See full report: <span class="aj_step2b_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6">Simulate <span class="aj_step2b_gtmetrix"></span>: <a href="" class="aj_step2b_url" target="_blank"></a></tr>
            </table>
        </td>
    </tr>
    <tr id="aj_step2c" class="aj_steps_hidden">
        <td scope="row" align="center"></td>
        <td scope="row" align="left">
            <h3>Testing: Defer</h3>
            <p><?php echo AJ_TITLE; ?> will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'defer' method.</p>
            <p id="aj_step2c_please_wait"><img src="<?php echo AJ_PLUGIN_URL; ?>images/loading.gif" title="Please Wait" alt="Please Wait" class="aj_step_img"></p>
            <table id="aj_step2c_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2c_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3>PageSpeed Score</h3>
                        <span class="aj_step2c_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>YSlow Score</h3>
                        <span class="aj_step2c_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Fully Loaded Time</h3>
                        <span class="aj_step2c_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Total Page Size</h3>
                        <span class="aj_step2c_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Requests</h3>
                        <span class="aj_step2c_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6">See full report: <span class="aj_step2c_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6">Simulate <span class="aj_step2c_gtmetrix"></span>: <a href="" class="aj_step2c_url" target="_blank"></a></tr>
            </table>
        </td>
    </tr>
    <tr id="aj_step2d" class="aj_steps_hidden">
        <td scope="row" align="center"></td>
        <td scope="row" align="left">
            <h3>Testing: Async (jQuery excluded)</h3>
            <p><?php echo AJ_TITLE; ?> will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'async' method but excluding jQuery.</p>
            <p id="aj_step2d_please_wait"><img src="<?php echo AJ_PLUGIN_URL; ?>images/loading.gif" title="Please Wait" alt="Please Wait" class="aj_step_img"></p>
            <table id="aj_step2d_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2d_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3>PageSpeed Score</h3>
                        <span class="aj_step2d_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>YSlow Score</h3>
                        <span class="aj_step2d_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Fully Loaded Time</h3>
                        <span class="aj_step2d_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Total Page Size</h3>
                        <span class="aj_step2d_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Requests</h3>
                        <span class="aj_step2d_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6">See full report: <span class="aj_step2d_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6">Simulate <span class="aj_step2d_gtmetrix"></span>: <a href="" class="aj_step2d_url" target="_blank"></a></tr>
            </table>
        </td>
    </tr>
    <tr id="aj_step2e" class="aj_steps_hidden">
        <td scope="row" align="center"></td>
        <td scope="row" align="left">
            <h3>Testing: Defer (jQuery excluded)</h3>
            <p><?php echo AJ_TITLE; ?> will now query GTmetrix and retrieve your sites PageSpeed and YSlow scores whilst simulating the JavaScript 'defer' method but excluding jQuery.</p>
            <p id="aj_step2e_please_wait"><img src="<?php echo AJ_PLUGIN_URL; ?>images/loading.gif" title="Please Wait" alt="Please Wait" class="aj_step_img"></p>
            <table id="aj_step2e_gtmetrix_results" class="form-table aj-steps-table" width="100%" cellpadding="10">
                <tr>
                    <td scope="row" align="center"><img src="" class="aj_step2e_screenshot aj_gtmetrix_screenshot">
                    <td scope="row" align="center">
                        <h3>PageSpeed Score</h3>
                        <span class="aj_step2e_pagespeed aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>YSlow Score</h3>
                        <span class="aj_step2e_yslow aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Fully Loaded Time</h3>
                        <span class="aj_step2e_flt aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Total Page Size</h3>
                        <span class="aj_step2e_tps aj_gtmetrix_result"></span>
                    </td>
                    <td scope="row" align="center">
                        <h3>Requests</h3>
                        <span class="aj_step2e_requests aj_gtmetrix_result"></span>
                    </td>
                </tr>
                <tr><td scope="row" align="left" colspan="6">See full report: <span class="aj_step2e_report"></span></td></tr>
                <tr><td scope="row" align="left" colspan="6">Simulate <span class="aj_step2e_gtmetrix"></span>: <a href="" class="aj_step2e_url" target="_blank"></a></tr>
            </table>
        </td>
    </tr>
    <tr id="aj_step_results" class="aj_steps_hidden">
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/number_three_break_hole_150_clr_18837.gif" title="Results &amp; Recommendations" alt="Results &amp; Recommendations"  class="aj_step_img"></td>
        <td scope="row" align="left">
            <h3>Step 3: Results &amp; Recommendations</h3>
            <p><?php echo AJ_TITLE; ?> has finished testing your site with the most common configuration options.</p>
            <p>Based on the tests <?php echo AJ_TITLE; ?> has determined that <span class="aj_gtmetrix_config"></span> has resulted in <span id="aj_gtmetrix_inde_pagespeed"></span> in PageSpeed from <span id="aj_gtmetrix_baseline_pagespeed"></span> to <span id="aj_gtmetrix_best_pagespeed"></span> and <span id="aj_gtmetrix_inde_yslow"></span> in YSlow from <span id="aj_gtmetrix_baseline_yslow"></span> to <span id="aj_gtmetrix_best_yslow"></span>, with a Fully Loaded time of <span id="aj_gtmetrix_best_fullyloaded"></span>.</p>
            <p>Before applying these settings it is important to check your site is still functioning correctly.  Click the link below to open your site in a new tab / window to simulate the <?php echo AJ_TITLE; ?> settings and check that everything is working, and also be sure to check the console for any JavaScript errors (see <a href="https://codex.wordpress.org/Using_Your_Browser_to_Diagnose_JavaScript_Errors" target="_blank">Using Your Browser to Diagnose JavaScript Errors</a>)</p>
            <ul>
                <li>Simulate <span class="aj_gtmetrix_config"></span>: <a href="" id="aj_gtmetrix_best_url" target="_blank"></a></li>
            </ul>
            <p>Once you have simulated <span class="aj_gtmetrix_config"></span> click on the button below to continue.</p>
            <p><button data-id="aj_step4" class="aj_steps_button">Proceed to Step 4</button></p>
        </td>
    </tr>
    <tr id="aj_step4" class="aj_steps_hidden">
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/number_four_break_hole_150_clr_18840.gif" title="Apply Settings" alt="Apply Settings"  class="aj_step_img"></td>
        <td scope="row" align="left">
            <h3>Step 4: Apply Settings</h3>
            <p>Is your site still functioning properly and are there no JavaScript errors in the console?</p>
            <p><input type="radio" name="aj_step4_check" value="y"> Yes <input type="radio" name="aj_step4_check" value="n"> No</p>
            <div id="aj_step4_y">
                <p>Great to hear! To apply these settings click the button below.</p>
                <p><button data-id="aj_apply_settings" class="aj_steps_button">Apply Settings</button></p>
            </div>
            <div id="aj_step4_n">
                <p>Ok, so you have run the simulation on <span class="aj_gtmetrix_config"></span> and although there has been an improvement in reported performance, the simulation shows that something is not right with your site.</p>
                <div id="aj_step4_jquery_excluded">
                    <p>In most cases the issue being experienced relates to jQuery (usually due to inline JavaScript which relies on jQuery) and the solution is to exclude jQuery.  However, in this simulation jQuery has already been exculded.  As a result a different configuration may work better with a marginal sacrifice in site speed improvement.</p>
                    <p>Below are links that can be used to run simulations on each of the basic configurations.  Click on each of the links and check the functionality of your site as well as the console for errors.</p>
                    <ul>
                        <li>Simulate <span class="aj_step2b_gtmetrix"></span>: <a href="" class="aj_step2b_url" target="_blank"></a></li>
                        <li>Simulate <span class="aj_step2c_gtmetrix"></span>: <a href="" class="aj_step2c_url" target="_blank"></a></li>
                        <li>Simulate <span class="aj_step2d_gtmetrix"></span>: <a href="" class="aj_step2d_url" target="_blank"></a></li>
                        <li>Simulate <span class="aj_step2e_gtmetrix"></span>: <a href="" class="aj_step2e_url" target="_blank"></a></li>
                    </ul>
                    <p>Click one of the buttons below to apply these settings or click the Settings button to go to the settings page for manual configuration.</p>
                    <p>
                        <button data-id="aj_step2b_apply" class="aj_steps_button">Apply <span class="aj_step2b_gtmetrix"></button>
                        <button data-id="aj_step2c_apply" class="aj_steps_button">Apply <span class="aj_step2c_gtmetrix"></button>
                        <button data-id="aj_step2d_apply" class="aj_steps_button">Apply <span class="aj_step2d_gtmetrix"></button>
                        <button data-id="aj_step2e_apply" class="aj_steps_button">Apply <span class="aj_step2e_gtmetrix"></button>
                    </p>
                    <p>
                        <button data-id="aj_goto_settings" class="aj_steps_button">Settings</button>
                    </p>
                </div>
                <div id="aj_step4_jquery_not_excluded">
                    <p>In most cases the issue being experienced relates to jQuery (usually due to inline JavaScript which relies on jQuery) and the solution is to exclude jQuery.</p>
                    <p>Below are links that can be used to run simulations on each of the configurations with jQuery excluded.  Click on each of the links and check the functionality of your site as well as the console for errors.</p>
                    <ul>
                        <li>Simulate <span class="aj_step2d_gtmetrix"></span>: <a href="" class="aj_step2d_url" target="_blank"></a></li>
                        <li>Simulate <span class="aj_step2e_gtmetrix"></span>: <a href="" class="aj_step2e_url" target="_blank"></a></li>
                    </ul>
                    <p>Click one of the buttons below to apply these settings or click the Settings button to go to the settings page for manual configuration.</p>
                    <p>
                        <button data-id="aj_step2d_apply" class="aj_steps_button">Apply <span class="aj_step2d_gtmetrix"></button>
                        <button data-id="aj_step2e_apply" class="aj_steps_button">Apply <span class="aj_step2e_gtmetrix"></button>
                    </p>
                    <p>
                        <button data-id="aj_goto_settings" class="aj_steps_button">Settings</button>
                    </p>
                </div>
            </div>
        </td>
    </tr>
    <tr id="aj_step5" class="aj_steps_hidden">
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/number_five_break_hole_150_clr_18842.gif" title="Further Hints &amp; Tips" alt="Further Hints &amp; Tips"  class="aj_step_img"></td>
        <td scope="row" align="left">
            <?php echo $this->hints_tips(); ?>
            <p><button data-id="aj_goto_settings" class="aj_steps_button">Settings</button></p>
        </td>
    </tr>
</table>
<?php
