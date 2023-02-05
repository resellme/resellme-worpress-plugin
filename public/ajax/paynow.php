<?php
// Intiate paymemt
add_action('wp_ajax_rm_paynow', 'rm_paynow');
add_action( 'wp_ajax_nopriv_rm_paynow', 'rm_paynow' );

function rm_paynow() {
 	$amount = $_POST['amount'];
 	$domain =  $_POST['domain'];

	$paynow_id = get_option('paynow_id');
	$paynow_secret = get_option('paynow_secret');
	
	$paynow = new Paynow\Payments\Paynow(
		$paynow_id,
		$paynow_secret,
		home_url('search-domain'),
		home_url('search-domain?gateway=paynow')
	);

	$current_user = wp_get_current_user();

	$payment = $paynow->createPayment($domain, $current_user->user_email);

	$payment->add('Domain Registration', $amount);

	$response = $paynow->send($payment);

	$link = $response->redirectUrl();

	wp_redirect($link);

	echo 'redirected to paynow';

    die();
}
