<?php
/**
 * Handles extracting of Zip file from Github
 *
 * @package Genesis_Generator
 * @since 0.1.1
 */

namespace GenesisGenerator;

/**
 * Handles a ZipArchive and extracts to theme root
 */
class Zipper {
	/**
	 * The zip file.
	 *
	 * @var ZipArchive
	 */
	protected $zip;
	/**
	 * Genesis Sample Master URL from Github
	 *
	 * @var string
	 */
	private $genesis = 'https://github.com/studiopress/genesis-sample/archive/master.zip';
	/**
	 * Temp folder to copy to bdfore extracting
	 *
	 * @var string
	 */
	private $tmp = '/tmp/tmp_file.zip';

	/**
	 * Instantiates the ZipArchive and extracts to WordPress theme root.
	 *
	 * @param string $slug The folder name to save the theme into.
	 */
	public function __construct( $slug ) {
		$zip = new \ZipArchive();

		if ( ! copy( $this->genesis, $this->tmp ) ) {
			return \WP_CLI::error( ' Failed to copy temp zip file', true );
		}

		$result = $zip->open( $this->tmp );

		if ( $result ) {
			$zip->extractTo( get_theme_root() );
			$zip->close();
			$rename = rename( get_theme_root() . '/genesis-sample-master', get_theme_root() . '/' . $slug );
			if ( ! $rename ) {
				return \WP_CLI::error( 'Failed to rename temp directory' );

			}
		} else {
			return \WP_CLI::error( 'Failed to open temp zip file', true );
		}
	}
}
