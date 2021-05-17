<?php


namespace JFBCore;


interface FieldModifierIT {

	public function type(): string;

	public function getFormId(): int;

	public function onRender(): void;

	public function getArgs(): array;

	public function getClass();

	public function renderHandler( $args, $instance ): void;

	public function editorAssets(): void;

	public static function register();

}