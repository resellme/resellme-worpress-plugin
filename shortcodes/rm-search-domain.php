<?php
// function that runs when shortcode is called
function rm_search_domain_shortcode() { 
 
// Things that you want to do. 
$form = '<form class="rm-form">
<input name="name" placeholder="Domain">
</form>
';
 
// Output needs to be return
return $form;
} 
// register shortcode
add_shortcode('rm-search-domain', 'rm_search_domain_shortcode');