<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$site_url = trailingslashit(get_site_url());
$aj_gtmetrix_username = get_option('aj_gtmetrix_username', '');
$aj_gtmetrix_api_key = get_option('aj_gtmetrix_api_key', '');
$aj_gtmetrix_server = get_option('aj_gtmetrix_server', '');
$aj_enabled = get_option('aj_enabled', 0);
$aj_enabled_checked = ($aj_enabled == 1) ? ' checked="checked"' : '';
$aj_enabled_logged = get_option('aj_enabled_logged', 0);
$aj_enabled_logged_checked = ($aj_enabled_logged == 1) ? ' checked="checked"' : '';
$aj_enabled_shop = get_option('aj_enabled_shop', 0);
$aj_enabled_shop_checked = ($aj_enabled_shop == 1) ? ' checked="checked"' : '';
$aj_method = get_option('aj_method', 'async');
$aj_method_async = ($aj_method == 'async') ? ' checked="checked"' : '';
$aj_method_defer = ($aj_method == 'defer') ? ' checked="checked"' : '';
$aj_jquery = get_option('aj_jquery', 'async');
$aj_jquery = ($aj_jquery == 'same ') ? $aj_method : $aj_jquery;
$aj_jquery_async = ($aj_jquery == 'async') ? ' checked="checked"' : '';
$aj_jquery_defer = ($aj_jquery == 'defer') ? ' checked="checked"' : '';
$aj_jquery_exclude = ($aj_jquery == 'exclude') ? ' checked="checked"' : '';
$aj_async = get_option('aj_async', '');
$aj_defer = get_option('aj_defer', '');
$aj_exclusions = get_option('aj_exclusions', '');
$aj_plugin_exclusions = (is_array(get_option('aj_plugin_exclusions', array())) && !is_null(get_option('aj_plugin_exclusions', array())) ? get_option('aj_plugin_exclusions', array()) : explode(',', get_option('aj_plugin_exclusions', '')));
$aj_theme_exclusions = (is_array(get_option('aj_theme_exclusions', array())) && !is_null(get_option('aj_theme_exclusions', array())) ? get_option('aj_theme_exclusions', array()) : explode(',', get_option('aj_theme_exclusions', '')));
$aj_autoptimize_enabled = get_option('aj_autoptimize_enabled', 0);
$aj_autoptimize_enabled_checked = ($aj_autoptimize_enabled == 1) ? ' checked="checked"' : '';
$aj_autoptimize_method = get_option('aj_autoptimize_method', 'async');
$aj_autoptimize_async = ($aj_autoptimize_method == 'async') ? ' checked="checked"' : '';
$aj_autoptimize_defer = ($aj_autoptimize_method == 'defer') ? ' checked="checked"' : '';
?>

<div class="asItemDetail">
    <h3><?php _e('Enable ', 'async-javascript'); ?><?php echo AJ_TITLE; ?></h3>
    <p>
        <label><?php _e('Enable ', 'async-javascript'); ?><?php echo AJ_TITLE; ?>? </label>
        <input type="checkbox" name="aj_enabled" id="aj_enabled" value="1" <?php echo $aj_enabled_checked; ?> />
    </p>
    <p class='aj_enabled_sub <?php if ( ! $aj_enabled_checked ) { echo " hidden"; } ?>'>
        <label><?php _e('Also enable ', 'async-javascript'); ?><?php echo AJ_TITLE; ?> <?php _e('for logged in users','async-javascript'); ?>? </label>
        <input type="checkbox" name="aj_enabled_logged" id="aj_enabled_logged" value="1" <?php echo $aj_enabled_logged_checked; ?> />
    </p>
    <p class='aj_enabled_sub <?php if ( ! $aj_enabled_checked ) { echo " hidden"; } ?>'>
        <label><?php _e('Also enable ', 'async-javascript'); ?><?php echo AJ_TITLE; ?> <?php _e('on cart/ checkout pages','async-javascript'); ?>? </label>
        <input type="checkbox" name="aj_enabled_shop" id="aj_enabled_shop" value="1" <?php echo $aj_enabled_shop_checked; ?> />
    </p>
</div>

