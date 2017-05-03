<?php
namespace App\Test\TestCase\Controller;

use App\Controller\StudiesRulesTerritorialsDomainsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\StudiesRulesTerritorialsDomainsController Test Case
 */
class StudiesRulesTerritorialsDomainsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies_rules_territorials_domains',
        'app.studies',
        'app.domains',
        'app.scenarios',
        'app.territories_domains',
        'app.territories',
        'app.features',
        'app.features_territories',
        'app.scenarios_territories_domains',
        'app.studies_territories_domains',
        'app.features_domains',
        'app.types',
        'app.types_domains',
        'app.rules',
        'app.censos'
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
