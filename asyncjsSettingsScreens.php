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
    <h3><?php _e('Enable ', 'asyncjs'); ?><?php echo AJ_TITLE; ?></h3>
    <p>
        <label><?php _e('Enable ', 'asyncjs'); ?><?php echo AJ_TITLE; ?>? </label>
        <input type="checkbox" id="aj_enabled" id="aj_enabled" value="1" <?php echo $aj_enabled_checked; ?> />
    </p>
</div>

<div class="asItemDetail">
    <h3><?php _e('Quick Settings', 'asyncjs'); ?></h3>
    <p><?php _e('Use the buttons below to apply common settings.', 'asyncjs'); ?></p>
    <p><?php _e('<strong>Note: </strong>Using the buttons below will erase any current settings within ', 'asyncjs'); ?><?php echo AJ_TITLE; ?>.</p>
    <p>
        <button data-id="aj_step2b_apply" class="aj_steps_button button"><?php _e('Apply Async', 'asyncjs'); ?></button>
        <button data-id="aj_step2c_apply" class="aj_steps_button button"><?php _e('Apply Defer', 'asyncjs'); ?></button>
        <button data-id="aj_step2d_apply" class="aj_steps_button button"><?php _e('Apply Async', 'asyncjs'); _e(' (jQuery excluded)', 'asyncjs'); ?></button>
        <button data-id="aj_step2e_apply" class="aj_steps_button button"><?php _e('Apply Defer', 'asyncjs'); _e(' (jQuery excluded)', 'asyncjs'); ?></button>
    </p>
</div>

<div class="asItemDetail">
    <h3><?php echo AJ_TITLE; ?> Method</h3>
    <p><?php _e('Please select the method (<strong>async</strong> or <strong>defer</strong>) that you wish to enable:', 'asyncjs'); ?></p>
    <p><label><?php _e('Method: ', 'asyncjs'); ?></label><input type="radio" name="aj_method" value="async" <?php echo $aj_method_async; ?> /> Async <input type="radio" name="aj_method" value="defer" <?php echo $aj_method_defer; ?> /> Defer</p>
</div>
    <div class="asItemDetail">
    <h3><?php _e('jQuery', 'asyncjs'); ?></h3>
    <p><?php _e('Often if jQuery is loaded with <strong>async</strong> or <strong>defer</strong> it can break some jQuery functions, specifically inline scripts which require jQuery to be loaded before the scripts are run.  <strong><em>Sometimes</em></strong> choosing a different method (<strong>async</strong> or <strong>defer</strong>) will work, otherwise it may be necessary to exclude jQuery from having <strong>async</strong> or <strong>defer</strong> applied.', 'asyncjs'); ?></p>
    <p>
        <label><?php _e('jQuery Method: ', 'asyncjs'); ?></label>
        <input type="radio" name="aj_jquery" value="async" <?php echo $aj_jquery_async; ?> /> Async <input type="radio" name="aj_jquery" value="defer" <?php echo $aj_jquery_defer; ?> /> Defer <input type="radio" name="aj_jquery" value="exclude" <?php echo $aj_jquery_exclude; ?> /> <?php _e('Exclude', 'asyncjs'); ?>
    </p>