<div class="asItemDetail">
    <h3><?php _e('Quick Settings', 'async-javascript'); ?></h3>
    <p><?php _e('Use the buttons below to apply common settings.', 'async-javascript'); ?></p>
    <p><?php _e('<strong>Note: </strong>Using the buttons below will erase any current settings within ', 'async-javascript'); ?><?php echo AJ_TITLE; ?>.</p>
    <p>
        <button data-id="aj_step2b_apply" class="aj_steps_button button"><?php _e('Apply Async', 'async-javascript'); ?></button>
        <button data-id="aj_step2c_apply" class="aj_steps_button button"><?php _e('Apply Defer', 'async-javascript'); ?></button>
        <button data-id="aj_step2d_apply" class="aj_steps_button button"><?php _e('Apply Async', 'async-javascript'); _e(' (jQuery excluded)', 'async-javascript'); ?></button>
        <button data-id="aj_step2e_apply" class="aj_steps_button button"><?php _e('Apply Defer', 'async-javascript'); _e(' (jQuery excluded)', 'async-javascript'); ?></button>
    </p>
</div>

<div class="asItemDetail">
    <h3><?php echo AJ_TITLE; ?> Method</h3>
    <p><?php _e('Please select the method (<strong>async</strong> or <strong>defer</strong>) that you wish to enable:', 'async-javascript'); ?></p>
    <p><label><?php _e('Method: ', 'async-javascript'); ?></label><input type="radio" name="aj_method" value="async" <?php echo $aj_method_async; ?> /> Async <input type="radio" name="aj_method" value="defer" <?php echo $aj_method_defer; ?> /> Defer</p>
</div>
    <div class="asItemDetail">
    <h3><?php _e('jQuery', 'async-javascript'); ?></h3>
    <p><?php _e('Often if jQuery is loaded with <strong>async</strong> or <strong>defer</strong> it can break some jQuery functions, specifically inline scripts which require jQuery to be loaded before the scripts are run.  <strong><em>Sometimes</em></strong> choosing a different method (<strong>async</strong> or <strong>defer</strong>) will work, otherwise it may be necessary to exclude jQuery from having <strong>async</strong> or <strong>defer</strong> applied.', 'async-javascript'); ?></p>
    <p>
        <label><?php _e('jQuery Method: ', 'async-javascript'); ?></label>
        <input type="radio" id="aj_jquery" name="aj_jquery" value="async" <?php echo $aj_jquery_async; ?> /> Async <input type="radio" name="aj_jquery" value="defer" <?php echo $aj_jquery_defer; ?> /> Defer <input type="radio" name="aj_jquery" value="exclude" <?php echo $aj_jquery_exclude; ?> /> <?php _e('Exclude', 'async-javascript'); ?>
    </p>
</div>
    <div class="asItemDetail">
    <h3><?php _e('Scripts to Async', 'async-javascript'); ?></h3>
    <p><?php _e("Please list any scripts which you would like to apply the 'async' attribute to. (comma seperated list eg: jquery.js,jquery-ui.js)", 'async-javascript'); ?></p>
    <p>
        <label><?php _e('Scripts to Async:', 'async-javascript'); ?> </label>
        <textarea id="aj_async" style="width:95%;"><?php echo $aj_async; ?></textarea>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Scripts to Defer', 'async-javascript'); ?></h3>
    <p><?php _e("Please list any scripts which you would like to apply the 'defer' attribute to. (comma seperated list eg: jquery.js,jquery-ui.js)", 'async-javascript'); ?></p>
    <p>
        <label><?php _e('Scripts to Defer:', 'async-javascript'); ?> </label>
        <textarea id="aj_defer" style="width:95%;"><?php echo $aj_defer; ?></textarea>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Script Exclusion', 'async-javascript'); ?></h3>
    <p><?php _e('Please list any scripts which you would like excluded from having <strong>async</strong> or <strong>defer</strong> applied during page load. (comma seperated list eg: jquery.js,jquery-ui.js)', 'async-javascript'); ?></p>
    <p>
        <label><?php _e('Scripts to Exclude:', 'async-javascript'); ?> </label>
        <textarea id="aj_exclusions" style="width:95%;"><?php echo $aj_exclusions; ?></textarea>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Plugin Exclusions', 'async-javascript'); ?></h3>
    <p><?php _e('Please select one or more plugins. Scripts contained within the plugin will not have async / defer applied.', 'async-javascript'); ?></p>
    <p><?php _e('<strong><em>Please Note:</em></strong> This will exclude any JavaScript files which are contained within the files of the selected Plugin(s). External JavaScripts loaded by the selected Plugin(s) are not affected.', 'async-javascript'); ?></p>
    <p><?php _e('For Example: If a plugin is installed in path <strong>/wp-content/plugins/some-plugin/</strong> then and JavaScripts contained within this path will be excluded. If the plugin loads a JavaScript which is countained elsewhere then the Global Method will be used (ie async or defer)', 'async-javascript'); ?></p>
    <p><label><?php _e('Exclusions: ', 'async-javascript'); ?></label>
