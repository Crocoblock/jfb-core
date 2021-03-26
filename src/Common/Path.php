<?php


namespace JFBCore\Common;


class Path {

	public static function absolute( $path ) {
		return __DIR__ . '../../' . $path;
	}

	public static function assets( $path ) {
		return self::absolute( 'assets/' . $path );
	}

}