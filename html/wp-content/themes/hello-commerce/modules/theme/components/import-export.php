<?php
namespace HelloCommerce\Modules\Theme\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\App\Modules\ImportExport\Processes\Import as Elementor_Import;
use Elementor\App\Modules\ImportExport\Processes\Revert as Elementor_Revert;

use HelloCommerce\Includes\Utils;
use HelloCommerce\Modules\Theme\Classes\Runners\Import as Import_Runner;
use HelloCommerce\Modules\Theme\Classes\Runners\Revert as Revert_Runner;

class Import_Export {
	public function register_import_runners( Elementor_Import $import ) {
		$import->register( new Import_Runner() );
	}

	public function register_revert_runners( Elementor_Revert $revert ) {
		$revert->register( new Revert_Runner() );
	}

	public function __construct() {
		if ( Utils::has_pro() ) {
			return;
		}

		add_action( 'elementor/import-export/import-kit', [ $this, 'register_import_runners' ] );
		add_action( 'elementor/import-export/revert-kit', [ $this, 'register_revert_runners' ] );
	}
}
