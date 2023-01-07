<?php
class RM {
	const API_HOST 		= 'api.resellme.co.zw';
	const PLUGIN_DIR 	= '' ;

	private static $initiated = false; 

	private static $plugin_name = 'resellme'; 
	
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

		// Settings page
		add_action('admin_menu', 'rm_add_settings_page', 9);  

		// add_action( 'admin_init', 'rm_register_settings' );
	}

	// Add styles
	private function callback_for_setting_up_scripts() {
		wp_register_style( 'rm-style', plugin_dir_path( __DIR__ ) . 'css/rm-style.css' );
		wp_register_script( 'rm-scripts', plugin_dir_path( __DIR__ ) . 'js/rm.js', ['jquery'], '1.0.0', true );

		wp_enqueue_script('rm-scripts');
		wp_enqueue_style( 'rm-style' );

	}

	// Settings page
	public function rm_add_settings_page() {
		add_menu_page(  $this->plugin_name, 'Resellme', 'administrator', $this->plugin_name, array( $this, 'rm_render_plugin_settings_page' ), 'img/resellme-brand-mark.png', 26 );

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( $this->plugin_name, 'Plugin Name Settings', 'Settings', 'administrator', $this->plugin_name.'-settings', array( $this, 'displayPluginAdminSettings' ));
	}

	function rm_render_plugin_settings_page() {
		?>
		<h2>Resellme Plugin Settings</h2>
		<form action="options.php" method="post">
			<?php 
			settings_fields( 'rm_plugin_options' );
			do_settings_sections( 'rm_plugin' ); ?>
			<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
		</form>
		<?php
	}

	function rm_register_settings() {
		register_setting( 'rm_plugin_options', 'rm_plugin_options', 'rm_plugin_options_validate' );
		add_settings_section( 'api_settings', 'API Settings', 'rm_section_text', 'rm_plugin' );
	
		add_settings_field( 'rm_setting_token', 'Token', 'rm_setting_token', 'rm_plugin', 'api_settings' );
	}

	function rm_plugin_options_validate( $input ) {
		return $input;
	}

	function rm_section_text() {
		echo '<p>Here you can set all the options for using the API</p>';
	}
	
	function rm_setting_token() {
		$options = get_option( 'rm_plugin_options' ); ?>

	<input id='rm_setting_token' name="rm_plugin_options[token]" type='text' value="<?php esc_attr( $options['token'] ) ?>" />
	<?php
	}
	
	
}