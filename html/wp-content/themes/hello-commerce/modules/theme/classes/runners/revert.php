<?php

namespace HelloCommerce\Modules\Theme\Classes\Runners;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\App\Modules\ImportExport\Runners\Revert\Revert_Runner_Base;

class Revert extends Revert_Runner_Base {

	public static function get_name(): string {
		return 'woocommerce-settings';
	}

	public function should_revert( array $data ): bool {
		return isset( $data['runners'][ static::get_name() ] );
	}

	public function revert( array $data ) {
		$data = $data['runners'][ static::get_name() ];

		$previous_pages = $data['previous_pages'];

		foreach ( $previous_pages as $key => $value ) {
			update_option( $key, $value );
		}
	}
}
