<?php


namespace JFBCore;


trait BaseRenderField {

	public $args;
	public $args_map;

	abstract public function set_up( ...$args );

	abstract public function render_field( $attrs_string );

	/**
	 * It used in JetFormBuilder Render\Base for naming field template
	 * And in JetEngine & jetFormBuilder it used for naming wp.hook
	 *
	 * @return string
	 */
	abstract public function get_name();

	public function attributes_values() {
		return array();
	}

	public function attributes_map() {
		return array();
	}

	public function args_map() {
		return array();
	}

	private function default_args_map() {
		$this->args_map = array_merge_recursive( array(
			'required' => '',
			'name'     => 'field_name',
			'default'  => ''
		), $this->args_map() );
	}

	final public function get_arg( $key ) {
		return ( isset( $this->args[ $key ] ) ? $this->args[ $key ] : $this->args_map[ $key ] );
	}

	private function save_attributes() {
		$attributes = apply_filters( "jet-fb/attributes/{$this->get_name()}", $this->get_attributes_map() );

		foreach ( $attributes as $name => $value ) {
			$this->add_attribute( $name, $value );
		}
	}

	final public function get_attributes_map() {
		return array_merge_recursive( $this->attributes_map(), $this->attributes_values() );
	}

	final public function get_rendered() {
		$this->default_args_map();
		$this->save_attributes();

		return $this->render_field( $this->get_attributes_string_save() );
	}

	public function get_args( $args_names ) {
		$response = array();

		foreach ( $args_names as $args_name ) {
			$response[ $args_name ] = $this->get_arg( $args_name );
		}

		return $response;
	}
}