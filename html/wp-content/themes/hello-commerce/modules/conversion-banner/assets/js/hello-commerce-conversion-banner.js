import { createRoot } from 'react-dom/client';
import { ConversionBanner } from './components/conversion-banner';
import { ThemeProvider } from '@elementor/ui/styles';

const App = () => {
	return (
		<ThemeProvider colorScheme="auto">
			<ConversionBanner />
		</ThemeProvider>
	);
};

document.addEventListener( 'DOMContentLoaded', () => {
	const container = document.getElementById( 'ehp-admin-cb' );

	if ( container ) {
		let headerEnd = document.querySelector( '.wp-header-end' );

		if ( ! headerEnd ) {
			headerEnd = document.querySelector( '.wrap h1, .wrap h2' );
		}

		if ( headerEnd ) {
			if ( window.ehp_cb.beforeWrap ) {
				const wrapElement = document.querySelector( '.wrap' );
				if ( wrapElement ) {
					wrapElement.insertAdjacentElement( 'beforebegin', container );
				}
			} else {
				headerEnd.insertAdjacentElement( 'afterend', container );
			}
		}

		const root = createRoot( container );
		root.render( <App /> );
	}
} );
