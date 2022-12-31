<?php
// function that runs when shortcode is called
function rm_register_domain_shortcode() { 
    $domain = '';
    $resultsDiv = '';
    $submitted = false;
    if (isset($_POST['domain'])) {
        $domain = $_POST['domain'];


        // Show spinner and search domain
        $rm = new Resellme\RMClient(RM_TOKEN);

        $search = $rm->searchDomain($domain);

        // Show results
    $resultsDiv .= '<div class="rm-results">';
    
    // If domain is avaible show register domain
    // else show domain not availble, and Show the search box
    if ($search->data->attributes->status == 'available') {
        $resultsDiv .= '<div class="rm-domain-available">';
        $resultsDiv .= 'Domain Available. <input type="submit" class="rm-register" value="Register Now!" />';
        $resultsDiv .= '</div>';

        // Contacts form
        $contact = '
        <form method="POST" action="/register-domain">
        <input name="domain_available" type="hidden" value="' . $domain .'"/>
        <input type="text" required name="first_name" placeholder="First Name">
        <input type="text"  required name="last_name" placeholder="Surname">
        <input type="email"  name="email" placeholder="Email">
        <input type="text"  name="company" placeholder="Company">
        <input type="text"  name="street_address" placeholder="Street Address">
        <input type="text"  name="mobile" placeholder="Mobile Number">
        <input type="text"  name="core_business" placeholder="Core Business">
        <input type="text"  name="city" placeholder="City">
        <select name="country">
        <option value="Zimbabwe">Zimbabwe</option>
        </select>';

        // NS Form
        $ns = '<input type="text" required name="ns1" placeholder="NS1">
        <input type="text"  required name="ns2" placeholder="NS2">
        <input type="text"  name="ns3" placeholder="NS3">
        <input type="text"  name="ns4" placeholder="NS4">
        <input type="submit" value="Submit Domain"
/></form>';

        $resultsDiv .= $contact;
        $resultsDiv .= $ns;
    } else {
        $resultsDiv .= '<div class="rm-domain-not-available">';
        $resultsDiv .= '<a class="rm-register">Domain Not Available</a>';
        $resultsDiv .= '</div>';

        $form = '<form class="rm-form"';
        $form .= ' action="/register-domain" method="POST">
        <input type="text" name="domain" placeholder="Domain">
        <input type="submit" value="Search Domain"/>
        </form>
        ';

        $resultsDiv .= $form;
    }

    $resultsDiv .= '</div>';

    }
    
    // If Submit domain is clicked register domain
    if (isset($_POST['domain_available'])) {
        $submitted = register();
    }

    if($submitted) {
        $resultsDiv .= '<div class="rm-domain-registered">Domain Registered</div>';
    }

    // Output needs to be return
    return $resultsDiv;
} 

function register() {
    $domain                 = $_POST['domain_available'];

    // Contact
    $contact = [
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

    // Nameservers
    $ns = [
        'ns1' => $_POST['ns1'],
        'ns2' => $_POST['ns2'],
        'ns3' => $_POST['ns3'],
        'ns4' => $_POST['ns4']
    ];

    // prepare data
    $data = [
        'domain'            =>  $domain,
        'contacts'          =>  [
            'registrant'    =>  $contact
        ],
        'nameservers'       =>  $ns
    ];

    // Register Domain
    $rm = new Resellme\RMClient(RM_TOKEN);
    $register = $rm->registerDomain($data);

    // Insert into custom post
    $post = array(
        'post_title'	=> $domain,
        'post_content'	=> $description,
        'post_status'	=> 'publish',
        'post_type'		=> 'domain'
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

    return true;
}

// register shortcode
add_shortcode('rm-register-domain', 'rm_register_domain_shortcode');

