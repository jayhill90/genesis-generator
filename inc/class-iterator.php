<?php
/**
 * Iterates through the file system and handles the string replacements.
 *
 * @package GenesisGenerator
 * @since 0.1.0
 */

namespace GenesisGenerator;

class Iterator {
	/**
	 * The opened file's contents
	 *
	 * @var string
	 */

	protected $file;
	/**
	 * List of strings to search for and be replaced
	 *
	 * @var array
	 */
	private $search = [
		'genesis-sample',
		'Genesis Sample',
		'genesis_sample',
		'studiopress.com',
		'StudioPress',
	];
	/**
	 * This stores the replaced string to set.
	 *
	 * @var string
	 */
	protected $meta;
	/**
	 * List of replacement strings for the files
	 *
	 * @var array
	 */
	protected $replace;

	public function __construct( array $slug, string $path ) {

		$this->open( $slug, $path );

	}
	/**
	 * Opens all the files for the theme and calls the replace function
	 *
	 * @param array  $slug
	 * @param string $path
	 * @return void
	 */
	private function open( $slug, $path ) {

		\WP_CLI::log( $path );
		if ( is_dir( $path ) ) {
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator( $path, \RecursiveDirectoryIterator::SKIP_DOTS ),
				\RecursiveIteratorIterator::SELF_FIRST
			);

			foreach ( $iterator as $file ) {
				if ( $file->isFile() ) {
					\WP_CLI::log( var_dump( $iterator->getPathName() ) );
					$this->file = file_get_contents( $iterator->getPathName() );
					$this->meta = $this->replace_genesis( $slug, $this->file );
					$this->file = file_put_contents( $iterator->getPathname(), $this->meta );
				} else {

				}
			}
		}
	}
	/**
	 * Replaces all references from $search with $replace
	 *
	 * @param array  $replace The array of strings to replace
	 * @param string $file The string to run function on
	 * @return string
	 */
	private function replace_genesis( $replace, $file ) {
		return str_replace( $this->search, $replace, $file );
	}
}
