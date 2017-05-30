<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rules Model
 *
 * @property \Cake\ORM\Association\HasMany $Censos
 * @property \Cake\ORM\Association\HasMany $StudiesRulesTerritorialsDomains
 *
 * @method \App\Model\Entity\Rule get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Rule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rule findOrCreate($search, callable $callback = null, $options = [])
 */
class RulesTable extends Table
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

        $this->setTable('rules');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Censos', [
            'foreignKey' => 'rule_id'
        ]);
        $this->hasMany('StudiesRulesTerritorialsDomains', [
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
            ->integer('start_age')
            ->requirePresence('start_age', 'create')
            ->notEmpty('start_age');

        $validator
            ->integer('end_age')
            ->requirePresence('end_age', 'create')
            ->notEmpty('end_age');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->numeric('default_value')
            ->allowEmpty('default_value');

        return $validator;
    }


    public function getRule($id)
    {
        $rule = $this->get($id);

        return $rule;
    }

    public function getAllRules($options = null)
    {

        $rules = array();
        if ($options !== null)
        {
            $rules = $this->find('all',['fields' => $options]);
            return $rules;
        }
        $rules = $this->find('all');
        return $rules;
    }

}
