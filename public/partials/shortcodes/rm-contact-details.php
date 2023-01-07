<?php
// function that runs when shortcode is called
function rm_contact_details_shortcode() { 
 
// Things that you want to do. 
$form = '<form class="rm-form>
<input name="name">
</form>
';
 
// Output needs to be return
return $form;
} 
// register shortcode
add_shortcode('rm-contact-details', 'rm_contact_details_shortcode');