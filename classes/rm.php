<?php
class RM {
	const API_HOST = 'sandbox.resellme.co.zw';
	private static $initiated = false; 
	
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
	}

	private function callback_for_setting_up_scripts() {
	    wp_register_style( 'rm-style', '/css/style.css' );
	}
}