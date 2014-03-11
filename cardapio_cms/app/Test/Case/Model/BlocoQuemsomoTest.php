<?php
App::uses('BlocoQuemsomo', 'Model');

/**
 * BlocoQuemsomo Test Case
 *
 */
class BlocoQuemsomoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bloco_quemsomo',
		'app.restaurants'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlocoQuemsomo = ClassRegistry::init('BlocoQuemsomo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlocoQuemsomo);

		parent::tearDown();
	}

}
