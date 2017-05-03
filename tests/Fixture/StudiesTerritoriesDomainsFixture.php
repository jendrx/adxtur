<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StudiesTerritoriesDomainsFixture
 *
 */
class StudiesTerritoriesDomainsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'tax_rehab' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'tax_construction' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'tax_anual_desertion' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'actual_lodges' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'tax_actual_first_lodges' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'tax_actual_second_lodges' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'tax_actual_empty_lodges' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'total_actual_empty_avail_lodges' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'total_actual_empty_rehab_lodges' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'total_actual_empty_lodges' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'study_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'territory_domain_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fki_study_id' => ['type' => 'index', 'columns' => ['study_id'], 'length' => []],
            'fki_territory_domain_id' => ['type' => 'index', 'columns' => ['territory_domain_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'studies_territories_domain_territory_domain_id_study_key' => ['type' => 'unique', 'columns' => ['study_id', 'territory_domain_id'], 'length' => []],
            'study_id' => ['type' => 'foreign', 'columns' => ['study_id'], 'references' => ['studies', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'territory_domain_id' => ['type' => 'foreign', 'columns' => ['territory_domain_id'], 'references' => ['territories_domains', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'tax_rehab' => 1,
            'tax_construction' => 1,
            'tax_anual_desertion' => 1,
            'actual_lodges' => 1,
            'tax_actual_first_lodges' => 1,
            'tax_actual_second_lodges' => 1,
            'tax_actual_empty_lodges' => 1,
            'total_actual_empty_avail_lodges' => 1,
            'total_actual_empty_rehab_lodges' => 1,
            'total_actual_empty_lodges' => 1,
            'study_id' => 1,
            'territory_domain_id' => 1
        ],
    ];
}
