<?php

/**
 * Registers the `domain` post type.
 */
function domain_init() {
	register_post_type( 'domain', array(
		'labels'                => array(
			'name'                  => __( 'Domains', 'rm' ),
			'singular_name'         => __( 'Domain', 'rm' ),
			'all_items'             => __( 'All Domains', 'rm' ),
			'archives'              => __( 'Domain Archives', 'rm' ),
			'attributes'            => __( 'Domain Attributes', 'rm' ),
			'insert_into_item'      => __( 'Insert into Domain', 'rm' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Domain', 'rm' ),
			'featured_image'        => _x( 'Featured Image', 'domain', 'rm' ),
			'set_featured_image'    => _x( 'Set featured image', 'domain', 'rm' ),
			'remove_featured_image' => _x( 'Remove featured image', 'domain', 'rm' ),
			'use_featured_image'    => _x( 'Use as featured image', 'domain', 'rm' ),
			'filter_items_list'     => __( 'Filter Domains list', 'rm' ),
			'items_list_navigation' => __( 'Domains list navigation', 'rm' ),
			'items_list'            => __( 'Domains list', 'rm' ),
			'new_item'              => __( 'New Domain', 'rm' ),
			'add_new'               => __( 'Add New', 'rm' ),
			'add_new_item'          => __( 'Add New Domain', 'rm' ),
			'edit_item'             => __( 'Edit Domain', 'rm' ),
			'view_item'             => __( 'View Domain', 'rm' ),
			'view_items'            => __( 'View Domains', 'rm' ),
			'search_items'          => __( 'Search Domains', 'rm' ),
			'not_found'             => __( 'No Domains found', 'rm' ),
			'not_found_in_trash'    => __( 'No Domains found in trash', 'rm' ),
			'parent_item_colon'     => __( 'Parent Domain:', 'rm' ),
			'menu_name'             => __( 'Domains', 'rm' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array('custom-fields'),
		'has_archive'           => false,
		'rewrite' 				=> true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'domain',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'domain_init' );

/**
 * Sets the post updated messages for the `domain` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `domain` post type.
 */
function domain_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['domain'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Domain updated. <a target="_blank" href="%s">View Domain</a>', 'rm' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'rm' ),
		3  => __( 'Custom field deleted.', 'rm' ),
		4  => __( 'Domain updated.', 'rm' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Domain restored to revision from %s', 'rm' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Domain published. <a href="%s">View Domain</a>', 'rm' ), esc_url( $permalink ) ),
		7  => __( 'Domain saved.', 'rm' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Domain submitted. <a target="_blank" href="%s">Preview Domain</a>', 'rm' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Domain scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Domain</a>', 'rm' ),
		date_i18n( __( 'M j, Y @ G:i', 'rm' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Domain draft updated. <a target="_blank" href="%s">Preview Domain</a>', 'rm' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'domain_updated_messages' );

function domain_filter_posts_columns( $columns ) {
	// Remove Title
	unset(
		$columns['title'],
		$columns['date']
	);

	$columns['Name'] = __( 'Name', 'rm' );
	// $columns['Client'] = __( 'Client', 'rm' );
	$columns['Contact'] = __( 'Contact', 'rm' );
	$columns['Nameservers'] = __( 'Nameservers', 'rm' );

  	return $columns;
}

add_filter( 'manage_domain_posts_columns', 'domain_filter_posts_columns' );

/**
 * Get Columns data
 */
add_filter('manage_domain_posts_custom_column',  'add_data_to_custom_domains_columns', 10, 3);
function add_data_to_custom_domains_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'Name' :
			echo get_post_meta( $post_id , 'domain' , true ); 
			break;
		// case 'Client' :
		// 	echo get_post_meta( $post_id , '_custom_column_2' , true ); 
		// 		break;
		case 'Contact' :
			echo get_post_meta( $post_id , 'first_name' , true ); 
				break;
		case 'Nameservers' :
			echo get_post_meta( $post_id , 'ns1' , true ) . '<br>'; 
			echo get_post_meta( $post_id , 'ns2' , true ) . '<br>';
			echo get_post_meta( $post_id , 'ns3' , true ) . '<br>'; 
			echo get_post_meta( $post_id , 'ns4' , true ) . '<br>'; 
			break;
	}
}

/**
 * Add meta boxes
 */

//  Domain Name
function rm_domain_metabox() {
	$screens = [ 'domain' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'rm_domain_metabox',                 // Unique ID
            'Domain Name',      // Box title
            'rm_domain_metabox_html',  // Content callback, must be of type callable
			$screen,                            // Post type
			'normal',
			'high'
        );
    }
}
add_action( 'add_meta_boxes', 'rm_domain_metabox' );

function rm_domain_metabox_html( $post ) {
    ?>
	<label for="ns4">Domain Name</label></br>
    <input id="domain" type="text" name="domain" value="<?php echo get_post_meta($post->ID, "domain", true); ?>"/></br>
    <?php
}

// NS
function rm_ns_metabox() {
	$screens = [ 'domain' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'rm_ns_metabox',                 // Unique ID
            'Nameservers',      // Box title
            'rm_ns_metabox_html',  // Content callback, must be of type callable
			$screen,                            // Post type
			'normal',
			'high'
        );
    }
}
add_action( 'add_meta_boxes', 'rm_ns_metabox' );

function rm_ns_metabox_html( $post ) {
    ?>
    <label for="ns1">Nameserver 1</label></br>
    <input value="<?php echo get_post_meta($post->ID, "ns1", true); ?>" id="ns1" type="text" name="ns1"/></br>
	<label for="ns2">Nameserver 2</label></br>
    <input value="<?php echo get_post_meta($post->ID, "ns2", true); ?>" id="ns2" type="text" name="ns2"/></br>
	<label for="ns3">Nameserver 3</label></br>
    <input value="<?php echo get_post_meta($post->ID, "ns3", true); ?>" id="ns3" type="text" name="ns3"/></br>
	<label for="ns4">Nameserver 4</label></br>
    <input value="<?php echo get_post_meta($post->ID, "ns4", true); ?>" id="ns4" type="text" name="ns4"/></br>
    <?php
}

// Contact
function rm_contact_metabox() {
	$screens = [ 'domain' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'rm_contact_metabox',                 // Unique ID
            'Contact',      // Box title
            'rm_contact_metabox_html',  // Content callback, must be of type callable
			$screen,                            // Post type
			'side',
			'high'
        );
    }
}

add_action( 'add_meta_boxes', 'rm_contact_metabox' );

function rm_contact_metabox_html( $post ) {
    ?>
		<label for="first_name">First Name</label></br>
		<input  value="<?php echo get_post_meta($post->ID, "first_name", true); ?>" id="first_name" type="text" required name="first_name" placeholder="First Name"></br>
        
		<label for="last_name">Last Name</label></br>
		<input value="<?php echo get_post_meta($post->ID, "last_name", true); ?>" id="last_name" type="text"  required name="last_name" placeholder="Surname"></br>

		<label for="email">Email</label></br>
        <input value="<?php echo get_post_meta($post->ID, "email", true); ?>" id="email" type="email"  name="email" placeholder="Email"></br>

		<label for="company">Company</label></br>
        <input value="<?php echo get_post_meta($post->ID, "company", true); ?>" id="company" type="text"  name="company" placeholder="Company"></br>

		<label for="street_address">Street Address</label></br>
        <input value="<?php echo get_post_meta($post->ID, "street_address", true); ?>" id="street_address" type="text"  name="street_address" placeholder="Street Address"></br>

		<label for="mobile">Mobile Number</label></br>
        <input value="<?php echo get_post_meta($post->ID, "mobile", true); ?>" id="mobile" type="text"  name="mobile" placeholder="Mobile Number"></br>

		<label for="core_business">Core Business</label></br>
        <input value="<?php echo get_post_meta($post->ID, "core_business", true); ?>" id="core_business" type="text"  name="core_business" placeholder="Core Business"></br>

		<label for="city">City</label></br>
        <input value="<?php echo get_post_meta($post->ID, "city", true); ?>" id="city" type="text"  name="city" placeholder="City"></br>

		<label for="country">Country</label></br>
        <select id="country" name="country">
        <option value="Zimbabwe">Zimbabwe</option>
        </select></br>
    <?php
}

// Update Meta Data
if (isset($_POST['domain'])) {
	add_action( 'save_post', 'save_meta_box_data' );
}

function save_meta_box_data($post_id) {
	// Save Contact
	$contact =  [
		'first_name'             => $_POST['first_name'],
		'last_name'              => $_POST['last_name'],
		'email'                  => $_POST['email'],
		'company'                => $_POST['company'],
		'street_address'         => $_POST['street_address'],
		'mobile'                 => $_POST['mobile'],
		'core_business'          => $_POST['core_business'],
		'city'                   => $_POST['city'],
		'country'                => $_POST['country']
	];

	foreach($contact as $key => $value) {
		update_post_meta($post_id, $key, $value);
	}

	// Save nameservers
	$ns = [
        'ns1' => $_POST['ns1'],
        'ns2' => $_POST['ns2'],
        'ns3' => $_POST['ns3'],
        'ns4' => $_POST['ns4']
	];
	
	foreach($ns as $key => $value) {
		update_post_meta($post_id, $key, $value);
	}

	// Domain 
	$domain = $_POST['domain'];
	update_post_meta($post_id, 'domain', $domain);

	// Submit new registration / modification
	$domainData = [
		'domain' 			=> $domain,
		'nameservers' 		=> $ns,
		'contacts'        	=>  [
            'registrant'    =>  $contact
        ]
	];

	$rm = new Resellme\RMClient(RM_TOKEN);
	$filters = [
		'name' => $domain
	];

	$eDomain = $rm->getDomains($filters);

	if (empty($eDomain)) {
		$rm->registerDomain($domainData);
	} else {
		// Update

	}
}