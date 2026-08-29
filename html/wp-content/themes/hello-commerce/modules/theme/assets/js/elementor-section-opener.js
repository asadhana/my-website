( function( $ ) {
	$( function() {
		const urlParams = new URLSearchParams( window.location.search );
		const activeSection = urlParams.get( 'active-section' );
		const activeTab = urlParams.get( 'active-tab' );

		if ( ! activeSection && ! activeTab ) {
			return;
		}

		const targetId = activeSection || activeTab;

		const getFirstOpenSection = () => {
			return $( '.elementor-control.elementor-control-type-section.e-open' ).first();
		};

		const openTargetSection = () => {
			const targetSelector = `.elementor-control.elementor-control-${ targetId }`;
			$( targetSelector ).find( '.elementor-panel-heading' ).trigger( 'click' );
		};

		const waitForPanelReady = () => {
			const $firstOpenSection = getFirstOpenSection();

			if ( $firstOpenSection.length ) {
				openTargetSection();
				return;
			}

			const observer = new MutationObserver( () => {
				const $openSection = getFirstOpenSection();
				if ( $openSection.length ) {
					observer.disconnect();
					openTargetSection();
				}
			} );

			const panelContainer = document.querySelector( '#elementor-panel-content-wrapper' ) || document.body;
			observer.observe( panelContainer, {
				childList: true,
				subtree: true,
				attributes: true,
				attributeFilter: [ 'class' ],
			} );
		};

		waitForPanelReady();
	} );
} )( jQuery );
