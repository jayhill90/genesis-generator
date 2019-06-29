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
			$zip->extractTo("/tmp");
			$zip->close();
			$rename = rename( '/tmp/genesis-sample-master/', '/tmp' . '/' . $slug );
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