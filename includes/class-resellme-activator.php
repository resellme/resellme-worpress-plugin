<?php

/**
 * Fired during plugin activation
 *
 * @link       https://privyreza.co.zw
 * @since      1.0.0
 *
 * @package    Resellme
 * @subpackage Resellme/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Resellme
 * @subpackage Resellme/includes
 * @author     privyreza <privyreza@gmail.com>
 */
class Resellme_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

  // Verify user is admin and can activate plugin
  if ( ! current_user_can( 'activate_plugins' ) || ! is_admin() ) return;
  
      global $wpdb;

      $searchDomainPage = $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'search-domain'", 'ARRAY_A' );

      $contactDetailsPage = $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'contact-details'", 'ARRAY_A' );

      $nameserversPage =  $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'nameservers'", 'ARRAY_A' );

      $current_user = wp_get_current_user();
      $pages = [];

      if ( null === $searchDomainPage)
      {
        // create Search Domain Page
        $searchDomainPage = array(
            'post_title'  => __( 'Search Domain' ),
            'post_status' => 'publish',
            'post_author' => $current_user->ID,
            'post_type'   => 'page',
            'post_content'=> '[rm-search-domain]'
        );

            wp_insert_post( $searchDomainPage );
        } 

        if ( null === $contactDetailsPage )
        {
            // create Contacts Page
            $contactDetailsPage = array(
                'post_title'  => __( 'Contact Details' ),
                'post_status' => 'publish',
                'post_author' => $current_user->ID,
                'post_type'   => 'page',
                'post_content'=> '[rm-contact-details]'
            );

            wp_insert_post( $contactDetailsPage );
        }

        if ( null === $nameserversPage) {
            // create Contacts Page
            $nameserversPage = array(
                'post_title'  => __( 'Nameservers' ),
                'post_status' => 'publish',
                'post_author' => $current_user->ID,
                'post_type'   => 'page',
                'post_content'=> '[rm-nameservers]'
            );

            wp_insert_post( $nameserversPage );
        }
	}
}
