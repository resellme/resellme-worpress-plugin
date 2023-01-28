<?php
// Intiate paymemt
add_action('wp_ajax_rm_paynow_express', 'rm_paynow_express');
add_action( 'wp_ajax_nopriv_rm_paynow_express', 'rm_paynow_express' );

function rm_paynow_express() {
	require_once dirname( __DIR__ ) . '/lib/vendor/autoload.php';
 	global $wpdb; // this is how you get access to the database
 	$amount = $_POST['amount'];
 	$order_id = $_POST['order_id'];
 	$mobile =  $_POST['phone_number'];
     
	$payment_method = (substr($mobile, 0, 5) == '26371') ? 'onemoney' : 'ecocash';

	$paynow = new Paynow\Payments\Paynow(
		'12656',
		'9004368e-35f5-4f6c-8dc5-605f9edd9c83',
		'http://example.com/gateways/paynow/update',
		'http://example.com/return?gateway=paynow'
	);

	$current_user = wp_get_current_user();

	$payment = $paynow->createPayment($order_id, $current_user->user_email);

	$payment->add('Tender-Subs', $amount);

	$response = $paynow->sendMobile($payment, $mobile, $payment_method);

	echo  $response->pollUrl();

    die();
}

function paynow_express_poll_() {
	require_once dirname( __DIR__ ) . '/lib/vendor/autoload.php';
	global $woocommerce;
 	global $wpdb; // this is how you get access to the database
 	$pollUrl = $_POST['poll_url'];
 	$order_id = $_POST['order_id'];

	$paynow = new Paynow\Payments\Paynow(
		'12656',
		'9004368e-35f5-4f6c-8dc5-605f9edd9c83',
		'http://example.com/gateways/paynow/update',
		'http://example.com/return?gateway=paynow'
	);

	$status = $paynow->pollTransaction($pollUrl);

	$order = null;

	if ($status->paid()) {
		$status = 'paid';

		// mark order as paid
		$order = wc_get_order( $order_id );

		if($order){
		   $order->update_status( 'completed', '', true );
		}
	} else {
		$status = 'not_paid';
	}

	echo $status;

    die();
}
