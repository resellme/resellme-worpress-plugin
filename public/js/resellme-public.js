(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function() {
		var price = 0;
		// Search Domain
		$('#rm-search-domain').on('click', function() {
			$('#rm-search-domain-form').hide();
			var domain = $('#domain-name').val();
			var url = $('#rm-search-domain-url').val();

			var data = {
				action: 'rm_search_domain',
				domain: domain
			};

			// Submit values to local ajax url
			$.post(url, data, function(response) {
				var data = JSON.parse(response);
				var html = '';

				if (data.status == 'available') {
					price = data.selling_price.ZWL;
			        html += '<p> ' + domain + ' is available for $';

			        html += price;
			       	html += ' ZWL</p>';

			        document.getElementById('rm-search-response').innerHTML = html;
					$('#rm-results').show();
				} else {

				}
       		}).catch(error => {
       			// Error
       		});
		});

		// Register Domain
		$('#rm-register-domain').on('click', function() {
			$('#rm-results').hide();
			$('#rm-contact-details').show();
		});

		// Show search again
		$('#rm-search-domain-again').on('click', function() {
			$('#rm-search-domain-form').show();
			$('#rm-results').hide();
		});

		// Hide Contact Details
		$('#rm-submit-contact').on('click', function() {
			$('#rm-contact-details').hide();
			$('#rm-nameservers').show();
		});

		// Submit NS Details
		$('#rm-submit-ns').on('click', function() {
			$('#rm-nameservers').hide();
			
			// Submit Domain
			var domain = $('#domain-name').val();
			var url = $('#rm-search-domain-url').val();

			// contact
			var first_name = $('#first_name').val();
			var last_name = $('#last_name').val();
			var email = $('#email').val();
			var company = $('#company').val();
			var street_address = $('#street_address').val();
			var mobile = $('#mobile').val();
			var core_business = $('#core_business').val();
			var city = $('#city').val();
			var country = $('#country').val();

			// NS
			var ns1 = $('#ns1').val();
			var ns2 = $('#ns2').val();
			var ns3 = $('#ns3').val();
			var ns4 = $('#ns4').val();

			var data = {
				action: 'rm_save_domain',
				domain: domain,
				contact: {
					first_name: first_name,
					last_name: last_name,
					email: email,
					company: company,
					street_address: street_address,
					mobile: mobile,
					core_business: core_business,
					city: city,
					country: country
				},
				nameservers: {
					ns1: ns1,
					ns2: ns2,
					ns3: ns3,
					ns4: ns4
				}
			};

			// Submit values to local ajax url
			$.post(url, data, function(response) {
				if (response == 'saved') {
					$('#rm-payments').show();
				} else {
					//
				}
       		}).fail(function(xhr, status, error) {
       			console.log(error);
       		});
		});

		// Save Details and trigger payments
		$('#rm-complete-order').on('click', function() {
			var domain = $('#domain-name').val();
			var url = $('#rm-search-domain-url').val();

			// Payments
			var payment_phone_number = $('#rm-payment-phone-number').val();

			var url = $('#rm-search-domain-url').val();

			var data = {
				action: 'rm_paynow_express',
				domain: domain,
				amount: price,
				payment_phone_number: payment_phone_number
			};

			// Submit values to local ajax url
			$.post(url, data, function(response) {
				poll(url, response, domain);
       		}).fail(function(xhr, status, error) {
       			console.log(error);
       		});
		});


		// poll payment
		function poll(url, pollUrl,domain) {
			// Submit values to local ajax url
			var data = {
				action: 'rm_paynow_express_poll',
				poll_url: pollUrl,
				domain: domain
			}

			setTimeout(
				$.post(url, data, function(response) {
				if (response == 'paid') {
					// Submit Domain
					var data = {
						action: 'rm_register_domain',
						domain: domain
					};

					$.post(url, data, function(response) {
						console.log(response);
		       		}).fail(function(xhr, status, error) {
		       			console.log(error);
		       		});
					
				} else {
					poll(url, pollUrl, domain);
				}
       		}).catch(error => {
       			// Error
       		}), 10000)
		}

	});

})( jQuery );
