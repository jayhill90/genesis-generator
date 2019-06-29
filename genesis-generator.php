<?php
/**
 * Plugin Name:     Genesis Generator
 * Plugin URI:      https://wpdev.life
 * Description:     Adds a WP-CLI command to scaffold a Genesis Sample theme
 * Author:          Jay Hill
 * Author URI:      https://wpdev.life
 * Text Domain:     genesis-generator
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Genesis_Generator
 */

namespace GenesisGenerator;

use \WP_CLI;

if ( ! defined( 'WP_CLI' ) ) {
	return;
}

spl_autoload_register(
	function ( $class ) {
		$base_dir = __DIR__ . '/inc/';
		$len      = strlen( __NAMESPACE__ );
		if ( strncmp( __NAMESPACE__, $class, $len ) !== 0 ) {
			return;
		}
		// Remove the namespace prefix.
		// Replace namespace separators with directory separators in the class name.
		// Replace underscores with dashes in the class name.
		// Append with .php extension.
		$class_file_name = str_replace( [ '\\', '_' ], [ '/', '-' ], strtolower( substr( $class, $len + 1 ) ) ) . '.php';
		// Add `class-` to file name so we meet WPCS standards.
		$class_file_name = preg_replace( '/([\w-]+)\.php/', 'class-$1.php', $class_file_name );
		$file            = $base_dir . $class_file_name;
		// If the file exists, require it.
		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

$scaffold = new Command();

WP_CLI::add_command( 'scaffold genesis', $scaffold );
