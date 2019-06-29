<?php

namespace GenesisGenerator;

class Zipper {
	protected $zip;
	private $genesis = 'https://github.com/studiopress/genesis-sample/archive/master.zip';
	private $tmp = '/tmp/tmp_file.zip';

	function __construct( $slug ) {
		$zip = new \ZipArchive();

		if ( !copy($this->genesis, $this->tmp ) ) {
			return \WP_CLI::error(" Failed to copy temp zip file", true);
		}

		$result = $zip->open( $this->tmp );

		if ( $result ) {
			$zip->extractTo( get_theme_root() );
			$zip->close();
			
			$rename = rename( get_theme_root() . '/genesis-sample-master', get_theme_root() . '/' . $slug );
			if ( $rename ) {
				\WP_CLI::log( "Renamed temp directory") ;
			}
			else {
				return \WP_CLI::error( "Failed to rename temp directory" );
			}
		}
		else {
			return \WP_CLI::error( "Failed to open temp zip file" , true); 
		}
	}


}