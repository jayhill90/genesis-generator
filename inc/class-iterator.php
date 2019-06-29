<?php

namespace GenesisGenerator;

class Iterator {

	protected $file;
	private $search = [
		'genesis-sample',
		'Genesis Sample',
		'genesis_sample',
		'studiopress.com',
		'StudioPress',
	];
	protected $meta;
	protected $replace;

	function __construct( array $slug, string $path ) {
		
		$this->open($slug, $path);
		
	}

	function open( $slug, $path ) {
		
		\WP_CLI::log( $path);
		if (is_dir( $path ) ) {
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator( $path, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST
			);

			foreach ($iterator as $file ) {
				if ($file->isFile() ) {
					\WP_CLI::log(var_dump( $iterator->getPathName()));
					$this->file = file_get_contents( $iterator->getPathName() );
					$this->meta = $this->replace_genesis( $slug, $this->file);
					$this->file = file_put_contents( $iterator->getPathname(), $this->meta);
				}
				else {

				}
			}
		}
	}

	function replace_genesis( $replace, $file ) {
		return str_replace( $this->search, $replace, $file );
	}
}