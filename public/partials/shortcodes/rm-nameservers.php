<?php
// function that runs when shortcode is called
function rm_nameservers_shortcode() { 
 
// Things that you want to do. 
$form = '<form class="rm-form">
<input required name="ns1" placeholder="NS1">
<input required name="ns2" placeholder="NS2">
<input name="ns3" placeholder="NS3">
<input name="ns4" placeholder="NS4">
</form>
';
 
// Output needs to be return
return $form;
} 
// register shortcode
add_shortcode('rm-nameservers', 'rm_nameservers_shortcode');