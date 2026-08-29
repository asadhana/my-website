import Stack from '@elementor/ui/Stack';
import { __ } from '@wordpress/i18n';
import { Setting } from './setting';
import { useSettingsContext } from './use-settings-context';
import { Spinner } from '@wordpress/components';
import Alert from '@elementor/ui/Alert';
import AlertTitle from '@elementor/ui/AlertTitle';
import SettingsTitle from './settings-title';

export const Theme = () => {
	const {
		themeSettings: { hello_commerce_css: helloCommerceCss, hello_commerce_theme_css: helloCommerceThemeCss },
		updateSetting,
		isLoading,
		themeStyleUrl,
	} = useSettingsContext();

	if ( isLoading ) {
		return <Spinner />;
	}

	return (
		<Stack gap={ 2 }>
			<SettingsTitle>
				{ __( 'These settings allow you to change or remove default Hello Commerce theme styles.', 'hello-commerce' ) }
			</SettingsTitle>
			<Alert severity="warning" sx={ { mb: 2 } } >
				<AlertTitle key="title" sx={ { fontWeight: 'bold' } }>
					{ __( 'Be careful.', 'hello-commerce' ) }
				</AlertTitle>
				{ __( 'Disabling these settings could break your website.', 'hello-commerce' ) }
			</Alert>
			<Setting
				value={ helloCommerceCss }
				label={ __( 'Deregister Hello Commerce hello-commerce-woocommerce.css', 'hello-commerce' ) }
				onSwitchClick={ () => updateSetting( 'hello_commerce_css', ! helloCommerceCss ) }
				description={ __( 'What it does: Turns off the WooCommerce-related CSS the theme adds to your website.', 'hello-commerce' ) }
				code={ `<link rel="stylesheet" href="${ themeStyleUrl }hello-commerce-woocommerce.css" />` }
				tip={ __( 'Tip: Deregistering hello-commerce-woocommerce.css can make your website load faster. Disable it only if you are not using any WooCommerce elements on your website, or if you want to style them yourself.', 'hello-commerce' ) }
			/>
			<Setting
				value={ helloCommerceThemeCss }
				label={ __( 'Deregister Hello Commerce theme.css', 'hello-commerce' ) }
				onSwitchClick={ () => updateSetting( 'hello_commerce_theme_css', ! helloCommerceThemeCss ) }
				description={ __( 'What it does: Turns off CSS reset rules and WordPress style that the theme adds to your website.', 'hello-commerce' ) }
				code={ `<link rel="stylesheet" href="${ themeStyleUrl }theme.css" />` }
				tip={ __( 'Tip: Deregistering theme.css can make your website load faster. Disable it only if you use another style reset method—such as through a child theme—and you do not use any WordPress elements on your website like comments area, pagination box, and image align classes, or if you want to style them yourself..', 'hello-commerce' ) }
			/>
		</Stack>
	);
};
