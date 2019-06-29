<?php 

namespace GenesisGenerator;

class Command {

	protected $slug;
	protected $theme_name = [];
	protected $path;
	protected $author;
	protected $uri;
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
     */
	function __invoke( $args, $assoc_args ) {
		$this->slug = sanitize_text_field( $args[0] );
		$this->author = sanitize_text_field ( $assoc_args['author'] );
		$this->uri = sanitize_url( $assoc_args['uri'] );
		// Extract The Genesis Sample zip file into /tmp/<theme-slug>
		$this->file = new Zipper( $this->slug );
		$this->path = '/tmp/' . $this->slug;
		//Make sure our file exists before continuing on.
		if ( file_exists ( $this->path ) ) {
			\WP_CLI::log( "Folder exists. Continuing.");
			$this->theme_name = $this->split( $this->slug );

			// Call our Iterator to open the files and perform the string replace
			new Iterator( $this->theme_name, $this->path );

		}

		\WP_CLI::success( $this->author . ' ' . $this->uri );
	}
	/**
	 * Returns an array for slug, full 
	 *
	 * @param string $slug
	 * @return array An array of each variation of the slug for replcaements
	 */
	function split( string $slug ) {
		$new['slug'] = $slug;
		$slug = preg_split("/\-/", $slug);
		$new['full'] = ucwords( implode( " ", $slug) );
		$new['underscore'] = implode( "_", $slug);
		return $new;
	}

}

?>