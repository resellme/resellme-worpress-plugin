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
define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define( 'RM_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI2IiwianRpIjoiNmMwNTA2OGQyYjdmMGQxMTM5YjU1Y2NmMjFhNGNiNWU5NDk1ZTA3NWMwNDA2MTA4MTY5NmUxY2I0ZDY3N2RkYjViZTI2NDFkYmQwMWUzMTciLCJpYXQiOjE2MDkxMjQwNzcsIm5iZiI6MTYwOTEyNDA3NywiZXhwIjoxNjQwNjYwMDc3LCJzdWIiOiIzMSIsInNjb3BlcyI6W119.ChXEC3utQdYjmEHRZ6mA_dh54cMlmjuK2XuMr5BIE47Y1jn9vp_DBmpehIxct5Pd7YY1sVQcBJ_YlvlJokH2U_0cO9_PnI7TGzrkWzR90Br8PXuqauTDzkANxxwkajNAEawYtcDpIHTYuQKkDkEC_DukWPLegzi9nQ2Xugy7LYnVzqv7C-JJGKnc8_gF42UtiW0ABs3zWZHKkpL4W7kWCsLqwQLXXFhosjBSUC0QthVRN5D6L2fep5CIEMtOtkkZiJTcm1pRnTmrDfvvefR9e46Egz-rHqLSOL_H7V6ynHQz45ITKSBM4Wfo_lWwVPKAp21Td8QgbNf1ehdpwSyCC1-6xTVzcxDOa8KZvjy6uFNFcSSXg9iIq6OZBsnNB_jUFEUE2UPagzQHTDwcdP6nZI1g87qpkFj3PoKSLpKXSE3QXK_38e0nSUYSpinRIgHCYQOITBxzl2yOOtPyvfYgubQnDksM2OqLoJB0S8431bspQS2AIZ7R8BCLuAFdtLYaCMNZoO6ALesgMu67ophCq-r-wH2ocbM9wNS_Sn-nD_8GkuzudaF2Q-wQYdaKYOlS21sTfec4cukhrr_bpHNBQt99CTSqFUB5Nuxq712_ErN5qO1kftDJ0XSLoYqcD9t2wvRl06NQTKjzmUDTVbHSIiNqN_frvl56KLfjEKY-Ei8');


//Include Class files
require_once('classes/rm.php');

add_action( 'init', array( 'RM', 'init' ) );

/**
 * Include Vendor files
 */
require  PLUGIN_DIR . 'vendor/autoload.php';


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
include 'shortcodes/rm-register-domain.php';
include 'shortcodes/rm-domains.php';

// Custom Posts Types
include 'post-types/domain.php';
