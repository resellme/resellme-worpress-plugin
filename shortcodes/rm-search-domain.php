<?php
// function that runs when shortcode is called
function rm_search_domain_shortcode() { 
$form = '<form class="rm-form"';
$form .= ' action="/register-domain/" method="POST">
<input type="text" name="domain" placeholder="Domain">
<input type="submit" value="Search Domain"/>
</form>
';

if (isset ($_GET['domain'])) {
    // Search domain and show spinner
    $resultsDiv = '<div class="rm-results">Domain Found</div>';

    $form .= $resultsDiv;
}

// Output needs to be return
return $form;
} 
// register shortcode
add_shortcode('rm-search-domain', 'rm_search_domain_shortcode');