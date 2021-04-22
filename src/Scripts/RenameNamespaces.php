<?php


namespace JFBCore\Scripts;


class RenameNamespaces {

	public static function rename( $event ) {
		$installedPackage = $event->getOperation()->getPackage();

		var_dump( $installedPackage ); die;
	}

}