<?php


namespace JFBCore\JetFormBuilder;


class BlocksManager {

	use EditorAssetsManager;
	use WithInit;

	public function plugin_version_compare() {
		return '1.2.0';
	}

	public function fields() {
		return [];
	}

	public function on_plugin_init() {
		add_action( 'jet-form-builder/blocks/register', function ( $manager ) {
			$this->assets_init();

			foreach ( $this->fields() as $block ) {
				$manager->register_block_type( $block );
			}
		} );
	}

	/**
	 * @return void
	 */
	public function before_init_editor_assets() {
		// TODO: Implement before_init_editor_assets() method.
	}
}