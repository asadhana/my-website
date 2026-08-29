import { BaseAdminPaper } from './base-admin-paper';
import Stack from '@elementor/ui/Stack';
import { ColumnLinkGroup } from '../linkGroup/column-link-group';
import { __ } from '@wordpress/i18n';
import { useAdminContext } from '../../hooks/use-admin-context';

export const ShopSettings = () => {
	const { adminSettings: { shopSettings = {}, config = {} } } = useAdminContext();
	const { shopSettings: shopSettingsLinks = [], shopStyle = [], recentProducts = [] } = shopSettings;
	const { isWooCommerceActive = false, isElementorActive = false } = config;

	if ( ! isWooCommerceActive ) {
		return null;
	}

	return (
		<BaseAdminPaper>
			<Stack direction="row" gap={ 12 }>
				<ColumnLinkGroup
					title={ __( 'Shop Settings', 'hello-commerce' ) }
					links={ shopSettingsLinks }
					sx={ { width: '25%' } }
				/>
				{ isElementorActive && (
					<ColumnLinkGroup
						title={ __( 'Shop Style', 'hello-commerce' ) }
						links={ shopStyle }
						sx={ { width: '25%' } }
					/>
				) }
				{ 0 !== recentProducts.length && (
					<ColumnLinkGroup
						title={ __( 'Recent Products', 'hello-commerce' ) }
						links={ recentProducts }
						sx={ { width: '25%' } }
					/>
				) }
			</Stack>
		</BaseAdminPaper>
	);
};