</div>
    <div class="asItemDetail">
    <h3><?php _e('Scripts to Async', 'asyncjs'); ?></h3>
    <p><?php _e("Please list any scripts which you would like to apply the 'async' attribute to. (comma seperated list eg: jquery.js,jquery-ui.js)", 'asyncjs'); ?></p>
    <p>
        <label><?php _e('Scripts to Async:', 'asyncjs'); ?> </label>
        <textarea id="aj_async" style="width:95%;"><?php echo $aj_async; ?></textarea>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Scripts to Defer', 'asyncjs'); ?></h3>
    <p><?php _e("Please list any scripts which you would like to apply the 'defer' attribute to. (comma seperated list eg: jquery.js,jquery-ui.js)", 'asyncjs'); ?></p>
    <p>
        <label><?php _e('Scripts to Defer:', 'asyncjs'); ?> </label>
        <textarea id="aj_defer" style="width:95%;"><?php echo $aj_defer; ?></textarea>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Script Exclusion', 'asyncjs'); ?></h3>
    <p><?php _e('Please list any scripts which you would like excluded from having <strong>async</strong> or <strong>defer</strong> applied during page load. (comma seperated list eg: jquery.js,jquery-ui.js)', 'asyncjs'); ?></p>
    <p>
        <label><?php _e('Scripts to Exclude:', 'asyncjs'); ?> </label>
        <textarea id="aj_exclusions" style="width:95%;"><?php echo $aj_exclusions; ?></textarea>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Plugin Exclusions', 'asyncjs'); ?></h3>
    <p><?php _e('Please select one or more plugins. Scripts contained within the plugin will not have async / defer applied.', 'asyncjs'); ?></p>
    <p><?php _e('<strong><em>Please Note:</em></strong> This will exclude any JavaScript files which are contained within the files of the selected Plugin(s). External JavaScripts loaded by the selected Plugin(s) are not affected.', 'asyncjs'); ?></p>
    <p><?php _e('For Example: If a plugin is installed in path <strong>/wp-content/plugins/some-plugin/</strong> then and JavaScripts contained within this path will be excluded. If the plugin loads a JavaScript which is countained elsewhere then the Global Method will be used (ie async or defer)', 'asyncjs'); ?></p>
    <p><label><?php _e('Exclusions: ', 'asyncjs'); ?></label>
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
    $output .= '<p>'.__('No plugins found.', 'asyncjs').'</p>';
}
echo $output;
?>
</p>
</div>
<div class="asItemDetail">
    <h3><?php _e('Theme Exclusions', 'asyncjs'); ?></h3>
    <p><?php _e('Please select one or more themes. Scripts contained within the theme will not have async / defer applied.', 'asyncjs'); ?></p>
    <p><?php _e('<strong><em>Please Note:</em></strong> This will exclude any JavaScript files which are contained within the files of the selected Theme(s). External JavaScripts loaded by the selected Theme(s) are not affected.', 'asyncjs'); ?></p>
    <p><?php _e('For Example: If a theme is installed in path <strong>/wp-content/themes/some-theme/</strong> then and JavaScripts contained within this path will be excluded. If the theme loads a JavaScript which is countained elsewhere then the Global Method will be used (ie async or defer)', 'asyncjs'); ?></p>
    <p>
        <label><?php _e('Exclusions:', 'asyncjs'); ?> </label>
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
            $output .= '<p>'. __('No themes found.', 'asyncjs').'</p>';
        }
        echo $output;
        ?>
    </p>
</div>
<div class="asItemDetail">
    <h3><?php echo AJ_TITLE; ?> <?php _e('For Plugins', 'asyncjs'); ?></h3>
    <p><?php _e('Although not recommended, some themes / plugins can load JavaScript files without using the <strong><a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts" target="_blank">wp_enqueue_script</a></strong> function.  In some cases this is necessary for the functionality of the theme / plugin.', 'asyncjs'); ?></p>
    <p><?php _e('If these themes / plugins provide a hook that can be used to manipulate how the JavaScript file is loaded then <?php echo AJ_TITLE; ?> may be able to provide support for these themes / plugins.', 'asyncjs'); ?></p>
    <p><?php _e('If you have any active themes / plugins that <?php echo AJ_TITLE; ?> supports then these will be listed below.', 'asyncjs'); ?></p>
    <p><?php _e('If you think you have found a plugin that <?php echo AJ_TITLE; ?> may be able to provide support for please lodge a ticket at <a href="https://wordpress.org/support/plugin/async-javascript" target="_blank">https://wordpress.org/support/plugin/async-javascript</a>', 'asyncjs'); ?></p>
        <?php
        if (is_plugin_active('autoptimize/autoptimize.php') || is_plugin_active('autoptimize-beta/autoptimize.php')) {
                ?>
                <div class="aj_plugin">
                        <h4><?php _e('Plugin: Autoptimize', 'asyncjs'); ?></h4>
                        <p><a href="https://wordpress.org/plugins/autoptimize/" target="_blank">https://wordpress.org/plugins/autoptimize/</a></p>
                        <p>
                            <label><?php _e('Enable Autoptimize Support:', 'asyncjs'); ?> </label>
                            <input type="checkbox" id="aj_autoptimize_enabled" value="1" <?php echo $aj_autoptimize_enabled_checked; ?> />
                        </p>
                        <p>
                            <label><?php _e('jQuery Method:', 'asyncjs'); ?> </label>
                            <input type="radio" name="aj_autoptimize_method" value="async" <?php echo $aj_autoptimize_async; ?> /> Async <input type="radio" name="aj_autoptimize_method" value="defer" <?php echo $aj_autoptimize_defer; ?> /> Defer
                        </p>
                </div>
                <?php
            }
        ?>
</div>
<p>
    <button data-id="aj_save_settings" class="aj_steps_button button"><?php _e('Save Settings', 'asyncjs'); ?></button>
</p>
