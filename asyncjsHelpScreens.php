<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="asItemDetail">
    <h3><?php echo AJ_TITLE; ?></h3>
    <?php echo $this->about_aj(); ?>
</div>
<div class="asItemDetail">
<h3><?php _e('Help &amp; Support', 'async-javascript'); ?></h3>
<p><strong><?php _e('Installed Version: ', 'async-javascript'); ?></strong><?php echo AJ_VERSION; ?></p>
<p><?php _e('Below are some answers to some frequently asked questions about ', 'async-javascript'); ?> <?php echo AJ_TITLE; ?></p>
</div>
<div class="asItemDetail">
<h3><?php _e("Which browsers support the 'async' and 'defer' attributes?", 'async-javascript'); ?></h3>
<p><?php _e("The 'async' attribute is new in HTML5. It is supported by the following browsers:", 'async-javascript'); ?></p>
<ul>
    <li>Chrome</li>
    <li>IE 10 <?php _e('and higher', 'async-javascript'); ?></li>
    <li>Firefox 3.6 <?php _e('and higher', 'async-javascript'); ?></li>
    <li>Safari</li>
    <li>Opera</li>
</ul>
</div>
<div class="asItemDetail">
<h3><?php _e('Where can I get help?', 'async-javascript'); ?></h3>
<p><?php echo AJ_TITLE; ?> <?php _e('is supported exclusively via the wordpress.org support forum', 'async-javascript'); ?> <a href="https://wordpress.org/support/plugin/async-javascript" target="_blank">https://wordpress.org/support/plugin/async-javascript</a></p>
</div>
<div class="asItemDetail">
<h3><?php _e('Do you provide premium support (configuration) or performance optimization services?', 'async-javascript'); ?></h3>
<p><?php _e('We offer premium services for Async JavaScript and also perform full web performance optimization services. More info at ', 'async-javascript'); ?><a href="https://autoptimize.com/?utm=asyncjs" target="_blank">https://autoptimize.com/</a></p>
</div>
<div class="asItemDetail">
<h3><?php _e('What about CSS?', 'async-javascript'); ?></h3>
<p><?php _e('As the name implies, Async JavaScript is built to enhance JavaScript loading only. Async JavaScript does not have any impact on CSS.', 'async-javascript'); ?></p>
<p><?php _e('We recommend using the awesome <a href="https://wordpress.org/plugins/autoptimize/" target="_blank">Autoptimize</a> plugin alongside Async JavaScript for CSS optimization.', 'async-javascript'); ?></p>
</div>
<div class="asItemDetail">
<h3><?php _e('I want out, how should I remove Async JavaScript?', 'async-javascript'); ?></h3>
<ul>
    <li><?php _e('Disable the plugin', 'async-javascript'); ?></li>
    <li><?php _e('Delete the plugin', 'async-javascript'); ?></li>
</ul>
</div>
<div class="asItemDetail">
    <?php echo $this->hints_tips(); ?>
</div>
