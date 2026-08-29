import Typography from '@elementor/ui/Typography';

const SettingsTitle = ( { children } ) => (
	<Typography variant="subtitle2" sx={ { fontWeight: 'bold', my: 2 } }>
		{ children }
	</Typography>
);

export default SettingsTitle;
