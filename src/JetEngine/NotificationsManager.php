<?php


namespace JFBCore\JetEngine;

abstract class NotificationsManager {

	public $notifications = array();

	/**
	 * @return array
	 */
	abstract public function register_notification();

	public function __construct() {
		if ( $this->can_init() ) {
			$this->add_hooks();
		}
	}

	public function can_init() {
		return function_exists( 'jet_engine' );
	}

	public function add_hooks() {
		add_action( 'init', array( $this, 'setup_notifications' ) );

		add_filter(
			'jet-engine/forms/booking/notification-types',
			array( $this, 'register_notifications' )
		);
	}

	public function setup_notifications() {
		$types = $this->register_notification();

		foreach ( $types as $type ) {
			$this->notifications[ $type->get_id() ] = $type;

			add_action(
				'jet-engine/forms/booking/notifications/fields-after',
				array( $type, 'notification_fields' )
			);

			add_action(
				'jet-engine/forms/booking/notification/' . $type->get_id(),
				array( $type, 'do_action' ), 10, 2
			);
		}
	}


	/**
	 * Register new notification type
	 *
	 * @param $notifications
	 *
	 * @return mixed [type] [description]
	 */
	public function register_notifications( $notifications ) {
		foreach ( $this->notifications as $type ) {
			$notifications[ $type->get_id() ] = $type->get_name();
		}

		return $notifications;
	}

}