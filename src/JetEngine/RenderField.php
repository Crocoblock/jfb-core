<?php


namespace JFBCore\JetEngine;


use JFBCore\AttributesTrait;
use JFBCore\BaseRenderField;

trait RenderField {

	use AttributesTrait;
	use BaseRenderField;

	private $builder;

	public function set_up( ...$args ) {
		$this->args = $args[0];
		$this->builder = $args[1];

		return $this;
	}

	public function attributes_map() {
		return array(
			'class'           => array( 'jet-form__field' ),
			'required'        => $this->builder->get_required_val( $this->args ),
			'name'            => $this->builder->get_field_name( $this->get_arg( 'name' ) ),
			'id'              => $this->builder->get_field_id( $this->args ),
			'data-field-name' => $this->get_arg( 'name' ),
			'value'           => $this->get_arg( 'default' ),
		);
	}
}