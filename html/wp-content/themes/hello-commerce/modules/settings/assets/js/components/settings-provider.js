import { createContext, useEffect, useState } from 'react';
import apiFetch from '@wordpress/api-fetch';
import { __ } from '@wordpress/i18n';
import { dispatch } from '@wordpress/data';

export const SettingsContext = createContext();

export const SettingsProvider = ( { children } ) => {
	const [ isLoading, setIsLoading ] = useState( true );
	const [ themeSettings, setThemeSettings ] = useState( {} );
	const [ settingsUpdated, setSettingsUpdated ] = useState( false );
	const [ helloPlusActive, setHelloPlusActive ] = useState( false );
	const [ whatsNew, setWhatsNew ] = useState( [] );
	const themeStyleUrl = document.getElementById( 'ehp-admin-settings' ).dataset.themestyleurl;

	const updateSetting = ( settingsName, settingsValue ) => {
		setThemeSettings( {
			...themeSettings,
			[ settingsName ]: settingsValue,
		} );
		setSettingsUpdated( true );
	};

	useEffect( () => {
		if ( ! settingsUpdated ) {
			return;
		}

		setIsLoading( true );

		apiFetch( {
			path: '/elementor-hello-commerce/v1/theme-settings',
			method: 'POST',
			data: { settings: themeSettings },
		} ).then( async () => {
			dispatch( 'core/notices' ).createNotice(
				'success',
				__( 'Settings Saved', 'hello-commerce' ),
				{
					type: 'snackbar',
					isDismissible: true,
				},
			);
		} ).catch( () => {
			dispatch( 'core/notices' ).createNotice(
				'error',
				__( 'Error when saving settings', 'hello-commerce' ),
				{
					type: 'snackbar',
					isDismissible: true,
				},
			);
		} ).finally( () => {
			setIsLoading( false );
			setSettingsUpdated( false );
		} );
	}, [ settingsUpdated, themeSettings ] );

	useEffect( () => {
		Promise.all( [
			apiFetch( { path: '/elementor-hello-commerce/v1/theme-settings' } ),
			apiFetch( { path: '/elementor-hello-commerce/v1/whats-new' } ),
		] ).then( ( [ settings, whatsNewData ] ) => {
			setHelloPlusActive( settings.hello_plus_active );
			setWhatsNew( whatsNewData );
			setThemeSettings( settings.settings );
		} ).finally( () => {
			setIsLoading( false );
		} );
	}, [] );

	return (
		<SettingsContext.Provider value={ {
			themeSettings,
			updateSetting,
			isLoading,
			helloPlusActive,
			themeStyleUrl,
			whatsNew,
		} }>
			{ children }
		</SettingsContext.Provider>
	);
};