<?php
$plugins = get_plugins();
$output = '';
if (!empty($plugins)) {
    $output .= '<select id="aj_plugin_exclusions" class="aj_chosen" multiple="multiple" style="min-width:50%;" >';
    foreach ($plugins as $path=>$plugin) {
        $split = explode('/', $path);
        $text_domain = $split[0];
        if ($text_domain != 'async-javascript') {
            //var_dump( $aj_plugin_exclusions );
            $selected = (in_array($text_domain, $aj_plugin_exclusions)) ? ' selected="selected"' : '';
            $output .= '<option value="' . $text_domain . '"' . $selected . '>' . $plugin['Name'] . '</option>';
        }
    }
    $output .= '</select>';
} else {
    $output .= '<p>'.__('No plugins found.', 'async-javascript').'</p>';
}
echo $output;
?>
</p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Theme Exclusions', 'async-javascript'); ?></h3>
    <p><?php _e('Please select one or more themes. Scripts contained within the theme will not have async / defer applied.', 'async-javascript'); ?></p>
    <p><?php _e('<strong><em>Please Note:</em></strong> This will exclude any JavaScript files which are contained within the files of the selected Theme(s). External JavaScripts loaded by the selected Theme(s) are not affected.', 'async-javascript'); ?></p>
    <p><?php _e('For Example: If a theme is installed in path <strong>/wp-content/themes/some-theme/</strong> then and JavaScripts contained within this path will be excluded. If the theme loads a JavaScript which is countained elsewhere then the Global Method will be used (ie async or defer)', 'async-javascript'); ?></p>
    <p>
        <label><?php _e('Exclusions:', 'async-javascript'); ?> </label>
        <?php
        $themes = wp_get_themes();
        $output = '';
        if (!empty($themes)) {
            $output .= '<select id="aj_theme_exclusions" class="aj_chosen" multiple="multiple" style="min-width:50%;" >';
            foreach ($themes as $path=>$theme) {
                $text_domain = $path;
                $selected = (in_array($text_domain, $aj_theme_exclusions)) ? ' selected="selected"' : '';
                $output .= '<option value="' . $text_domain . '"' . $selected . '>' . $theme->Name . '</option>';
            }
            $output .= '</select>';
        } else {
            $output .= '<p>'. __('No themes found.', 'async-javascript').'</p>';
        }
        echo $output;
        ?>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php echo AJ_TITLE; ?> <?php _e('For Plugins', 'async-javascript'); ?></h3>
    <p><?php _e('Although not recommended, some themes / plugins can load JavaScript files without using the <strong><a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts" target="_blank">wp_enqueue_script</a></strong> function.  In some cases this is necessary for the functionality of the theme / plugin.', 'async-javascript'); ?></p>
    <p><?php _e('If these themes / plugins provide a hook that can be used to manipulate how the JavaScript file is loaded then Async Javascript may be able to provide support for these themes / plugins.', 'async-javascript'); ?></p>
    <p><?php _e('If you have any active themes / plugins that Async Javascript supports then these will be listed below.', 'async-javascript'); ?></p>
    <p><?php _e('If you think you have found a plugin that Async Javascript may be able to provide support for please lodge a ticket at <a href="https://wordpress.org/support/plugin/async-javascript" target="_blank">https://wordpress.org/support/plugin/async-javascript</a>', 'async-javascript'); ?></p>
        <?php
        if (is_plugin_active('autoptimize/autoptimize.php') || is_plugin_active('autoptimize-beta/autoptimize.php')) {
                ?>
                <div class="aj_plugin">
                        <h4><?php _e('Plugin: Autoptimize', 'async-javascript'); ?></h4>
                        <p>
                            <label><?php _e('Enable Autoptimize Support to allow you to override AO\'s default "defer" flag (see below):', 'async-javascript'); ?> </label>
                            <input type="checkbox" id="aj_autoptimize_enabled" value="1" <?php echo $aj_autoptimize_enabled_checked; ?> />
                        </p>
                        <p>
                            <label><?php _e('Autoptimize Javascript Method:', 'async-javascript'); ?> </label>
                            <input type="radio" name="aj_autoptimize_method" value="async" <?php echo $aj_autoptimize_async; ?> /> Async <input type="radio" name="aj_autoptimize_method" value="defer" <?php echo $aj_autoptimize_defer; ?> /> Defer
                            <div><?php _e('If Async Javascripts is set to "async" you can try changing Autoptimize\'s Javascript Method to "async" as well. This might help improving performance, but on the other hand might break things, so test to see if this is useful.', 'async-javascript'); ?></div>
                        </p>
                </div>
                <?php
            }
        ?>
</div>
<p>
    <button data-id="aj_save_settings" class="aj_steps_button button"><?php _e('Save Settings', 'async-javascript'); ?></button>
</p>
