<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
 * Frontend logic: add script attribute & change Autoptimize JS attrib if applicable
 */

class AsyncJavaScriptFrontend {
    function __construct() {
        add_filter( 'script_loader_tag', array( $this, 'aj_async_js' ), 20, 3 );
        add_filter( 'autoptimize_filter_js_defer', array( $this, 'aj_autoptimize_defer' ), 11 );
    }

    /**
     * the plugin instance
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
     *  aj_async_js()
     *
     *  Main frontend function; adds 'async' or 'defer' attribute to '<script>' tasks called
     *  via wp_enqueue_script using the 'script_loader_tag' filter
     *
     */
    public function aj_async_js( $tag, $handle, $src ) {
    	if ( isset( $_GET['aj_simulate'] ) ) {
            $aj_enabled = true;
            $aj_method = sanitize_text_field( $_GET['aj_simulate'] );
            if ( $aj_method !== 'async' && $aj_method !== 'defer' ) {
                $aj_method = 'async';
            }
            if ( isset( $_GET['aj_simulate_jquery'] ) ) {
                    $aj_jquery = sanitize_text_field( $_GET['aj_simulate_jquery'] );
            } else {
                    $aj_jquery = $aj_method;
            }
            $array_exclusions = array();
            $array_async = array();
            $array_defer = array();
            $aj_plugin_exclusions = array();
            $aj_theme_exclusions = array();
        } else {
            $aj_enabled = ( get_option( 'aj_enabled', 0 ) == 1 ) ? true : false;
            $aj_method = ( get_option( 'aj_method', 'async' ) == 'async' ) ? 'async' : 'defer';
            $aj_jquery = get_option( 'aj_jquery', 'async' );
            $aj_jquery = ( $aj_jquery == 'same ' ) ? $aj_method : $aj_jquery;
            $aj_exclusions = get_option( 'aj_exclusions', '' );
            $array_exclusions = ( $aj_exclusions != '' ) ? explode( ',', $aj_exclusions ) : array();
            $aj_async = get_option( 'aj_async', '' );
            $array_async = ( $aj_async != '' ) ? explode( ',', $aj_async ) : array();
            $aj_defer = get_option( 'aj_defer', '' );
            $array_defer = ( $aj_defer != '' ) ? explode( ',', $aj_defer ) : array();
            $aj_plugin_exclusions = get_option( 'aj_plugin_exclusions', array() );
            $aj_theme_exclusions = get_option( 'aj_theme_exclusions', array() );
        }
        if ( false !== $aj_enabled && false !== $this->aj_shop() && false !== $this->aj_logged() && false === is_admin() && false === $this->aj_is_amp() && false === $this->aj_noptimize() ) {
            if ( is_array( $aj_plugin_exclusions ) && !empty( $aj_plugin_exclusions ) ) {
                foreach ( $aj_plugin_exclusions as $aj_plugin_exclusion ) {
                	$aj_plugin_exclusion = trim( $aj_plugin_exclusion );
                	if ( !empty( $aj_plugin_exclusion ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $aj_plugin_exclusion ) ) ) {
	                        return $tag;
	                    }
                    }
                }
            }
            if ( is_array( $aj_theme_exclusions ) && !empty( $aj_theme_exclusions ) ) {
                foreach ( $aj_theme_exclusions as $aj_theme_exclusion ) {
                	$aj_theme_exclusion = trim( $aj_theme_exclusion );
                	if ( !empty( $aj_theme_exclusion ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $aj_theme_exclusion ) ) ) {
	                        return $tag;
	                    }
					}
                }
            }
            if ( is_array( $array_exclusions ) && !empty( $array_exclusions ) ) {
                foreach ( $array_exclusions as $exclusion ) {
                	$exclusion = trim( $exclusion );
                	if ( !empty( $exclusion ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $exclusion ) ) ) {
	                        return $tag;
	                    }
					}
                }
            }
            if ( false !== strpos( strtolower( $src ), 'js/jquery/jquery.js' ) ) {
                if ( $aj_jquery == 'async' || $aj_jquery == 'defer' ) {
                        $tag = str_replace( 'src=', $aj_jquery . "='" . $aj_jquery . "' src=", $tag );
                return $tag;
                } else if ( $aj_jquery == 'exclude' ) {
                        return $tag;
                }
            }
            if ( is_array( $array_async ) && !empty( $array_async ) ) {
                foreach ( $array_async as $async ) {
                	$async = trim( $async );
					if ( !empty( $async ) ) {
	                    if ( false !== strpos( strtolower( $src ), strtolower( $async ) ) ) {
	                    	return str_replace( 'src=', "async='async' src=", $tag );
	                    }
					}
                }
            }
            if ( is_array( $array_defer ) && !empty( $array_defer ) ) {
                foreach ( $array_defer as $defer ) {
                	$defer = trim( $defer );
                	if ( !empty( $defer ) ) {
                    	if ( false !== strpos( strtolower( $src ), strtolower( $defer ) ) ) {
							return str_replace( 'src=', "defer='defer' src=", $tag );
	                    }
					}
                }
            }
			$tag = str_replace( 'src=', $aj_method . "='" . $aj_method . "' src=", $tag );
            return $tag;
        }
        return $tag;
    }

    /**
     *  aj_autoptimize_defer()
     *
     *  Adds support for Autoptimize plugin.  Adds 'async' attribute to '<script>' tasks called via autoptimize_filter_js_defer filter
     *  Autoptimize: https://wordpress.org/plugins/autoptimize/
     *
     */
    public function aj_autoptimize_defer( $defer ) {
        $aj_enabled = ( get_option( 'aj_enabled', 0 ) == 1 ) ? true : false;
	    $aj_method = ( get_option( 'aj_method', 'async' ) == 'async' ) ? 'async' : 'defer';
	    $aj_autoptimize_enabled = ( get_option( 'aj_autoptimize_enabled', 0 ) == 1 ) ? true : false;
		$aj_autoptimize_method = ( get_option( 'aj_autoptimize_method', 'async' ) == 'async' ) ? 'async' : 'defer';
	    if ( false !== $aj_enabled && false === is_admin() ) {
	        if ( false !== $aj_autoptimize_enabled ) {
	            return " " . $aj_autoptimize_method . "='" . $aj_autoptimize_method . "' ";
	        }
	    }
        return $defer;
    }
    
    /**
     * Returns true if given current page is AMP.
     *
     * @return bool
     */
    public static function aj_is_amp()
    {
        if ( !function_exists('is_amp_endpoint') || !is_amp_endpoint() ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Returns true if aj_noptimize=1 was found in URL.
     *
     * @return bool
     */
    public static function aj_noptimize()
    {
        $key = 'aj_noptimize';
        if ( array_key_exists( $key, $_GET ) && '1' === $_GET[ $key ] ) {
            $aj_noptimize = true;
        } else {
            $aj_noptimize = false;
        }
        $aj_noptimize = (bool) apply_filters( 'asyncjs_filter_noptimize', $aj_noptimize );
        return $aj_noptimize;
    }

    /**
     * Returns false if user is logged on and option was set to
     * not async for logged on users, return true otherwise.
     *
     * @return bool
     */
    public static function aj_logged()
    {
        static $_do_logged = null;

        if ( is_null( $_do_logged ) ) {
            $aj_enabled_logged = get_option( 'aj_enabled_logged', 0 );
            if ( $aj_enabled_logged == 1 ) {
                $_do_logged = true;
            } else if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
                $_do_logged = false;
            } else {
                $_do_logged = true;
            }
        }

        return $_do_logged;
    }

    /**
     * Returns false if user is on shop checkout/ cart page
     * and option to async shop was not set, return true otherwise.
     *
     * @return bool
     */

    public static function aj_shop()
    {
        static $_do_shop = null;

        if ( is_null( $_do_shop ) ) {
            $aj_enabled_shop = get_option( 'aj_enabled_shop', 0 );
            $_do_shop = true;
            if ( $aj_enabled_shop != 1 ) {
                // Checking for woocommerce, easy digital downloads and wp ecommerce...
                foreach ( array( 'is_checkout', 'is_cart', 'edd_is_checkout', 'wpsc_is_cart', 'wpsc_is_checkout' ) as $func ) {
                    if ( function_exists( $func ) && $func() ) {
                        $_do_shop = false;
                        break;
                    }
                }
            }
        }

        return $_do_shop;
    }
}
