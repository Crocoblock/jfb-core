<?php


namespace JFBCore\Common;


class MetaQuery {


	/**
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public static function get_json_meta( array $params ) {
		$params = array_merge( array(
			'id' => 0,
			'key' => ''
		), $params );

		[ 'id' => $post_id, 'key' => $key ] = $params;

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		$meta = get_post_meta( $post_id, $key, true );

		return $meta ? json_decode( wp_unslash( $meta ), true ) : array();
	}

	public static function set_json_meta( array $params ) {
		$params = array_merge( array(
			'id' => 0,
			'key' => '',
			'value' => array()
		), $params );

		[ 'id' => $post_id, 'key' => $key, 'value' => $value ] = $params;

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		return update_post_meta( $post_id, $key, wp_unslash( json_encode( $value ) ) );
	}

}