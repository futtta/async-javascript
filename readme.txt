=== Async JavaScript ===
Contributors: (cloughit), optimizingmatters, futtta
Donate link: http://blog.futtta.be/2013/10/21/do-not-donate-to-me/
Tags: async,javascript,pagespeed,performance,render blocking
Requires at least: 4.4
Tested up to: 4.9
Stable tag: 2018.03.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Async Javascript gives you lets you add 'async' or 'defer' attribute to scripts to exclude to help increase the performance of your WordPress website.

== Description ==
Eliminate Render-blocking Javascript in above-the-fold content with Async Javascript.

Render-blocking Javascript prevents above-the-fold content on your page from being rendered until the javascript has finished loading.  This can impact on your page speed and ultimately your ranking within search engines.  It can also impact your users experience.

Async JavaScript gives you full control of which scripts to add a 'async' or 'defer' attribute to or to exclude to help increase the performance of your WordPress website

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

== Screenshots ==

Coming soon!

== Changelog ==

= 2018.03.10 =
* ASync JS is now maintained by Frank Goossens (Optimizing Matters), thanks for the great job done David!
* Moved all Pro features into the standard version.

= 2017.11.15 =

* MOD: Added User Agent to GTMetrix requests

= 2017.11.03 =

* MOD: Check for GTMetrix class existance prior to including class

= 2017.10.18 =

* FIX: Issue converting array for plugin & theme exclusions

= 2017.09.30 =

* FIX: Sanitise all $_GET and all $_POST
* FIX: Add nonce to ajax calls

= 2017.06.13 =

* MOD: Dashboard Widget and Notices only available to Administrators

= 2017.05.08 =

* NEW: Added quick settings buttons to allow common settings to be quickly applied
* NEW: Added current version info to help page

= 2017.05.07 =

* FIX: Some installs not saving plugin / theme exclusions due to theme incompatibility

= 2017.05.06 =

* MOD/FIX: On some WordPress installs is_plugin_active function being called too early. Moved is_plugin_active into dedicated function called via admin_init as per codex: https://codex.wordpress.org/Function_Reference/is_plugin_active

= 2017.05.05 =

* FIX: Incorrect textarea identifier preventing exclusion save

= 2017.05.04 =

* FIX: Resolve early loading of plugin causing fatal error due to function not available yet
* FIX: CSS / JS not loading

= 2017.05.03 =

* MOD: Add test to advise running Wizard is not mandatory

= 2017.05.01 =

* massive Massive MASSIVE rewrite of Async JavaScript!!!
* Now includes a setup Wizard, Status page, Settings page and a help page.
* Communicates directly with GTmetrix (account required)
* Automaticall transfers existing settings from Async JavaScript to Async JavaScript

= 2017.01.14 =

* FIX: Update plugin updater to address possible issue in PHP7

= 2016.12.29 =

* MOD: Updated readme with clearer instructions on how to find settings menu in admin

= 2016.09.30 =

* MOD: Better detection of jQuery core file

= 2016.08.17 =

* FIX: Typo in variable name

= 2016.08.15 =

* NEW: Select jQuery handler
* NEW: Select Autoptimize handler
* NEW: Ability to exclude Themes

= 2016.07.04 =

* MOD: Add check for null input for exclusions
* FIX: Undefined variable

= 2016.06.26 =

* FIX: Plugin exclusions not populating correctly for plugins without a TextDomain defined

= 2016.06.22 =

* FIX: Settings being wiped on other tabs on save
* MOD: Removed licencing due to host blocking a high number of IP's listed as Blacklisted
* MOD: Moved menu item to Settings menu
* MOD: Fixed spelling of 'JavaScript' to 'JavaScript'

= 2016.04.18 =

* MOD: adjust code to remove php notice

= 2016.04.14 =

* MOD: adjust code to remove php notice
* MOD: use CURL for licence query or fallback if CURL not available
* MOD: better debugging

= 2016.03.22 =

* FIX: wp-WP_Error error.

= 2016.03.21 =

* FIX: Re-enabled licence check, reported issue found to be originating website error not licence server error.
* NEW: Added information regarding purpose of licence.
* NEW: If communication with the licence server fails the error will be displayed for troubleshooting purposes.

= 2016.03.18 =

* BUG: Disabled licence check as some websites were unable to communicate with licence server. To be resolved in future release.

= 2016.02.15 =

* NEW: Added Plugin Exclusion

= 2016.02.08 =

* NEW: Added Plugin Update Logic

= 2016.01.14 =

* MOD: Updated instructional text for plugins

= 2016.01.13 =

* Genesis
