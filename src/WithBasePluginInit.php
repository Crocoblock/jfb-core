<?php


namespace JFBCore;


use JFBCore\Exceptions\BaseHandlerException;

trait WithBasePluginInit {

	public static function register() {
		( new static() )->plugin_maybe_init();
	}

	private function __construct() {
	}

	abstract public function base_condition(): bool;

	final public function plugin_maybe_init() {
		$init_function = function () {
			$isset_base_plugin = $this->base_condition();
			if ( $isset_base_plugin && $this->can_init() ) {

				$this->on_plugin_init();
			} elseif ( $isset_base_plugin ) {
				$this->on_base_need_update();
			} else {
				$this->on_base_need_install();
			}
		};

		$this->customize_init( $init_function );
	}

	public function customize_init( $callable ) {
		call_user_func( $callable );
	}

	abstract public function plugin_version_compare(): string;

	abstract public function can_init(): bool;

	abstract public function on_plugin_init();

	/**
	 * @throws BaseHandlerException
	 */
	public function on_base_need_update() {
		throw new BaseHandlerException( 'required_plugin_version' );
	}

	/**
	 * @throws BaseHandlerException
	 */
	public function on_base_need_install() {
		throw new BaseHandlerException( 'required_plugin' );
	}

	/**
	 * @param string $type
	 * @param string $message
	 */
	protected function add_admin_notice( string $type, string $message ) {
		add_action( 'admin_notices', function () use ( $type, $message ) {
			$class = "notice notice-{$type}";
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses_post( $message ) );
		} );
	}
}