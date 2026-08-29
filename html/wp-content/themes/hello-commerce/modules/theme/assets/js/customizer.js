import { __ } from '@wordpress/i18n';
//ad a click listener for a button
document.querySelector( '#customize-theme-controls' ).addEventListener( 'click', async function( event ) {
	if ( ! event.target.matches( '#ehp-begin-setup' ) ) {
		return;
	}

	event.preventDefault();

	try {
		if ( window.ehp_customizer.redirectTo ) {
			window.location.href = window.ehp_customizer.redirectTo;
			return;
		}

		const data = {
			_wpnonce: window.ehp_customizer.nonce,
			slug: 'hello-plus',
		};

		const response = await wp.ajax.post( 'hello_commerce_install_hp', data );

		if ( response.activateUrl ) {
			window.location.href = response.activateUrl;
		} else {
			throw new Error();
		}
	} catch ( error ) {
		// eslint-disable-next-line no-alert
		alert(
			__(
				'Something went wrong. Please try again later. You can also contact our support at: wordpress.org/plugins/hello-plus',
				'hello-commerce',
			),
		);
	}
} );
