<?php


namespace JFBCore;


abstract class BaseNotification {

	public function __construct() {
		add_action(
			'jet-engine/forms/editor/before-assets',
			array( $this, 'register_assets_for_editor' )
		);
	}

	public function register_assets_for_editor() {}

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