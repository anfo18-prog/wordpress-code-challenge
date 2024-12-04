<?php
/*
Plugin Name: WooCommerce custom discounts
Plugin URI: https://github.com/anfo18-prog/wordpress-code-challenge
Description: This plugin applies dynamic discounts based on cart totals and also in user specific role.
Author: Andrés Forero
Version: 1.0.0
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Includes hook handlers
include ( plugin_dir_path(__FILE__) . 'includes/custom-discounts-handler.php' );

include ( plugin_dir_path(__FILE__) . 'includes/user-role-handler.php' );

// Initialize the plugin
function initialize_woocommerce_custom_discounts() {
    WooCommerceCustomDiscounts\CustomDiscountsHandler::get_instance();
    WooCommerceCustomDiscounts\UserRoleHandler::get_instance();
}

// Adds plugin initializtion action hook
add_action('plugins_loaded', 'initialize_woocommerce_custom_discounts');

?>