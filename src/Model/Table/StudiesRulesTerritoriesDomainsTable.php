<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudiesRulesTerritoriesDomains Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Studies
 * @property \Cake\ORM\Association\BelongsTo $TerritoriesDomains
 * @property \Cake\ORM\Association\BelongsTo $Rules
 *
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudiesRulesTerritoriesDomain findOrCreate($search, callable $callback = null, $options = [])
 */
class StudiesRulesTerritoriesDomainsTable extends Table
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

        $this->setTable('studies_rules_territories_domains');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Studies', [
            'foreignKey' => 'study_id'
        ]);
        $this->belongsTo('TerritoriesDomains', [
            'foreignKey' => 'territory_domain_id'
        ]);
        $this->belongsTo('Rules', [
            'foreignKey' => 'rule_id'
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
            ->numeric('value')
            ->requirePresence('value', 'create')
            ->greaterThanOrEqual('value',0)
            ->lessThanOrEqual('value', 1)
            ->notEmpty('value');

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
        $rules->add($rules->existsIn(['study_id'], 'Studies'));
        $rules->add($rules->existsIn(['territory_domain_id'], 'TerritoriesDomains'));
        $rules->add($rules->existsIn(['rule_id'], 'Rules'));

        return $rules;
    }
}
