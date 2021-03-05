<?php


namespace JFBCore;

abstract class JEFNotificationsManager {

	public $notifications = array();

	const ENGINE_HANDLE = 'jet-fb-action-localize-helper';

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

		add_action(
			'jet-engine/forms/editor/before-assets',
			array( $this, 'localize_notifications_for_editor' ), 0
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

	public function localize_notifications_for_editor() {
		self::register_action_localize_helper();
		self::localize_action_types( $this->notifications );
	}

	public static function localize_action_types( $types, $handle = self::ENGINE_HANDLE ) {
		wp_localize_script(
			$handle,
			'jetFormActionTypes',
			self::prepare_actions_data( $types, $handle )
		);
	}

	public static function register_action_localize_helper() {
		wp_enqueue_script(
			self::ENGINE_HANDLE,
			JET_FORM_BUILDER_URL . 'assets/js/action-localize-helper.js',
			array(),
			JET_FORM_BUILDER_VERSION
		);
	}

	public static function prepare_actions_data( $source, $handle ) {
		$prepared_types = array();

		foreach ( $source as $type ) {

			$type_script_name = $type->self_script_name();

			$prepared_types[] = array(
				'id'       => $type->get_id(),
				'name'     => $type->get_name(),
				'self'     => $type_script_name,
				'callback' => false, // should be rewritten from JS
			);
			$action_localize  = $type->action_data();

			$action_localize['__messages']      = $type->get_messages_default();
			$action_localize['__labels']        = $type->editor_labels();
			$action_localize['__help_messages'] = $type->editor_labels_help();
			$action_localize['__gateway_attrs'] = $type->visible_attributes_for_gateway_editor();

			if ( ! empty( $action_localize ) && $type_script_name ) {
				wp_localize_script(
					$handle,
					$type->self_script_name(),
					$action_localize
				);
			}
		}

		return $prepared_types;
	}

}