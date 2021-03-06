<?php
/**
 * The command functionality for scaffolding a Genesis Sample theme
 *
 * @since 0.1.0
 * @package GenesisGenerator
 */

namespace GenesisGenerator;

/**
 * The WP_CLI Command class
 */
class Command {
	/**
	 * Empty array that holds transformed slug and other replacements
	 *
	 * @var array
	 */
	protected $replace = [];

	/**
	 * File path to extract to
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Handle of the zip file
	 *
	 * @var Zipper
	 */
	private $file;

	/**
	 * Scaffolds the Genesis Sample theme
	 *
	 * ## OPTIONS
	 *
	 * <theme-slug>
	 * : The slug of the new theme.
	 *
	 * [--author=<author>]
	 * : Author Name
	 * ---
	 * default: Your Name
	 * ---
	 *
	 * [--uri=<uri>]
	 * : Author URI
	 * ---
	 * default: domain.test
	 * ---
	 *
	 * [--description=<description>]
	 * : Theme description
	 * ---
	 * default:
	 * ---
	 *
	 * [--theme_uri=<theme-uri>]
	 * : Theme URI
	 * ---
	 * default:
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp scaffold genesis my-theme --author="Jay Hill" --uri="wpdev.life" --description="My awesome theme" --theme_uri=testinproduction.systems
	 *
	 * @when after_wp_load
	 *
	 * @param array $args The argument, in this case just a slug to use.
	 * @param array $assoc_args options for the command to be ran.
	 */
	public function __invoke( $args, $assoc_args ) {
		// Geneis-Sample related strings created by split function.
		$this->replace                = $this->split( sanitize_text_field( $args[0] ) );

		//Non Genesis-Sample related strings.
		$this->replace['uri']         = sanitize_text_field( $assoc_args['uri'] );
		$this->replace['author']      = sanitize_text_field( $assoc_args['author'] );
		$this->replace['description'] = sanitize_text_field( $assoc_args['description'] );
		$this->replace['theme_uri']   = sanitize_text_field( $assoc_args['theme_uri'] );

		// Check whether the child theme folder already exists.
		$this->path = get_theme_root() . '/' . $this->replace['slug'];
		if ( file_exists( $this->path )){
			\WP_CLI::error( 'Theme ' . $this->replace['slug'] . ' already exists.' );
		}
		// Extract The Genesis Sample zip file into theme root slug.
		$this->file = new Zipper( $this->replace['slug'] );
		

		// Make sure our file exists before continuing on.
		if ( file_exists( $this->path ) ) {
			// Call our Iterator to open the files and perform the string replace on the filesystem.
			new Iterator( $this->replace, $this->path );

		}

		\WP_CLI::success( 'Created new theme: ' . $this->replace['slug'] );
	}
	/**
	 * Returns an array for slug, full
	 *
	 * @param string $slug The slug to pass in.
	 * @return array An array of each variation of the slug for replacements
	 */
	private function split( string $slug ) {
		$new['slug']       = $slug;
		$slug              = preg_split( '/\-/', $slug );
		$new['full']       = ucwords( implode( ' ', $slug ) );
		$new['underscore'] = implode( '_', $slug );
		$new['landing']    = ucfirst( implode( ' ', $slug ) );
		$new['single']     = ucwords( implode( '', $slug ) );
		$new['upper']      = ucwords( implode( '-', $slug ) );
		return $new;
	}

}
