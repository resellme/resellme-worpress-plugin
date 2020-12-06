<?php
function rm_user_styles() {
	wp_enqueue_style( 'rm-style', RM_PLUGIN_FILE . '/css/style.css');
}

add_action('wp_enqueue_scripts', 'rm_user_styles' );