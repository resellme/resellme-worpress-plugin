<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    //  $contact = [
    //     'first_name'             => $_POST['first_name'],
    //     'last_name'              => $_POST['last_name'],
    //     'email'                  => $_POST['email'],
    //     'company'                => $_POST['company'],
    //     'street_address'         => $_POST['street_address'],
    //     'mobile'                 => $_POST['mobile'],
    //     'core_business'          => $_POST['core_business'],
    //     'city'                   => $_POST['city'],
    //     'country'                => $_POST['country']
    // ];

    // // Nameservers
    // $ns = [
    //     'ns1' => $_POST['ns1'],
    //     'ns2' => $_POST['ns2'],
    //     'ns3' => $_POST['ns3'],
    //     'ns4' => $_POST['ns4']
    // ];
    $domain = $_POST['domain'];
    $contact = $_POST['contact'];
    $ns = $_POST['nameservers'];

    // prepare data
    $data = [
        'domain'            =>  $domain,
        'contacts'          =>  [
            'registrant'    =>  $contact
        ],
        'nameservers'       =>  $ns
    ];

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

    echo json_encode($contact['first_name']);
    // echo  'registered';

    die();
}

function rm_register_domain() {
    // TODO: Check if customer paid before you proceed
    $domain = $_POST['domain'];
    $post = get_page_by_title( $domain, OBJECT, 'domain' );
    $meta_values   = get_post_meta( $post->ID );



    // Register Domain
    // $token = get_option('resellme_api_key');

    // $rm = new Resellme\Client($token);
    // $register = $rm->registerDomain($data);

    echo json_encode($meta_values);

    // echo  'registered';

    die();
}


