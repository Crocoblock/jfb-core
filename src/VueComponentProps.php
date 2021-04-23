<?php


namespace JFBCore;


trait VueComponentProps {

	public function vue_component_props() {
		return array();
	}

	final public function vue_component_props_string() {
		$result = array();

		foreach ( $this->vue_component_props() as $prop => $value ) {
			$result[] = "$prop=\"$value\"";
		}

		return implode( ' ', $result );
	}

}