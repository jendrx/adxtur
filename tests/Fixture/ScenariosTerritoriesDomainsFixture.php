<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ScenariosTerritoriesDomainsFixture
 *
 */
class ScenariosTerritoriesDomainsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'closed_population' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'migrations' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'total_population' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'habitants_per_lodge' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'territory_domain_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'scenario_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'actual_total_population' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'scenarios_territories_domain_territory_domain_id_scenari_key' => ['type' => 'unique', 'columns' => ['territory_domain_id', 'scenario_id'], 'length' => []],
            'scenario_key' => ['type' => 'foreign', 'columns' => ['scenario_id'], 'references' => ['scenarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'territory_domain_key' => ['type' => 'foreign', 'columns' => ['territory_domain_id'], 'references' => ['territories_domains', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'closed_population' => 1,
            'migrations' => 1,
            'total_population' => 1,
            'habitants_per_lodge' => 1,
            'territory_domain_id' => 1,
            'scenario_id' => 1,
            'actual_total_population' => 1
        ],
    ];
}
