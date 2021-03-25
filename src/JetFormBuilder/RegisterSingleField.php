<?php


namespace JFBCore\JetFormBuilder;


trait RegisterSingleField {

	use EditorAssetsManager;

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