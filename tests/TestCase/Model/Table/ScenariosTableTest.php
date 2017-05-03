<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScenariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScenariosTable Test Case
 */
class ScenariosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScenariosTable
     */
    public $Scenarios;

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
        'app.types',
        'app.types_domains'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Scenarios') ? [] : ['className' => 'App\Model\Table\ScenariosTable'];
        $this->Scenarios = TableRegistry::get('Scenarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Scenarios);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
