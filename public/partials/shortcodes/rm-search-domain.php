<?php
// register shortcode
add_shortcode('rm-search-domain', 'rm_search_domain_shortcode');
// function that runs when shortcode is called
function rm_search_domain_shortcode() { ?>
<form  id="rm-search-domain-form" class="rm-form" action="" method="GET">
<h3>Search Your Perfect Domain Name</h3>
<div class="rm-form-group">
<input id="domain-name" class="rm-input" type="text" name="domain_name" placeholder="Enter Domain Name">
<input id="rm-search-domain-url" type="hidden" value="<?php echo admin_url( 'admin-ajax.php' ) ?>" name="url">
</div>
<div class="rm-form-group">
<a href="javascript:0;" id="rm-search-domain" class="btn-link">Search Domain</a>
</div>
</form>

<!-- Domain Search Results -->
<div id="rm-results" class="rm-results" style="display: none;">
    <div class="rm-domain-available">
        <div id="rm-search-response"></div>
        <a href="javascript:0;" id="rm-register-domain" class="rm-register">Register Now!</a><br><br>
        <a href="javascript:0;" id="rm-search-domain-again" class="rm-search-again">Search Again</a>
    </div>
</div>

<!-- Show contact Details -->
 <div style="display: none;" id="rm-contact-details" class="rm-contact-details">
<form method="POST" action="/register-domain">
<h3>Enter Contact Details</h3>
<p><input name="domain_available" type="hidden" value="' . $domain .'"/>
<input id="first_name" type="text" required name="first_name" placeholder="First Name">
<input id="last_name" type="text"  required name="last_name" placeholder="Surname"></p>
<p><input id="email" type="email"  name="email" placeholder="Email">
<input id="company" type="text"  name="company" placeholder="Company"></p>
<input id="street_address" type="text"  name="street_address" placeholder="Street Address">
<input id="mobile" type="text"  name="mobile" placeholder="Mobile Number">
<input id="core_business" type="text"  name="core_business" placeholder="Core Business">
<input id="city" type="text"  name="city" placeholder="City">
<select id="country" name="country">
<option value="Zimbabwe">Zimbabwe</option>
</select>
<p><a href="javascript:0;" id="rm-submit-contact" class="btn-link">Submit Contact</a></p>
</form>
</div>

<!-- Show NS details -->
<div id="rm-nameservers" class="rm-nameservers" style="display: none;">
<form>
<h3>Enter Nameservers</h3>
<input id="ns1" type="text" required name="ns1" placeholder="NS1">
<input id="ns2" type="text"  required name="ns2" placeholder="NS2">
<input id="ns3" type="text"  name="ns3" placeholder="NS3">
<input id="ns4" type="text"  name="ns4" placeholder="NS4">
<a href="javascript:0;" id="rm-submit-ns" class="btn-link">Submit Nameservers</a>
<form>
</div>

<?php }
