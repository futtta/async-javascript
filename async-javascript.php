<?php
/**
 * Plugin Name: Async JavaScript
 * Plugin URI: https://autoptimize.com/
 * Description: Async JavaScript gives you full control of which scripts to add a 'async' or 'defer' attribute to or to exclude to help increase the performance of your WordPress website
 * Version: 2.20.12.09
 * Author: Frank Goossens (futtta)
 * Author URI: https://autoptimize.com/
 * Text Domain: async-javascript
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (is_admin()) {
    require_once('asyncjsBackendClass.php');
    $ajBackend = new AsyncJavaScriptBackend();
} else {
    require_once('asyncjsFrontendClass.php');
    $ajFrontend = new AsyncJavaScriptFrontend();
}
