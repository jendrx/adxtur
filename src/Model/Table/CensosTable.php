<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Censos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Rules
 *
 * @method \App\Model\Entity\Censo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Censo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Censo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Censo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Censo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Censo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Censo findOrCreate($search, callable $callback = null, $options = [])
 */
class CensosTable extends Table
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

        $this->setTable('censos');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

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
            ->integer('admin_level')
            ->allowEmpty('admin_level');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('dicofre');

        $validator
            ->allowEmpty('lodge_construction_epoch');

        $validator
            ->integer('total_lodges')
            ->allowEmpty('total_lodges');

        $validator
            ->integer('total_occupied_lodges')
            ->allowEmpty('total_occupied_lodges');

        $validator
            ->integer('total_occupied_first_lodges')
            ->allowEmpty('total_occupied_first_lodges');

        $validator
            ->integer('total_occupied_second_lodges')
            ->allowEmpty('total_occupied_second_lodges');

        $validator
            ->integer('total_empty_lodges')
            ->allowEmpty('total_empty_lodges');

        $validator
            ->integer('empty_sale_lodges')
            ->allowEmpty('empty_sale_lodges');

        $validator
            ->integer('empty_loan_lodges')
            ->allowEmpty('empty_loan_lodges');

        $validator
            ->integer('empty_demolished_lodges')
            ->allowEmpty('empty_demolished_lodges');

        $validator
            ->integer('empty_other_lodges')
            ->allowEmpty('empty_other_lodges');

        $validator
            ->integer('classical_falmilies')
            ->allowEmpty('classical_falmilies');

        $validator
            ->integer('inhabitants')
            ->allowEmpty('inhabitants');

        $validator
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['rule_id'], 'Rules'));

        return $rules;
    }
}
