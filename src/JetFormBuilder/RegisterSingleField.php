<?php


namespace JFBCore\JetFormBuilder;


trait RegisterSingleField {

	use EditorAssetsManager;

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

	public static function register() {
		if ( ! function_exists( 'jet_form_builder' ) ) {
			return;
		}

		add_action( 'jet-form-builder/blocks/register', function ( $manager ) {
			$block = new static();
			$block->assets_init();

			$manager->register_block_type( $block );
		} );
	}

}