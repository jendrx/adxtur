<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TerritoriesDomainsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TerritoriesDomainsTable Test Case
 */
class TerritoriesDomainsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TerritoriesDomainsTable
     */
    public $TerritoriesDomains;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.territories_domains',
        'app.domains',
        'app.scenarios',
        'app.scenarios_territories_domains',
        'app.studies',
        'app.studies_rules_territorials_domains',
        'app.rules',
        'app.censos',
        'app.studies_territories_domains',
        'app.features',
        'app.features_domains',
        'app.territories',
        'app.features_territories',
        'app.types',
        'app.types_domains',
        'app.scenarios_territories_domains'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TerritoriesDomains') ? [] : ['className' => 'App\Model\Table\TerritoriesDomainsTable'];
        $this->TerritoriesDomains = TableRegistry::get('TerritoriesDomains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TerritoriesDomains);

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
