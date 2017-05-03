<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DomainsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DomainsTable Test Case
 */
class DomainsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DomainsTable
     */
    public $Domains;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.domains',
        'app.scenarios',
        'app.studies',
        'app.features',
        'app.features_domains',
        'app.territories',
        'app.territories_domains',
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
        $config = TableRegistry::exists('Domains') ? [] : ['className' => 'App\Model\Table\DomainsTable'];
        $this->Domains = TableRegistry::get('Domains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Domains);

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
}
