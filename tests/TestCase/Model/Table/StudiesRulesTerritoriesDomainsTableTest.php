<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudiesRulesTerritoriesDomainsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudiesRulesTerritoriesDomainsTable Test Case
 */
class StudiesRulesTerritoriesDomainsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudiesRulesTerritoriesDomainsTable
     */
    public $StudiesRulesTerritoriesDomains;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies_rules_territories_domains',
        'app.studies',
        'app.domains',
        'app.scenarios',
        'app.territories_domains',
        'app.territories',
        'app.features',
        'app.features_territories',
        'app.scenarios_territories_domains',
        'app.studies_rules_territorials_domains',
        'app.rules',
        'app.censos',
        'app.studies_territories_domains',
        'app.features_domains',
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
        $config = TableRegistry::exists('StudiesRulesTerritoriesDomains') ? [] : ['className' => 'App\Model\Table\StudiesRulesTerritoriesDomainsTable'];
        $this->StudiesRulesTerritoriesDomains = TableRegistry::get('StudiesRulesTerritoriesDomains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StudiesRulesTerritoriesDomains);

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
