<?php
// function that runs when shortcode is called
function rm_search_domain_shortcode() { 
    $response = '';
$form = '<form class="rm-form"';
$form .= ' action="" method="GET">
<h3>Search Your Perfect Domain Name</h3>
<div class="rm-form-group">
<input class="rm-input" type="text" name="domain_name" placeholder="Enter Domain Name">
</div>
<div class="rm-form-group">
<input class="rm-input-submit" type="submit" value="Search Domain"/>
</div>
</form>
';

if (isset ($_GET['domain_name'])) {
    $response = rm_search_domain();
}

// Output needs to be return
$form .= $response;

return $form;
} 

function rm_search_domain() {
        $resultsDiv = '';
        $domain = $_GET['domain_name'];


        // Show spinner and search domain
        $token = get_option('resellme_api_key');

        $rm = new Resellme\Client($token);

        $search = $rm->searchDomain($domain);

        // Show results
    $resultsDiv .= '<div class="rm-results">';
    
    // If domain is avaible show register domain
    // else show domain not availble, and Show the search box
    if ($search->status == 'available') {
        $resultsDiv .= '<div class="rm-domain-available">';
        $resultsDiv .= '<p> ' . $domain . ' is available for $';

        $resultsDiv .= $search->selling_price->ZWL;
        $resultsDiv .= ' ZWL</p><input type="submit" class="rm-register" value="Register Now!" />';
        $resultsDiv .= '</div>';

        // Contacts form
        $contact = '
        <div class="rm-contact-details">
        <form method="POST" action="/register-domain">
        <h3>Enter Contact Details</h3>
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
        </select></div>';

        // NS Form
        $ns = '
        <div class="rm-nameservers">
        <h3>Enter Nameservers</h3>
        <input type="text" required name="ns1" placeholder="NS1">
        <input type="text"  required name="ns2" placeholder="NS2">
        <input type="text"  name="ns3" placeholder="NS3">
        <input type="text"  name="ns4" placeholder="NS4">
        <p><input type="submit" value="Submit Domain"
/></p></div></form>';

        $resultsDiv .= $contact;
        $resultsDiv .= $ns;
    } else {
        $resultsDiv .= '<div class="rm-domain-not-available">';
        $resultsDiv .= '<a class="rm-register">Domain Not Available</a>';
        $resultsDiv .= '</div>';

        $form = '<form class="rm-form"';
        $form .= ' action="/register-domain" method="POST">
        <input type="text" name="domain" placeholder="Domain">
        <input class="resellme-domain-search" type="submit" value="Search Domain"/>
        </form>
        ';

        $resultsDiv .= $form;
    }

    $resultsDiv .= '</div>';

    return $resultsDiv;
}


function rm_register_domain() { 
    $domain = '';
    $resultsDiv = '';
    $submitted = false;
    
    
    // If Submit domain is clicked register domain
    if (isset($_POST['domain_available'])) {
        $submitted = rm_register();
    }

    if($submitted) {
        $resultsDiv .= '<div class="rm-domain-registered">Domain Registered</div>';
    }

    // Output needs to be return
    return $resultsDiv;
} 

function rm_register() {
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
        'post_title'    => $domain,
        'post_content'  => $description,
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

    return true;
}


// register shortcode
add_shortcode('rm-search-domain', 'rm_search_domain_shortcode');