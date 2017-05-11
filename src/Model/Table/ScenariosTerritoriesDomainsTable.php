<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
require (ROOT.DS.'vendor'.DS.'proloser'.DS.'cakephp-csv'.DS.'src'.DS.'Model'.DS.'Behavior'.DS.'CsvBehavior.php');

/**
 * ScenariosTerritoriesDomains Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TerritoriesDomains
 * @property \Cake\ORM\Association\BelongsTo $Scenarios
 *
 * @method \App\Model\Entity\ScenariosTerritoriesDomain get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScenariosTerritoriesDomain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScenariosTerritoriesDomain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScenariosTerritoriesDomain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScenariosTerritoriesDomain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScenariosTerritoriesDomain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScenariosTerritoriesDomain findOrCreate($search, callable $callback = null, $options = [])
 */


class ScenariosTerritoriesDomainsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {

        parent::initialize($config);

        $this->setTable('scenarios_territories_domains');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TerritoriesDomains', [
            'foreignKey' => 'territory_domain_id'
        ]);
        $this->belongsTo('Scenarios', [
            'foreignKey' => 'scenario_id'
        ]);

        $options = array(
            // Refer to php.net fgetcsv for more information
            'length' => 0,
            'delimiter' => ';',
            'enclosure' => '"',
            'escape' => '\\',
            // Generates a Model.field headings row from the csv file
            'headers' => true,
            // If true, String $content is the data, not a path to the file
            'text' => false,
        );

        $this->addBehavior('CakePHPCSV.Csv',$options);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->integer('closed_population')
            ->allowEmpty('closed_population');

        $validator
            ->integer('migrations')
            ->allowEmpty('migrations');

        $validator
            ->integer('total_population')
            ->allowEmpty('total_population');

        $validator
            ->numeric('habitants_per_lodge')
            ->allowEmpty('habitants_per_lodge');

        $validator
            ->integer('actual_total_population')
            ->allowEmpty('actual_total_population');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['territory_domain_id'], 'TerritoriesDomains'));
        $rules->add($rules->existsIn(['scenario_id'], 'Scenarios'));

        return $rules;
    }
}
