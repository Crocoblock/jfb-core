<?php


namespace JFBCore\JetFormBuilder;




use JFBCore\BaseRenderField;

trait RenderBlock {

	use BaseRenderField;

	public function set_up( ...$args ) {
		$this->args = $this->block_type->block_attrs;

		return $this;
	}

	public function attributes_map() {
		return array(
			'class'           => array( 'jet-form-builder__field' ),
			'required'        => $this->block_type->get_required_val( $this->args ),
			'name'            => $this->block_type->get_field_name( $this->get_arg( 'name' ) ),
			'id'              => $this->block_type->get_field_id( $this->args ),
			'data-field-name' => $this->get_arg( 'name' ),
			'value'           => $this->get_arg( 'default' ),
		);
	}


}