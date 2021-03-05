<?php


namespace JFBCore;


abstract class BaseNotification {

	public function __construct() {
		add_action(
			'jet-engine/forms/editor/before-assets',
			array( $this, 'register_assets_for_editor' )
		);
	}

	public function register_assets_for_editor() {
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

	protected function get_action_source() {
		if ( ! ( $this instanceof MessagesHelper ) || ! ( $this instanceof ActionLocalize ) ) {
			return array();
		}

		$action_localize                    = $this->action_data();
		$action_localize['__messages']      = $this->get_messages_default();
		$action_localize['__labels']        = $this->editor_labels();
		$action_localize['__help_messages'] = $this->editor_labels_help();
		$action_localize['__gateway_attrs'] = $this->visible_attributes_for_gateway_editor();

		return json_encode( $action_localize );
	}

}