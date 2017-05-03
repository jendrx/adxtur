<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudiesRulesTerritorialsDomainsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudiesRulesTerritorialsDomainsTable Test Case
 */
class StudiesRulesTerritorialsDomainsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudiesRulesTerritorialsDomainsTable
     */
    public $StudiesRulesTerritorialsDomains;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies_rules_territorials_domains',
        'app.studies',
        'app.territories_domains',
        'app.domains',
        'app.scenarios',
        'app.scenarios_territories_domains',
        'app.features',
        'app.features_domains',
        'app.territories',
        'app.features_territories',
        'app.types',
        'app.types_domains',
        'app.scenarios_territories_domains',
        'app.studies_territories_domains',
        'app.rules',
        'app.censos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StudiesRulesTerritorialsDomains') ? [] : ['className' => 'App\Model\Table\StudiesRulesTerritorialsDomainsTable'];
        $this->StudiesRulesTerritorialsDomains = TableRegistry::get('StudiesRulesTerritorialsDomains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StudiesRulesTerritorialsDomains);

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
