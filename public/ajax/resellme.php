<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Search Domain
add_action('wp_ajax_rm_search_domain', 'rm_search_domain');
add_action( 'wp_ajax_nopriv_rm_search_domain', 'rm_search_domain' );

// Save domain in Wordpress
add_action('wp_ajax_rm_save_domain', 'rm_save_domain');
add_action( 'wp_ajax_nopriv_rm_save_domain', 'rm_save_domain' );

// Register Domain
add_action('wp_ajax_rm_register_domain', 'rm_register_domain');
add_action( 'wp_ajax_nopriv_rm_register_domain', 'rm_register_domain' );

function rm_search_domain() {

    $domain = $_POST['domain'];

    // Show spinner and search domain
    $token = get_option('resellme_api_key');

    $rm = new Resellme\Client($token);

    $search = $rm->searchDomain($domain);

	echo  json_encode($search);

    die();
}

function rm_save_domain() {
    $domain = $_POST['domain'];
    $contact = $_POST['contact'];
    $ns = $_POST['nameservers'];

    // Insert into custom post
    $post = array(
        'post_title'    => $domain,
        'post_content'  => $domain,
        'post_status'   => 'publish',
        'post_type'     => 'domain'
    );
    
    $post_id = wp_insert_post($post);
    
    // Create meta for nameservers
    foreach($ns as $key => $value) {
        add_post_meta( $post_id, $key, $value, true);
    }

    // Create meta for contact
    foreach($contact as $key => $value) {
        add_post_meta( $post_id, $key, $value, true);
    }

    // Extra Domain fields - name
    add_post_meta( $post_id, 'domain', $domain, true);

    echo  'saved';

    die();
}

function rm_register_domain() {
    // TODO: Check if customer paid before you proceed
    $domain = $_POST['domain'];
    $post = get_page_by_title( $domain, OBJECT, 'domain' );
    $meta_values   = get_post_meta( $post->ID );

    // Register Domain
    $token = get_option('resellme_api_key');

    $rm = new Resellme\Client($token);
    // prepare data

    // NS
    $ns = [
        "ns1" => $meta_values['ns1'][0],
        "ns2" => $meta_values['ns2'][0],
    ];

    if(isset($meta_values['ns3'][0])) {
        $ns["ns3"] = $meta_values['ns3'][0];
    } 

    if(isset($meta_values['ns4'][0])) {
        $ns["ns4"] = $meta_values['ns4'][0];
    } 

    // Contact
    $contact = [
        'first_name' => $meta_values['first_name'][0],
        'last_name' => $meta_values['last_name'][0],
        'email' => $meta_values['email'][0],
        'company' => $meta_values['company'][0],
        'street_address' => $meta_values['street_address'][0],
        'mobile' => $meta_values['mobile'][0],
        'core_business' => $meta_values['core_business'][0],
        'city' => $meta_values['city'][0],
        'country' => $meta_values['country'][0],
    ];

    $data = [
        'domain'            =>  $domain,
        'contacts'          =>  [
            'registrant'    =>  $contact
        ],
        'nameservers'       =>  $ns
    ];

    $register = $rm->registerDomain($data);

    echo  json_encode($register);

    die();
}


