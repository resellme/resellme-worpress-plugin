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
			        html += '<p> ' + domain + ' is available for $';

			        html += data.selling_price.ZWL;
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

		// Hide NS Details
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
				var data = JSON.parse(response);

				alert(data);

				if (data.status == 'registered') {
					$('#rm-registered').show();
				} else {

				}
       		}).fail(function(xhr, status, error) {
       			alert(xhr.responseText)
       			console.log(error);
       		});

		});

		$('#complete-order').on('click', function() {

		});

	});

})( jQuery );
