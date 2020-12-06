<?php
/**
 * Plugin Name:     Resellme
 * Plugin URI:      www.resellme.co.zw
 * Description:     For domains and hosting reselling
 * Author:          Privy Reza
 * Author URI:      www.resellme.co.zw
 * Text Domain:     rm
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Rm
 */
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'You can not call me directly!';
	exit;
}

// add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
add_action('wp_enqueue_style', 'callback_for_setting_up_scripts');

// callback_for_setting_up_scripts();

function callback_for_setting_up_scripts() {
    wp_register_style ( 'rm-style', plugins_url ( 'css/rm-style.css', __FILE__ ) );
}

define( 'RM_PLUGIN_FILE', __FILE__ );
define( 'HOST', 'https://sandbox.resellme.co.zw' );
define( 'APIURL', HOST . '/api/v1' );


//Include Class files
require_once('classes/rm.php');

add_action( 'init', array( 'RM', 'init' ) );


/**
 * Activation hook functions
 * Create a few pages to support resellmeplugin
 * rm init
 *
 */
include 'utils/rm-init.php';

// Shortcodes
include 'shortcodes/rm-search-domain.php';
include 'shortcodes/rm-contact-details.php';
include 'shortcodes/rm-nameservers.php';