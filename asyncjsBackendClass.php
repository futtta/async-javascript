<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
 * Backend logic: kicking in admin logic, screens & Ajax
 *
 */

class AsyncJavaScriptBackend {
    function __construct() {
        define( 'AJ_TITLE', 'Async JavaScript' );
        define( 'AJ_ADMIN_MENU_SLUG', 'async-javascript' );
        define( 'AJ_ADMIN_ICON_URL', 'dashicons-performance' );
        define( 'AJ_ADMIN_POSITION', 3 );
        define( 'AJ_ADMIN_URL', trailingslashit( admin_url() ) );
        define( 'AJ_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
        define( 'AJ_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'AJ_VERSION', '3.18.04.23' );
        define( 'AJ_UA', 'Async JavaScript/' . AJ_VERSION . ' (+https://autoptimize.com/)' );
        add_action( 'plugins_loaded', array( $this, 'aj_admin_init' ) );
        add_action( 'admin_init', array( $this, 'aj_disable_pro' ) );
    }

    /**
     * the plugin instance
     *
     */
    private static $instance = NULL;

    /**
     * get the plugin instance
     *
     * @return AsyncJavaScript
     */
    public static function get_instance() {
        if ( NULL === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * aj_activate()
     *
     */
    public static function aj_activate() {

    }

    /**
     * plugin deactivate
     *
     */
    public static function aj_deactivate() {

    }

    /**
     * plugin uninstaller
     *
     * removes (hopefully all) options
     *
     */
    public static function aj_uninstall() {
        $optionsToRemove = array('aj_async','aj_autoptimize_enabled','aj_autoptimize_method','aj_defer','aj_enabled','aj_exclusions','aj_gtmetrix_api_key','aj_gtmetrix_results','aj_gtmetrix_server','aj_gtmetrix_username','aj_jquery','aj_method','aj_plugin_exclusions','aj_theme_exclusions','aj_version');
        if ( !is_multisite() ) {
            foreach ($delete_options as $del_opt) { delete_option( $del_opt ); }
        } else {
            global $wpdb;
            $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
            $original_blog_id = get_current_blog_id();
            foreach ( $blog_ids as $blog_id ) {
                switch_to_blog( $blog_id );
                foreach ($delete_options as $del_opt) { delete_option( $del_opt ); }
            }
            switch_to_blog( $original_blog_id );
        }
    }

    /**
     *  aj_enqueue_scripts()
     *
     *  register admin stylesheets and javascripts
     *
     */
    public function aj_enqueue_scripts() {
        // chosen
        wp_enqueue_style('chosen', plugins_url( 'assets/lib/chosen/chosen.min.css', __FILE__ ));
        wp_enqueue_script('chosen', plugins_url( 'assets/lib/chosen/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), AJ_VERSION, true);

        // own JS & CSS
        wp_enqueue_style('aj_admin_styles', plugins_url( '/css/admin.min.css', __FILE__ ));
    	wp_enqueue_script('aj_admin_scripts',plugins_url( '/js/admin.min.js', __FILE__ ),array( 'jquery', 'chosen' ), AJ_VERSION, true);

        // ajaxy stuff
        $aj_localize = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'siteurl' => get_site_url(),
            'pluginurl' => AJ_PLUGIN_URL,
            'ajadminurl' => admin_url( 'options-general.php?page=async-javascript' )
        );
        wp_localize_script( 'aj_admin_scripts', 'aj_localize_admin', $aj_localize );
    }

    /**
    *  aj_disable_pro()
    *
    *  check if the old AJS_pro is active and deactivate if so
    *
    */
    public function aj_disable_pro() {
        if ( is_plugin_active( 'async-javascript-pro/async-javascript-pro.php' ) ) {
            deactivate_plugins( array( 'async-javascript-pro/async-javascript-pro.php' ) );
        }
    }

    /**
    *  aj_admin_init()
    *
    *  register admin stylesheets and javascripts
    *
    */
    public function aj_admin_init() {
        global $wp, $wpdb;
        register_activation_hook( __FILE__, array( $this, 'aj_activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'aj_deactivate' ) );

        if ( !class_exists( 'Services_WTF_Test' ) ) {
            require_once( AJ_PLUGIN_DIR . 'lib/gtmetrix/class.Services_WTF_Test.php' );
        }

        // check if upgrading from early release so settings can be transferred
        $aj_version = get_option( 'aj_version', '' );
        if ( $aj_version == '' || $aj_version < '2017.04.25' ) {
            $aj_enabled = get_option( 'aj_enabled', 0 );
            $aj_method = get_option( 'aj_method', 'async' );
            $aj_jquery = ( get_option( 'aj_jquery', 'async' ) == 'same' ) ? $aj_method : get_option( 'aj_jquery', 'async' );
            $aj_async = get_option( 'aj_async', '' );
            $aj_defer = get_option( 'aj_defer', '' );
            $aj_exclusions = get_option( 'aj_exclusions', '' );
            $aj_plugin_exclusions = ( is_array( get_option( 'aj_plugin_exclusions', array() ) ) && !is_null( get_option( 'aj_plugin_exclusions', array() ) ) ? get_option( 'aj_plugin_exclusions', array() ) : explode( ',', get_option( 'aj_plugin_exclusions', '' ) ) );
            $aj_theme_exclusions = ( is_array( get_option( 'aj_theme_exclusions', array() ) ) && !is_null( get_option( 'aj_theme_exclusions', array() ) ) ? get_option( 'aj_theme_exclusions', array() ) : explode( ',', get_option( 'aj_theme_exclusions', '' ) ) );
            $aj_autoptimize_enabled = get_option( 'aj_autoptimize_enabled', 0 );
            $aj_autoptimize_method = get_option( 'aj_autoptimize_method', 'async' );
            update_option( 'aj_enabled', $aj_enabled );
            update_option( 'aj_method', $aj_method );
            update_option( 'aj_jquery', $aj_jquery );
            update_option( 'aj_async', $aj_async );
            update_option( 'aj_defer', $aj_defer );
            update_option( 'aj_exclusions', $aj_exclusions );
            update_option( 'aj_plugin_exclusions', $aj_plugin_exclusions );
            update_option( 'aj_theme_exclusions', $aj_theme_exclusions );
            update_option( 'aj_autoptimize_enabled', $aj_autoptimize_enabled );
            update_option( 'aj_autoptimize_method', $aj_autoptimize_method );
        }

        if ( $aj_version != AJ_VERSION ) {
            update_option( 'aj_version', AJ_VERSION );
        }

        add_action( 'wp_dashboard_setup', array( $this, 'register_aj_dashboard_widget' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'aj_enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'async_javascript_menu' ) );
        add_action( 'wp_ajax_aj_steps', array( $this, 'aj_steps' ) );
        add_action( 'admin_notices', array( $this, 'aj_admin_notice' ) );
    }

	/**
	 *  register_aj_dashboard_widget()
	 *
	 *  Register dashboard widget
	 *
	 */
	public function register_aj_dashboard_widget() {
        if ( current_user_can( 'manage_options' ) ) {
            global $wp_meta_boxes;
            wp_add_dashboard_widget(
                    'aj_dashboard_widget',
                    AJ_TITLE,
                    array( $this, 'aj_dashboard_widget' )
            );
            $dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
            $aj_widget = array( 'aj_dashboard_widget' => $dashboard['aj_dashboard_widget'] );
            unset( $dashboard['aj_dashboard_widget'] );
            $sorted_dashboard = array_merge( $aj_widget, $dashboard );
            $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
        }
	}

	/**
	 *  aj_dashboard_widget()
	 *
	 *  Dashboard widget
	 *
	 */
	public function aj_dashboard_widget() {
        require_once('asyncjsDashboardScreens.php');
	}

    /**
     *  aj_admin_notice()
     *
     *  check if async javascript (free) is active and display notice if so
     *  check if settings have been updated and display notice if so
     *
     *  @param      n/a
     *  @return     n/a
     */
    public function aj_admin_notice() {
        if ( is_plugin_active( 'async-javascript-pro/async-javascript-pro.php' ) ) {
            $class = 'update-nag';
            $message = __('We have detected that Async JavaScript Pro is still active. Please disable from the plugin menu before using ','asyncjs') . AJ_TITLE;
            echo "<div class=\"$class\">$message</div>";
        }
    }

    /**
     *  async_javascript_menu()
     *
     *  register admin menu
     *
     *  @param      n/a
     *  @return     n/a
     */
    public function async_javascript_menu() {
        $asj_page = add_submenu_page(
                'options-general.php',
                AJ_TITLE . ' Admin',
                AJ_TITLE,
                'manage_options',
                'async-javascript',
                array( $this, 'async_javascript_admin' )
        );
	add_action( 'admin_print_scripts-'.$asj_page, array( $this, 'aj_enqueue_scripts' ) );
    }

    /**
     *  async_javascript_admin()
     *
     *  admin page
     *
     *  @param      n/a
     *  @return     n/a
     */
    public function async_javascript_admin() {
    	$tabs = array( 'wizard', 'settings','status', 'help', 'Optimize More!' );
		$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field( $_GET[ 'tab' ] ) : 'settings';
        ?>
        <div class="wrap aj">
        	<input type="hidden" id="aj_nonce" value="<?php echo wp_create_nonce( "aj_nonce" ); ?>" />
        	<div id="aj_notification"></div>
	        <h2>Welcome to <?php echo AJ_TITLE; ?></h2>
	        <h2 class="nav-tab-wrapper">
	        	<?php
	        	foreach ($tabs as $tab ) {
	        		$active = $active_tab == $tab ? 'nav-tab-active' : '';
	        		echo '<a href="?page=async-javascript&tab=' . $tab . '" class="nav-tab ' . $active . '">' . ucfirst( $tab ) . '</a>';
	        	}
				?>
		    </h2>
            <?php
            if ( $active_tab == 'wizard' ) {
                require_once('asyncjsWizardScreens.php');
	        } else if ( $active_tab == 'status' ) {
                require_once('asyncjsStatusScreens.php');
            } else if ( $active_tab == 'settings' ) {
                require_once('asyncjsSettingsScreens.php');
            } else if ( $active_tab == 'help' ) {
                require('asyncjsHelpScreens.php');
            } else if ( $active_tab == 'Optimize More!' ) {
                require('asyncjsPartnersScreens.php');
            }
        ?>
        </div>
        <?php
    }

	/**
	 *  about_aj()
	 *
	 *  Return common text for about Async JavaScript
	 *
	 */
	private function about_aj() {
		$return = '';
		$return .= '<p>'.__('When a JavaScript file is loaded via the <strong><a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts" target="_blank">wp_enqueue_script</a></strong> function, ' . AJ_TITLE . ' will add an <strong>async</strong> or <strong>defer</strong> attribute.','asyncjs').'</p>';
		$return .= '<p>'.__('There are several ways an external JavaScript file can be executed:','asyncjs').'</p>';
		$return .= '<ul>';
        $return .= '<li>'.__('If <strong>async</strong> is present: The script is executed asynchronously with the rest of the page (the script will be executed while the page continues the parsing)</li>','asyncjs');
        $return .= '<li>'.__('If <strong>defer</strong> is present and <strong>async</strong> is not present: The script is executed when the page has finished parsing</li>','asyncjs');
        $return .= '<li>'.__('If neither <strong>async</strong> or <strong>defer</strong> is present: The script is fetched and executed immediately, before the browser continues parsing the page</li>','asyncjs');
		$return .= '</ul>';
		$return .= '<p>'.__('Using <strong>async</strong> or <strong>defer</strong> helps to eliminate render-blocking JavaScript in above-the-fold content.  This can also help to increase your pagespeed which in turn can assist in improving your page ranking.</p>','asyncjs');
		return $return;
	}

	/**
	 *  hints_tips()
	 *
	 *  Return common text for Hints & Tips
	 *
	 */
	private function hints_tips() {
		$return = '';
		$return .= '<h3>'.__('Further Hints &amp; Tips','asyncjs').'</h3>';
		if ( is_plugin_active( 'autoptimize/autoptimize.php' ) ) {
			$return .= '<p>' . AJ_TITLE . __(' has detected that you have Autoptimize installed and active. ','asyncjs') . AJ_TITLE . __(' can further enhance Autoptimize results by applying Async or Defer to the cache files used by Autoptimize.</p>','asyncjs');
		} else {
			$return .= '<p>' . AJ_TITLE . __(' has detected that you do not have Autoptimize installed and active.  Autoptimize can provide further optimization of JavaScript which can benefit the results of ' . AJ_TITLE . ' (and ' . AJ_TITLE . ' can also enhance Autoptimize results!)</p>','asyncjs');
			$return .= '<p>'. __('You can install Autoptimize from the plugin repository, or download it from here: ','asyncjs') .'<a href="https://wordpress.org/plugins/autoptimize/" target="_blank">https://wordpress.org/plugins/autoptimize/</a></p>';
		}
		$return .= '<p>'. __('Through our testing the following common Autoptimize settings work well to achieve the best results.  Of course each website is different so you may need to fine tune these settings to suit.</p>','asyncjs');
		$return .= '<ol>';
                $return .= '<li>'. __('Navigate to <strong>Settings &gt; Autoptimize</strong></li>','asyncjs');
                $return .= '<li>'. __('Click on the <strong>Show advanced settings</strong> button</li>','asyncjs');
                $return .= '<li>'. __('Under <strong>JavaScript Options</strong> set the following:</li>','asyncjs');
                $return .= '<ul>';
                $return .= '<li><strong>'. __('Optimize JavaScript Code?</strong>: Checked</li>','asyncjs');
                $return .= '<li><strong>'. __('Force JavaScript in &lt;head&gt;?</strong>: Unchecked</li>','asyncjs');
                $return .= '<li><strong>'. __('Also aggregate inline JS?</strong>: Checked<br />(did you need to exclude jQuery in ' . AJ_TITLE . '? Enabling this option <strong><em>MAY</em></strong> help resolve jQuery errors caused by inline JavaScript / jQuery code)</li>','asyncjs');
                $return .= '<li><strong>'. __('Exclude scripts from Autoptimize:</strong>: Leave as default (or add any other scripts that you may need to exclude)</li>','asyncjs');
                $return .= '<li><strong>'. __('Add try-catch wrapping?</strong>: Unchecked</li>','asyncjs');
                $return .= '</ul>';
                $return .= '<li>'. __('Click on the <strong>Save Changes and Empty Cache</strong> button</li>','asyncjs');
                $return .= '<li>'. __('Navigate to <strong>Settings &gt; ' . AJ_TITLE . '</strong></li>','asyncjs');
                $return .= '<li>'. __('Click on the <strong>Settings</strong> tab</li>','asyncjs');
                $return .= '<li>'. __('Scroll down to <strong>' . AJ_TITLE . ' For Plugins</strong></li>','asyncjs');
                $return .= '<li>'. __('Under <strong>Autoptimize</strong> set the following:</li>','asyncjs');
                $return .= '<ul>';
                $return .= '<li><strong>'. __('Enable Autoptimize Support</strong>: Checked</li>','asyncjs');
                $return .= '<li>'. __('<strong>Method</strong>: Select either <strong>Async</strong> or <strong>Defer</strong> (testing has found that <strong>Defer</strong> usually works best here!)</li>','asyncjs');
                $return .= '</ul>';
                $return .= '<li>'. __('Click on <strong>Save Changes</strong></li>','asyncjs');
		$return .= '</ol>';
		return $return;
	}

    /**
     *  aj_steps()
     *
     *  all things Ajax (wizard, saving settings, ...)
     *  actual code moved to external file to tidy things up a bit
     *
     */
    public function aj_steps() {
        require_once('asyncjsAllAjax.php');
    }
}
