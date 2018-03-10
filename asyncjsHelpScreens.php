<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<table class="form-table" width="100%" cellpadding="10">
    <tr>
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/stick_figure_panicking_150_clr_13267.gif" title="Help &amp; Support" alt="Help &amp; Support"  class="aj_step_img"></td>
        <td scope="row" align="left" style="vertical-align: top !important;">
            <h3>Help &amp; Support</h3>
            <p style="font-size: 0.7em;"><strong>Installed Version: </strong><?php echo AJ_VERSION; ?></p>
            <p>Below are some answers to some frequently asked questions about <?php echo AJ_TITLE; ?></p>
            <hr />
            <h3>Which browsers support the 'async' and 'defer' attributes?</h3>
            <p>The 'async' attribute is new in HTML5. It is supported by the following browsers:</p>
            <ul>
                <li>Chrome</li>
                <li>IE 10 and higher</li>
                <li>Firefox 3.6 and higher</li>
                <li>Safari</li>
                <li>Opera</li>
            </ul>
            <hr />
            <h3>Where can I get help?</h3>
            <p><?php echo AJ_TITLE; ?> is supported exclusively via the wordpress.org support forum <a href="https://wordpress.org/support/plugin/async-javascript" target="_blank">https://wordpress.org/support/plugin/async-javascript</a></p>
            <hr />
            <h3>Do you provide premium support (configuration) or performance optimization services?</h3>
            <p>We offer premium services (<?php echo AJ_TITLE; ?> but also full web performance optimization services) at <a href="https://autoptimize.com/?utm=asyncjs" target="_blank">https://autoptimize.com/</a></p>
            <hr />
            <h3>What about CSS?</h3>
            <p>As the name implies, <?php echo AJ_TITLE; ?> is built to enhance JavaScript loading only. <?php echo AJ_TITLE; ?> does not have any impact on CSS.</p>
            <p>We recommend using the awesome <a href="https://wordpress.org/plugins/autoptimize/" target="_blank">Autoptimize</a> plugin alongside <?php echo AJ_TITLE; ?> for CSS optimization.</p>
            <hr />
            <h3>I want out, how should I remove <?php echo AJ_TITLE; ?>?</h3>
            <ul>
                <li>Disable the plugin</li>
                <li>Delete the plugin</li>
            </ul>
        </td>
    </tr>
</table>
<?php
