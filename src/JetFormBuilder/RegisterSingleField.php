<?php


namespace JFBCore\JetFormBuilder;


trait RegisterSingleField {

	use EditorAssetsManager;
	use WithInit;

	public function plugin_version_compare() {
		return '1.2.0';
	}

	public function on_plugin_init() {
		add_action( 'jet-form-builder/blocks/register', function ( $manager ) {
			$block = new static();
			$block->assets_init();

			$manager->register_block_type( $block );
		} );
	}

	/**
	 * For backward compatibility.
	 * Now this value is set via block.json
	 * @return string
	 */
	public function get_title() {
		return '';
	}

	/**
	 * For backward compatibility.
	 * Now this value is set via block.json
	 * @return array
	 */
	public function get_attributes() {
		return array();
	}

}