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
	 * Argument passed in as $args
	 *
	 * @var string
	 */
	protected $slug;
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
	 * Author from $assoc_args
	 *
	 * @var string
	 */
	protected $author;
	/**
	 * URI of plugin
	 *
	 * @var [type]
	 */
	protected $uri;
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
	 * : author
	 * ---
	 * default:
	 * ---
	 *
	 * [--uri=<uri>]
	 * : uri
	 * ---
	 * default:
	 * ---
	 * ## EXAMPLES
	 *
	 *     wp scaffold genesis my-theme
	 *
	 * @when after_wp_load
	 *
	 * @param array $args The argument, in this case just a slug to use.
	 * @param array $assoc_args options for the command to be ran.
	 */
	public function __invoke( $args, $assoc_args ) {
		$this->slug   = sanitize_text_field( $args[0] );
		$this->author = sanitize_text_field( $assoc_args['author'] );
		$this->uri    = esc_url_raw( $assoc_args['uri'] );
		// Extract The Genesis Sample zip file into /tmp/<theme-slug>.
		$this->file = new Zipper( $this->slug );
		$this->path = '/tmp/' . $this->slug;
		// Make sure our file exists before continuing on.
		if ( file_exists( $this->path ) ) {
			\WP_CLI::log( 'Folder exists. Continuing.' );
			$this->replace = $this->split( $this->slug );
			// Add StudioPress and studiopress.com to array to search and replace.
			$this->replace['author'] = $this->author;
			$this->replace['uri']    = $this->uri;
			// Call our Iterator to open the files and perform the string replace.
			new Iterator( $this->replace, $this->path );

		}

		\WP_CLI::success( $this->author . ' ' . $this->uri );
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
		return $new;
	}

}


