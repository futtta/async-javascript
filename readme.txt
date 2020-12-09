=== Async JavaScript ===
Contributors: (cloughit), optimizingmatters, futtta, wormeyman
Donate link: http://blog.futtta.be/2013/10/21/do-not-donate-to-me/
Tags: async, javascript, pagespeed, performance, render blocking
Requires at least: 4.6
Tested up to: 5.6
Stable tag: 2.20.12.09
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Async Javascript lets you add 'async' or 'defer' attribute to scripts to exclude to help increase the performance of your WordPress website.

== Description ==
Eliminate Render-blocking Javascript in above-the-fold content with Async Javascript.

Render-blocking Javascript prevents above-the-fold content on your page from being rendered until the javascript has finished loading. This can impact on your page speed and ultimately your ranking within search engines. It can also impact your user's experience.

Async JavaScript gives you full control of which scripts to add an 'async' or 'defer' attribute to or to exclude to help increase the performance of your WordPress website.

== Installation ==
Installation is very straightforward:

1. Upload the zip-file and unzip it in the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to `Settings` > `Async JavaScript` menu to load settings page

== Frequently Asked Questions ==

= Which browsers support the 'async' and 'defer' attributes =

The 'async' attribute is new in HTML5. It is supported by the following browsers:

* Chrome
* IE 10 and higher
* Firefox 3.6 and higher
* Safari
* Opera

= Where can I get help? =

Async JavaScript is supported via [the wordpress.org support forum](https://wordpress.org/support/plugin/async-javascript).

= Do you offer professional support/ configuration services? =

We offer premium services for Async JavaScript and full web performance optimization services at [https://autoptimize.com/](https://autoptimize.com/?utm=asyncjs)

= What about CSS? =

As the name implies, Async JavaScript is built to enhance JavaScript loading only. Async JavaScript does not have any impact on CSS.

We recommend using the awesome <a href="https://wordpress.org/plugins/autoptimize/">Autoptimize</a> plugin alongside Async JavaScript for CSS optimization.

= I want out, how should I remove Async JavaScript? =

* Disable the plugin
* Delete the plugin

== Changelog ==

= 2.20.12.09 =

* fix for some ternary operators warning in PHP 7.4 and up.
* hard-exclude document.write (WordPress core injects inline JS that has `<script src` in it which AsyncJS acted on)
* fix for WordPress 5.6 renaming jQuery from jquery.js into jquery.min.js

= 2.20.03.01 =

* extra security measure; check the nonce when saving settings/ going through wizard.
* wizard: if something fails then communicate this onscreen instead of on the console.
* autoptimize integration: change copy to explain this might or might not be helpful.

= 2.20.02.27 =

* fix for some nasty issues, thanks for the heads-up Mikey

= 2.19.07.14 =

* add `asyncjs_filter_noptimize` filter
* changed textdomain to match slug as suggested by Eneko Garrido
* confirmed working with WordPress 5.2

= 2.18.12.10 =

* the "happy birthday to me" edition ;-)
* new: added option to disable Async JS for logged in users
* new: added option to disable Async JS on shop cart/ checkout pages (woocommerce, edd & wp ecommerce)
* added 'settings'-link to plugin overview screen (hi Mike!)
* updated the [chosen JS library](https://harvesthq.github.io/chosen/) to 1.8.7
* confirmed working with WordPress 5.0

= 2.18.06.13 =

* fix integration issue with Autoptimize, thx [for reporting](https://wordpress.org/support/topic/autoptimize-and-async-javascript/) ElephantDude!

= 2.18.05.24 =

* don't async (or defer) on AMP-pages
* disable async/ defer by when `?aj_noptimize=1` is part of  the URL

= 2.18.04.23 =

* Re-arrange content on the different tabs of the settings page.
* Continued refactoring of backend code, no functionality should be affected.
* Remove all images from the project such as the animated hands and progress bar gif.
* Remove empty rows that added unnecessary space.
* Switch buttons to use WordPress button styles.
* Fix broken Dashboard Widget from 2.18.03.15 and reduce font-size to fix text overflow.
* Remove all CSS !important declarations for easier CSS styling.
* Remove inline CSS styles.
* Switch to a CSS based progress bar.
* Spell check readme.
* Remove almost all tables from files.
* Refactor JavaScript.
* Add wormeyman as a contributor (thanks man!).

= 2.18.03.15 =

* bugfix: only load asyncjs' JS & CSS on own settings page [as reported by Marat Petrov](https://wordpress.org/support/topic/error-after-update-117/)
* bugfix: check if jQuery chosen is correctly loaded before using it (based on same report, thanks Marat!)
* update jQuery Chosen lib
* small readme tweaks

= 2.18.03.10 =

* ASync JS is now maintained by Frank Goossens (Optimizing Matters), thanks for the great job done David!
* Moved all Pro features into the standard version.
* Some code refactoring
* Made strings ready for translations

= 2.17.11.15 =

* MOD: Added User Agent to GTMetrix requests

= 2.17.11.03 =

* MOD: Check for GTMetrix class existence prior to including class

= 2.17.10.18 =

* FIX: Issue converting array for plugin & theme exclusions

= 2.17.09.30 =

* FIX: Sanitise all $_GET and all $_POST
* FIX: Add nonce to ajax calls

= 2.17.06.13 =

* MOD: Dashboard Widget and Notices only available to Administrators

= 2.17.05.08 =

* NEW: Added quick settings buttons to allow common settings to be quickly applied
* NEW: Added current version info to help page

= 2.17.05.07 =

* FIX: Some installs not saving plugin/theme exclusions due to theme incompatibility

= 2.17.05.06 =

* MOD/FIX: On some WordPress installs is_plugin_active function being called too early. Moved is_plugin_active into a dedicated function called via admin_init as per codex: https://codex.wordpress.org/Function_Reference/is_plugin_active

= 2.17.05.05 =

* FIX: Incorrect textarea identifier preventing exclusion save

= 2.17.05.04 =

* FIX: Resolve early loading of plugin causing a fatal error due to function not available yet
* FIX: CSS / JS not loading

= 2.17.05.03 =

* MOD: Add text to advise running Wizard is not mandatory

= 2.17.05.01 =

* massive Massive MASSIVE rewrite of Async JavaScript!!!
* Now includes a Setup Wizard, Status page, Settings page and a help page.
* Communicates directly with GTmetrix (account required)
* Automatically transfers existing settings from Async JavaScript to Async JavaScript
