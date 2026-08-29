import Stack from '@elementor/ui/Stack';
import { __ } from '@wordpress/i18n';
import { Setting } from './setting';
import { useSettingsContext } from './use-settings-context';
import { Spinner } from '@wordpress/components';
import SettingsTitle from './settings-title';

export const Seo = () => {
	const {
		themeSettings: { skip_link: skipLink, description_meta_tag: descriptionMetaTag },
		updateSetting,
		isLoading,
	} = useSettingsContext();

	if ( isLoading ) {
		return <Spinner />;
	}

	return (
		<Stack gap={ 2 }>
			<SettingsTitle>
				{ __( 'These settings affect how search engines and assistive technologies interact with your website.', 'hello-commerce' ) }
			</SettingsTitle>
			<Setting
				value={ descriptionMetaTag }
				label={ __( 'Disable description meta tag', 'hello-commerce' ) }
				onSwitchClick={ () => updateSetting( 'description_meta_tag', ! descriptionMetaTag ) }
				description={ __( 'What it does: Removes the description meta tag code from singular content pages.', 'hello-commerce' ) }
				code={ '<meta name="description" content="..." />' }
				tip={ __( 'Tip: If you use an SEO plugin that handles meta descriptions, like Yoast or Rank Math, disable this option to prevent duplicate meta tags.', 'hello-commerce' ) }
			/>
			<Setting
				value={ skipLink }
				label={ __( 'Disable skip links', 'hello-commerce' ) }
				onSwitchClick={ () => updateSetting( 'skip_link', ! skipLink ) }
				description={ __( 'What it does: Removes the "Skip to content" link that helps screen reader users and keyboard navigators jump directly to the main content.', 'hello-commerce' ) }
				code={ '<a class="skip-link screen-reader-text" href="#content">Skip to content</a>' }
				tip={ __( 'Tip: If you use an accessibility plugin that adds a "skip to content" link, disable this option to prevent duplications.', 'hello-commerce' ) }
			/>
		</Stack>
	);
};
