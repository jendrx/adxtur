<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StudiesRulesTerritorialsDomainsFixture
 *
 */
class StudiesRulesTerritorialsDomainsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'study_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'territory_domain_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'rule_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'value' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'rules_study_territorials_d_study_id_territorial_domain_key' => ['type' => 'unique', 'columns' => ['study_id', 'territory_domain_id', 'rule_id'], 'length' => []],
            'rule_key' => ['type' => 'foreign', 'columns' => ['rule_id'], 'references' => ['rules', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'study_key' => ['type' => 'foreign', 'columns' => ['study_id'], 'references' => ['studies', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'study_id' => 1,
            'territory_domain_id' => 1,
            'rule_id' => 1,
            'value' => 1
        ],
    ];
}
