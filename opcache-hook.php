<?php
/*
Plugin Name: WordPress OPcache Hook
Plugin URI: https://github.com/0xJacky/WordPress-OPcache-Hook
Description: WordPress 自动刷新 Opcache
Version: 0.1
Author: Jacky
Author URI: https://jackyu.cn/
License: GPL2
*/

function opcache() {
    return function_exists( 'opcache_reset' )
           && ini_get( 'opcache.enable' );
}

function opcache_hook() {
    if ( ! opcache() ) {
        return;
    }
    $files = opcache_get_status();
    if ( ! empty( $files['scripts'] ) ) {
        foreach ( $files['scripts'] as $file => $value ) {
            opcache_invalidate( $file );
        }
    }
}

// recheck opcache after updated core, plugins and themes.
add_filter( 'upgrader_process_complete', 'opcache_hook' );
