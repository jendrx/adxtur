<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScenariosTerritoriesDomainsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScenariosTerritoriesDomainsTable Test Case
 */
class ScenariosTerritoriesDomainsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScenariosTerritoriesDomainsTable
     */
    public $ScenariosTerritoriesDomains;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scenarios_territories_domains',
        'app.territories_domains',
        'app.domains',
        'app.scenarios',
        'app.studies',
        'app.features',
        'app.features_domains',
        'app.territories',
        'app.features_territories',
        'app.types',
        'app.types_domains',
        'app.studies_territories_domains'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ScenariosTerritoriesDomains') ? [] : ['className' => 'App\Model\Table\ScenariosTerritoriesDomainsTable'];
        $this->ScenariosTerritoriesDomains = TableRegistry::get('ScenariosTerritoriesDomains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScenariosTerritoriesDomains);

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
