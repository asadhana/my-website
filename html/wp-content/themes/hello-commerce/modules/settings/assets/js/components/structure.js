import Stack from '@elementor/ui/Stack';
import { __ } from '@wordpress/i18n';
import { Setting } from './setting';
import { useSettingsContext } from './use-settings-context';
import { Spinner } from '@wordpress/components';
import SettingsTitle from './settings-title';

export const Structure = () => {
	const {
		themeSettings: { header_footer: headerFooter, page_title: pageTitle },
		updateSetting,
		isLoading,
	} = useSettingsContext();

	if ( isLoading ) {
		return <Spinner />;
	}

	return (
		<Stack gap={ 2 }>
			<SettingsTitle>
				{ __( 'These settings relate to the structure of your pages.', 'hello-commerce' ) }
			</SettingsTitle>
			<Setting
				value={ headerFooter }
				label={ __( 'Disable theme header and footer', 'hello-commerce' ) }
				onSwitchClick={ () => updateSetting( 'header_footer', ! headerFooter ) }
				description={ __( 'What it does: Removes the theme\'s default header and footer sections from every page, along with their associated CSS/JS files.', 'hello-commerce' ) }
				code={ '<header id="site-header" class="site-header"> ... </header>\n' +
					'<footer id="site-footer" class="site-footer"> ... </footer>' }
				tip={ __( 'Tip: If you use a plugin like Elementor Pro for your headers and footers, disable the theme header and footer to improve performance.', 'hello-commerce' ) }
			/>
			<Setting
				value={ pageTitle }
				label={ __( 'Hide page title', 'hello-commerce' ) }
				onSwitchClick={ () => updateSetting( 'page_title', ! pageTitle ) }
				description={ __( 'What it does: Removes the main page title above your page content.', 'hello-commerce' ) }
				code={ '<div class="page-header"><h1 class="entry-title">Post title</h1></div>' }
				tip={ __( 'Tip: If you do not want to display page titles or are using Elementor widgets to display your page titles, hide the page title.', 'hello-commerce' ) }
			/>
		</Stack>
	);
};
