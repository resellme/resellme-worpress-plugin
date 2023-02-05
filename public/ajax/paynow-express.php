<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Intiate paymemt
add_action('wp_ajax_rm_paynow_express', 'rm_paynow_express');
add_action( 'wp_ajax_nopriv_rm_paynow_express', 'rm_paynow_express' );

add_action('wp_ajax_rm_paynow_express_poll', 'rm_paynow_express_poll');
add_action( 'wp_ajax_nopriv_rm_paynow_express_poll', 'rm_paynow_express_poll' );

function rm_paynow_express() {
 	$amount = $_POST['amount'];
 	$mobile =  $_POST['payment_phone_number'];
 	$domain = $_POST['domain'];
     
	$payment_method = (substr($mobile, 0, 3) == '071') ? 'onemoney' : 'ecocash';
	$paynow_id = get_option('paynow_id');
	$paynow_secret = get_option('paynow_secret');

	$paynow = new Paynow\Payments\Paynow(
		$paynow_id,
		$paynow_secret,
		'http://example.com/gateways/paynow/update',
		'http://example.com/return?gateway=paynow'
	);

	$current_user = wp_get_current_user();

	$payment = $paynow->createPayment($domain, $current_user->user_email);

	$payment->add('Domain Registration', $amount);

	$response = $paynow->sendMobile($payment, $mobile, $payment_method);

	echo  $response->pollUrl();

    die();
}

function rm_paynow_express_poll() {
 	$pollUrl = $_POST['poll_url'];
 	$domain = $_POST['domain'];
 	$paynow_id = get_option('paynow_id');
	$paynow_secret = get_option('paynow_secret');

	$paynow = new Paynow\Payments\Paynow(
		$paynow_id,
		$paynow_secret,
		'http://example.com/gateways/paynow/update',
		'http://example.com/return?gateway=paynow'
	);

	$status = $paynow->pollTransaction($pollUrl);

	if ($status->paid()) {
		$status = 'paid';
	} else {
		$status = 'not_paid';
	}

	echo $status;

    die();
}
