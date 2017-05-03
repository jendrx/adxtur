<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ScenariosController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ScenariosController Test Case
 */
class ScenariosControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scenarios',
        'app.domains',
        'app.studies',
        'app.features',
        'app.features_domains',
        'app.territories',
        'app.features_territories',
        'app.territories_domains',
        'app.scenarios_territories_domains',
        'app.studies_territories_domains',
        'app.scenarios_territories_domains',
        'app.types',
        'app.types_domains'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
