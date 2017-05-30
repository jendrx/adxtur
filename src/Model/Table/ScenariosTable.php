<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Scenarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Domains
 * @property \Cake\ORM\Association\BelongsToMany $TerritoriesDomains
 *
 * @method \App\Model\Entity\Scenario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Scenario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Scenario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Scenario|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Scenario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Scenario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Scenario findOrCreate($search, callable $callback = null, $options = [])
 */
class ScenariosTable extends Table
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

        $this->setTable('scenarios');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Domains', [
            'foreignKey' => 'domain_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('TerritoriesDomains', [
            'foreignKey' => 'scenario_id',
            'targetForeignKey' => 'territory_domain_id',
            'joinTable' => 'scenarios_territories_domains'
        ]);
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
            ->requirePresence('name')
            ->notEmpty('name','Name is required!');

        $validator
            ->allowEmpty('description');

        $validator
            ->requirePresence('projection_years')
            ->notEmpty('projection_years','Projection Years is required!');

        $validator
            ->integer('actual_year')
            ->requirePresence('actual_year')
            ->notEmpty('actual_year','Actual year is required!');

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
        $rules->add($rules->existsIn(['domain_id'], 'Domains'));

        return $rules;
    }

    // $id --> domain_id
    public function getProjectionYearsList($id)
    {
        $proj_years = $this->find('list',['keyField' => 'projection_years','valueField' => 'projection_years','conditions' => ['domain_id = ' => $id]]);
        return $proj_years;
    }
}
