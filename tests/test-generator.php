<?php
/**
 * Class SampleTest
 *
 * @package GenesisGenerator
 */
namespace GenesisGenerator;
use GenesisGenerator;
/**
 * Sample test case.
 */
class SampleTest extends \WP_UnitTestCase {

	/**
	 * Test replace genesis. This should replace instances of Genesis Sample, 
	 * genesis_sample and genesis-sample with a transformed array
	 * 
	 * @dataProvider data_replace_genesis
	 * 
	 * @param string Input value
	 * @param string Expected value
	 */
	public function test_replace_genesis( $input, $expected ) {
		$result = new Iterator( $input, get_theme_root() . '/' . $input[0] );
		$result = $result->replace_genesis(
			$input,
			"genesis-sample Genesis Sample genesis_sample"
		);
		$this->assertInternalType( 'string', $result);
		$this->assertEquals($result, $expected);


	}
	/**
	 * Data provider for test_replace_genesis
	 *
	 * @return void
	 */
	public function data_replace_genesis() {
		return [
			'my-theme transformation' => [
				[
					'my-theme',
					'My Theme',
					'my_theme',
				],
				'my-theme My Theme my_theme',
			],
			'one word theme name' => [
				[
					'darknetcollective',
					'Darknetcollective',
					'darknetcollective',
				],
				'darknetcollective, Darknetcollective darknetcollective',
			],
		];
	}
}
