<?php


namespace JFBCore\JetEngine;


abstract class BaseNotification {

	public function __construct() {
		add_action(
			'jet-engine/forms/editor/before-assets',
			array( $this, 'register_assets_before' )
		);
		add_action(
			'jet-engine/forms/editor/assets',
			array( $this, 'register_assets' )
		);
	}

	public function register_assets() {
	}

	public function register_assets_before() {
	}

	/**
	 * Fires on
	 * 'jet-engine/forms/booking/notifications/fields-after' action
	 *
	 * @return mixed
	 */
	abstract public function notification_fields();

	/**
	 * Fires on
	 * 'jet-engine/forms/booking/notification/<notification_id>' action
	 *
	 * @param $settings array
	 * @param $notifications 'Jet_Engine_Booking_Forms_Notifications'
	 *
	 * @return mixed
	 */
	abstract public function do_action( array $settings, $notifications );

}