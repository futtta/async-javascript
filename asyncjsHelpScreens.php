<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<table class="form-table" width="100%" cellpadding="10">
    <tr>
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/stick_figure_panicking_150_clr_13267.gif" title="Help &amp; Support" alt="Help &amp; Support"  class="aj_step_img"></td>
        <td scope="row" align="left" style="vertical-align: top !important;">
            <h3><?php _e('Help &amp; Support','asyncjs'); ?></h3>
            <p style="font-size: 0.7em;"><strong><?php _e('Installed Version: ','asyncjs'); ?></strong><?php echo AJ_VERSION; ?></p>
            <p><?php _e('Below are some answers to some frequently asked questions about ','asyncjs'); ?> <?php echo AJ_TITLE; ?></p>
            <hr />
            <h3><?php _e("Which browsers support the 'async' and 'defer' attributes?",'asyncjs'); ?></h3>
            <p><?php _e("The 'async' attribute is new in HTML5. It is supported by the following browsers:",'asyncjs'); ?></p>
            <ul>
                <li>Chrome</li>
                <li>IE 10 <?php _e('and higher','asyncjs'); ?></li>
                <li>Firefox 3.6 <?php _e('and higher','asyncjs'); ?></li>
                <li>Safari</li>
                <li>Opera</li>
            </ul>
            <hr />
            <h3><?php _e('Where can I get help?','asyncjs'); ?></h3>
            <p><?php echo AJ_TITLE; ?> <?php _e('is supported exclusively via the wordpress.org support forum','asyncjs'); ?> <a href="https://wordpress.org/support/plugin/async-javascript" target="_blank">https://wordpress.org/support/plugin/async-javascript</a></p>
            <hr />
            <h3><?php _e('Do you provide premium support (configuration) or performance optimization services?','asyncjs'); ?></h3>
            <p><?php _e('We offer premium services for Async JavaScript and also perform full web performance optimization services. More info at ','asyncjs'); ?><a href="https://autoptimize.com/?utm=asyncjs" target="_blank">https://autoptimize.com/</a></p>
            <hr />
            <h3><?php _e('What about CSS?','asyncjs'); ?></h3>
            <p><?php _e('As the name implies, Async JavaScript is built to enhance JavaScript loading only. Async JavaScript does not have any impact on CSS.','asyncjs'); ?></p>
            <p><?php _e('We recommend using the awesome <a href="https://wordpress.org/plugins/autoptimize/" target="_blank">Autoptimize</a> plugin alongside Async JavaScript for CSS optimization.','asyncjs'); ?></p>
            <hr />
            <h3><?php _e('I want out, how should I remove Async JavaScript?','asyncjs'); ?></h3>
            <ul>
                <li><?php _e('Disable the plugin','asyncjs'); ?></li>
                <li><?php _e('Delete the plugin','asyncjs'); ?></li>
            </ul>
        </td>
    </tr>
</table>
<?php
