<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
 * this file contains all AJAX backend logic
 * for the wizard and to save settings
 */

$aj_gtmetrix_results = get_option( 'aj_gtmetrix_results', array() );
if ( ! isset( $_POST['sub_action'] ) || ! current_user_can( 'manage_options' ) || ! check_ajax_referer( 'aj_nonce', 'security', false ) ) {
    $return = array(
        'status' => false,
        'error' => 'No sub action defined or security issue.'
    );
} else {
    $sub_action = sanitize_text_field( $_POST['sub_action'] );
    switch ( $sub_action ) {
        case 'aj_step2':
            $aj_gtmetrix_username = sanitize_text_field( $_POST['aj_gtmetrix_username'] );
            $aj_gtmetrix_api_key = sanitize_text_field( $_POST['aj_gtmetrix_api_key'] );
            $aj_gtmetrix_server = sanitize_text_field( $_POST['aj_gtmetrix_server'] );
            $site_url = trailingslashit( sanitize_text_field( $_POST['site_url'] ) );
            update_option( 'aj_gtmetrix_username', $aj_gtmetrix_username );
            update_option( 'aj_gtmetrix_api_key', $aj_gtmetrix_api_key );
            update_option( 'aj_gtmetrix_server', $aj_gtmetrix_server );
            $test = new Services_WTF_Test();
            $test->api_username( $aj_gtmetrix_username );
            $test->api_password( $aj_gtmetrix_api_key );
            $test->user_agent( AJ_UA );
            $args = array(
                'url' => $site_url,
                'location' => $aj_gtmetrix_server
            );
            $testid = $test->test( $args );
            if ( $testid ) {
                $test->get_results();
                if ( $test->error() ) {
                    $return = array(
                        'status' => false,
                        'error' => $test->error()
                    );
                } else {
                    $testid = $test->get_test_id();
                    $results = $test->results();
                    $resources = $test->resources();
                    $status = $test->status();
                    $credits = $status['api_credits'];
                    $return = array(
                        'status' => true,
                        'testid' => $testid,
                        'results' => $results,
                        'resources' => $resources,
                        'id' => $sub_action,
                        'name' => 'Baseline',
                        'url' => $args['url'],
                        'credits' => $credits
                    );
                    $aj_gtmetrix_results[$sub_action] = $return;
                    update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
                }
            } else {
                $return = array(
                    'status' => false,
                    'error' => $test->error()
                );
            }
            break;
        case 'aj_step2b':
            $aj_gtmetrix_username = sanitize_text_field( $_POST['aj_gtmetrix_username'] );
            $aj_gtmetrix_api_key = sanitize_text_field( $_POST['aj_gtmetrix_api_key'] );
            $aj_gtmetrix_server = sanitize_text_field( $_POST['aj_gtmetrix_server'] );
            $site_url = trailingslashit( sanitize_text_field( $_POST['site_url'] ) );
            update_option( 'aj_gtmetrix_username', $aj_gtmetrix_username );
            update_option( 'aj_gtmetrix_api_key', $aj_gtmetrix_api_key );
            update_option( 'aj_gtmetrix_server', $aj_gtmetrix_server );
            $test = new Services_WTF_Test();
            $test->api_username( $aj_gtmetrix_username );
            $test->api_password( $aj_gtmetrix_api_key );
            $test->user_agent( AJ_UA );
            $args = array(
                'url' => $site_url . '?aj_simulate=async',
                'location' => $aj_gtmetrix_server
            );
            $testid = $test->test( $args );
            if ( $testid ) {
                $test->get_results();
                if ( $test->error() ) {
                    $return = array(
                        'status' => false,
                        'error' => $test->error()
                    );
                } else {
                    $testid = $test->get_test_id();
                    $results = $test->results();
                    $resources = $test->resources();
                    $status = $test->status();
                    $credits = $status['api_credits'];
                    $return = array(
                        'status' => true,
                        'testid' => $testid,
                        'results' => $results,
                        'resources' => $resources,
                        'id' => $sub_action,
                        'name' => 'Async',
                        'url' => $args['url'],
                        'credits' => $credits
                    );
                    $aj_gtmetrix_results[$sub_action] = $return;
                    update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
                }
            } else {
                $return = array(
                    'status' => false,
                    'error' => $test->error()
                );
            }
            break;
        case 'aj_step2c':
            $aj_gtmetrix_username = sanitize_text_field( $_POST['aj_gtmetrix_username'] );
            $aj_gtmetrix_api_key = sanitize_text_field( $_POST['aj_gtmetrix_api_key'] );
            $aj_gtmetrix_server = sanitize_text_field( $_POST['aj_gtmetrix_server'] );
            $site_url = trailingslashit( sanitize_text_field( $_POST['site_url'] ) );
            update_option( 'aj_gtmetrix_username', $aj_gtmetrix_username );
            update_option( 'aj_gtmetrix_api_key', $aj_gtmetrix_api_key );
            update_option( 'aj_gtmetrix_server', $aj_gtmetrix_server );
            $test = new Services_WTF_Test();
            $test->api_username( $aj_gtmetrix_username );
            $test->api_password( $aj_gtmetrix_api_key );
            $test->user_agent( AJ_UA );
            $args = array(
                'url' => $site_url . '?aj_simulate=defer',
                'location' => $aj_gtmetrix_server
            );
            $testid = $test->test( $args );
            if ( $testid ) {
                $test->get_results();
                if ( $test->error() ) {
                    $return = array(
                        'status' => false,
                        'error' => $test->error()
                    );
                } else {
                    $testid = $test->get_test_id();
                    $results = $test->results();
                    $resources = $test->resources();
                    $status = $test->status();
                    $credits = $status['api_credits'];
                    $return = array(
                        'status' => true,
                        'testid' => $testid,
                        'results' => $results,
                        'resources' => $resources,
                        'id' => $sub_action,
                        'name' => 'Defer',
                        'url' => $args['url'],
                        'credits' => $credits
                    );
                    $aj_gtmetrix_results[$sub_action] = $return;
                    update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
                }
            } else {
                $return = array(
                    'status' => false,
                    'error' => $test->error()
                );
            }
            break;
        case 'aj_step2d':
            $aj_gtmetrix_username = sanitize_text_field( $_POST['aj_gtmetrix_username'] );
            $aj_gtmetrix_api_key = sanitize_text_field( $_POST['aj_gtmetrix_api_key'] );
            $aj_gtmetrix_server = sanitize_text_field( $_POST['aj_gtmetrix_server'] );
            $site_url = trailingslashit( sanitize_text_field( $_POST['site_url'] ) );
            update_option( 'aj_gtmetrix_username', $aj_gtmetrix_username );
            update_option( 'aj_gtmetrix_api_key', $aj_gtmetrix_api_key );
            update_option( 'aj_gtmetrix_server', $aj_gtmetrix_server );
            $test = new Services_WTF_Test();
            $test->api_username( $aj_gtmetrix_username );
            $test->api_password( $aj_gtmetrix_api_key );
            $test->user_agent( AJ_UA );
            $args = array(
                'url' => $site_url . '?aj_simulate=async&aj_simulate_jquery=exclude',
                'location' => $aj_gtmetrix_server
            );
            $testid = $test->test( $args );
            if ( $testid ) {
                $test->get_results();
                if ( $test->error() ) {
                    $return = array(
                        'status' => false,
                        'error' => $test->error()
                    );
                } else {
                    $testid = $test->get_test_id();
                    $results = $test->results();
                    $resources = $test->resources();
                    $status = $test->status();
                    $credits = $status['api_credits'];
                    $return = array(
                        'status' => true,
                        'testid' => $testid,
                        'results' => $results,
                        'resources' => $resources,
                        'id' => $sub_action,
                        'name' => 'Async (jQuery Excluded)',
                        'url' => $args['url'],
                        'credits' => $credits
                    );
                    $aj_gtmetrix_results[$sub_action] = $return;
                    update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
                }
            } else {
                $return = array(
                    'status' => false,
                    'error' => $test->error()
                );
            }
            break;
        case 'aj_step2e':
            $aj_gtmetrix_username = sanitize_text_field( $_POST['aj_gtmetrix_username'] );
            $aj_gtmetrix_api_key = sanitize_text_field( $_POST['aj_gtmetrix_api_key'] );
            $aj_gtmetrix_server = sanitize_text_field( $_POST['aj_gtmetrix_server'] );
            $site_url = trailingslashit( sanitize_text_field( $_POST['site_url'] ) );
            update_option( 'aj_gtmetrix_username', $aj_gtmetrix_username );
            update_option( 'aj_gtmetrix_api_key', $aj_gtmetrix_api_key );
            update_option( 'aj_gtmetrix_server', $aj_gtmetrix_server );
            $test = new Services_WTF_Test();
            $test->api_username( $aj_gtmetrix_username );
                                $test->api_password( $aj_gtmetrix_api_key );
                                $test->user_agent( AJ_UA );
            $args = array(
                'url' => $site_url . '?aj_simulate=defer&aj_simulate_jquery=exclude',
                'location' => $aj_gtmetrix_server
            );
            $testid = $test->test( $args );
            if ( $testid ) {
                $test->get_results();
                if ( $test->error() ) {
                    $return = array(
                        'status' => false,
                        'error' => $test->error()
                    );
                } else {
                    $testid = $test->get_test_id();
                    $results = $test->results();
                    $resources = $test->resources();
                    $status = $test->status();
                    $credits = $status['api_credits'];
                    $return = array(
                        'status' => true,
                        'testid' => $testid,
                        'results' => $results,
                        'resources' => $resources,
                        'id' => $sub_action,
                        'name' => 'Defer (jQuery Excluded)',
                        'url' => $args['url'],
                        'credits' => $credits
                    );
                    $aj_gtmetrix_results[$sub_action] = $return;
                    update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
                }
            } else {
                $return = array(
                    'status' => false,
                    'error' => $test->error()
                );
            }
            break;
        case 'aj_step_results':
            $best_pagespeed = 0;
            $best_yslow = 0;
            $best_overall = 0;
            $best_result = array();
            $baseline = $aj_gtmetrix_results['aj_step2'];
            foreach ( $aj_gtmetrix_results as $aj_step => $aj_gtmetrix_result ) {
                if ( $aj_step != 'aj_step2' ) {
                    $pagespeed = $aj_gtmetrix_result['results']['pagespeed_score'];
                    $yslow = $aj_gtmetrix_result['results']['yslow_score'];
                    $combined = $pagespeed + $yslow;
                    if ( $combined > $best_overall ) {
                        $best_overall = $combined;
                        $best_result = $aj_gtmetrix_result;
                    }
                }
            }
            if ( !empty( $best_result ) ) {
                $return = $best_result;
                $return['status'] = true;
                $return['baseline_pagespeed'] = $baseline['results']['pagespeed_score'];
                $return['baseline_yslow'] = $baseline['results']['yslow_score'];
                $aj_gtmetrix_results['best_result'] = $return;
                update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
            } else {
                $return = array(
                    'status' => false,
                    'error' => 'No detected increase'
                );
            }
            break;
        case 'aj_apply_settings':
            $settings = sanitize_text_field( $_POST['settings'] );
            if ( $settings != '' ) {
                $best_id = $settings;
            } else {
                $best_result = $aj_gtmetrix_results['best_result'];
                $best_id = $best_result['id'];
            }
            update_option( 'aj_enabled', 1 );
            if ( $best_id == 'aj_step2b' || $best_id == 'aj_step2d' ) {
                update_option( 'aj_method', 'async' );
            } else if ( $best_id == 'aj_step2c' || $best_id == 'aj_step2e' ) {
                update_option( 'aj_method', 'defer' );
            }
            if ( $best_id == 'aj_step2b' ) {
                update_option( 'aj_jquery', 'async' );
            } else if ( $best_id == 'aj_step2d' ) {
                update_option( 'aj_jquery', 'defer' );
            } else if ( $best_id == 'aj_step2c' || $best_id == 'aj_step2e' ) {
                update_option( 'aj_jquery', 'exclude' );
            }
            update_option( 'aj_async', '' );
            update_option( 'aj_defer', '' );
            update_option( 'aj_exclusions', '' );
            update_option( 'aj_plugin_exclusions', array() );
            update_option( 'aj_theme_exclusions', array() );
            update_option( 'aj_autoptimize_enabled', 0 );
            update_option( 'aj_autoptimize_method', 'async' );
            $return['status'] = true;
            break;
        case 'aj_gtmetrix_test':
            $aj_gtmetrix_username = sanitize_text_field( $_POST['aj_gtmetrix_username'] );
            $aj_gtmetrix_api_key = sanitize_text_field( $_POST['aj_gtmetrix_api_key'] );
            $aj_gtmetrix_server = sanitize_text_field( $_POST['aj_gtmetrix_server'] );
            $site_url = trailingslashit( sanitize_text_field( $_POST['site_url'] ) );
            update_option( 'aj_gtmetrix_username', $aj_gtmetrix_username );
            update_option( 'aj_gtmetrix_api_key', $aj_gtmetrix_api_key );
            update_option( 'aj_gtmetrix_server', $aj_gtmetrix_server );
            $test = new Services_WTF_Test();
            $test->api_username( $aj_gtmetrix_username );
                                $test->api_password( $aj_gtmetrix_api_key );
                                $test->user_agent( AJ_UA );
            $args = array(
                'url' => $site_url,
                'location' => $aj_gtmetrix_server
            );
            $testid = $test->test( $args );
            if ( $testid ) {
                $test->get_results();
                if ( $test->error() ) {
                    $return = array(
                        'status' => false,
                        'error' => $test->error()
                    );
                } else {
                    $testid = $test->get_test_id();
                    $results = $test->results();
                    $resources = $test->resources();
                    $screenshot = base64_encode( file_get_contents( $results['report_url'] . '/screenshot.jpg' ) );
                    $status = $test->status();
                    $credits = $status['api_credits'];
                    $return = array(
                        'status' => true,
                        'testid' => $testid,
                        'results' => $results,
                        'resources' => $resources,
                        'id' => $sub_action,
                        'name' => 'Latest',
                        'url' => $args['url'],
                        'credits' => $credits,
                        'screenshot' => $screenshot
                    );
                    $aj_gtmetrix_results['latest'] = $return;
                    update_option( 'aj_gtmetrix_results', $aj_gtmetrix_results );
                }
            } else {
                $return = array(
                    'status' => false,
                    'error' => $test->error()
                );
            }
            break;
        case 'aj_save_settings':
            $aj_enabled = sanitize_text_field( $_POST['aj_enabled'] );
            $aj_enabled_logged = sanitize_text_field( $_POST['aj_enabled_logged'] );
            $aj_enabled_shop = sanitize_text_field( $_POST['aj_enabled_shop'] );
            $aj_method = sanitize_text_field( $_POST['aj_method'] );
            $aj_jquery = sanitize_text_field( $_POST['aj_jquery'] );
            $aj_async = sanitize_text_field( $_POST['aj_async'] );
            $aj_defer = sanitize_text_field( $_POST['aj_defer'] );
            $aj_exclusions = sanitize_text_field( $_POST['aj_exclusions'] );
            $aj_plugin_exclusions = $_POST['aj_plugin_exclusions'];
            $aj_theme_exclusions = $_POST['aj_theme_exclusions'];
            $aj_autoptimize_enabled = sanitize_text_field( $_POST['aj_autoptimize_enabled'] );
            $aj_autoptimize_method = sanitize_text_field( $_POST['aj_autoptimize_method'] );
            update_option( 'aj_enabled', $aj_enabled );
            update_option( 'aj_enabled_logged', $aj_enabled_logged );
            update_option( 'aj_enabled_shop', $aj_enabled_shop );
            update_option( 'aj_method', $aj_method );
            update_option( 'aj_jquery', $aj_jquery );
            update_option( 'aj_async', $aj_async );
            update_option( 'aj_defer', $aj_defer );
            update_option( 'aj_exclusions', $aj_exclusions );
            update_option( 'aj_plugin_exclusions', $aj_plugin_exclusions );
            update_option( 'aj_theme_exclusions', $aj_theme_exclusions );
            update_option( 'aj_autoptimize_enabled', $aj_autoptimize_enabled );
            update_option( 'aj_autoptimize_method', $aj_autoptimize_method );
            $return['status'] = true;
            break;
    }
}

if( is_null( $return ) ) {
    $return = array(
        'status' => false
    );
}

echo json_encode( $return );

wp_die();
