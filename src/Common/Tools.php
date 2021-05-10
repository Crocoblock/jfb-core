<?php


namespace JFBCore\Common;


class Tools {

	/**
	 * Prepare passed array for using in JS options
	 *
	 * @param array $array
	 * @param null $value_key
	 * @param null $label_key
	 * @param bool $for_elementor
	 *
	 * @return array
	 */
	public static function prepare_list_for_js( $array = array(), $value_key = null, $label_key = null, $for_elementor = false ) {

		$result = array();

		if ( ! is_array( $array ) || empty( $array ) ) {
			return $result;
		}

		foreach ( $array as $key => $item ) {

			$value = null;
			$label = null;

			if ( is_object( $item ) ) {
				$value = $item->$value_key;
				$label = $item->$label_key;
			} elseif ( is_array( $item ) ) {
				$value = $item[ $value_key ];
				$label = $item[ $label_key ];
			} else {
				$value = $key;
				$label = $item;
			}

			if ( $for_elementor ) {
				$result[ $value ] = $label;
			} else {
				$result[] = array(
					'value' => $value,
					'label' => $label,
				);
			}
		}

		return $result;

	}

	public static function with_placeholder( $array, $label = '--' ) {
		return array_merge(
			array(
				array( 'label' => $label, 'value' => '' ),
			),
			$array
		);
	}

}