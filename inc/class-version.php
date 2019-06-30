<?php

namespace GenesisGenerator;

class Version {
	/**
	 * Genesis version installed
	 *
	 * @var string
	 */
	protected $version;

	public function __construct()
	{
		$this->version = wp_get_theme('genesis');
		return $this->version->headers['Version'];
	}
}