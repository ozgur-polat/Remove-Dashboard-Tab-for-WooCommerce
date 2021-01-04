<?php
   /*
   Plugin Name: Remove Dashboard Tab for WooCommerce
   Plugin URI: https://digitalworkshouse.com/wordpress
   description: Swiftly and smoothly removes the Dashboard tab from the Account menu in WooCommerce.
   Version: 1.0
   Author: Digital Works House
   Author URI: https://digitalworkshouse.com
   License: GPLv2 or later
   */

    /**
     * Check if WooCommerce is active
     **/
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        /* Remove Dashboard from WooCommerce account menu */
        add_filter( 'woocommerce_account_menu_items', 'account_menu_items_callback' );
        function account_menu_items_callback( $items ) {
            foreach( $items as $key => $item ) {
                unset($items[$key]);
                break;
            }
            return $items;
        }

        /* Redirect default my account dashboard to the first endpoint of my account menu (in this case Orders) */
        add_action( 'template_redirect', 'template_redirect_callback' );
        function template_redirect_callback() {
            if( is_account_page() && is_user_logged_in() && ! is_wc_endpoint_url() ){
                $first_myaccount_endpoint = 'orders';
                wp_redirect( wc_get_account_endpoint_url( $first_myaccount_endpoint ) );
            }
        }
    }
    
?>
