<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
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

    public function getActualLodges($dicofre = null)
    {
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'actual_lodges' => $query->func()->sum('total_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->actual_lodges;
    }

    public function getFirstLodges($dicofre = null)
    {
        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'first_lodges' => $query->func()->sum('total_occupied_first_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->first_lodges;
    }

    public function getSecondLodges($dicofre = null)
    {
        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'second_lodges' => $query->func()->sum('total_occupied_second_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->second_lodges;


    }

    public function getEmptyLodges($dicofre = null)
    {
        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_lodges' => $query->func()->sum('total_empty_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_lodges;

    }

    public function getEmptySaleLodges($dicofre = null)
    {


        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_sale_lodges' => $query->func()->sum('empty_sale_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_sale_lodges;

    }

    public function getLodgesAtAgeGroup($dicofre = null, $rule_id = null)
    {
        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id = ' => $rule_id],'fields' => ['total_lodges']]);

        return  $query->toArray()[0]->total_lodges;

    }

    public function getSomeEmptySaleLodges($dicofre = null, $rule = null)
    {

        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id <= ' => $rule]]);
        $query->select([
            'empty_sale_lodges' => $query->func()->sum('empty_sale_lodges')
        ]);
        return $query->toArray()[0]->empty_sale_lodges;
    }

    public function getEmptyLoanLodges($dicofre = null)
    {

        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_loan_lodges' => $query->func()->sum('empty_loan_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_loan_lodges;
    }

    public function getSomeEmptyLoanLodges($dicofre = null, $rule = null)
    {
        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id <= ' => $rule]]);
        $query->select([
            'empty_loan_lodges' => $query->func()->sum('empty_loan_lodges')
        ]);
        return $query->toArray()[0]->empty_loan_lodges;
    }

    public function getSomeEmptyRehabLodges($dicofre = null, $rule = null)
    {

        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id <= ' => $rule]]);
        $query->select([
            'empty_loan_lodges' => $query->func()->sum('empty_loan_lodges')
        ]);
        return $query->toArray()[0]->empty_loan_lodges;
    }

    public function getEmptyDemolishedLodges($dicofre = null)
    {

        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_demolished_lodges' => $query->func()->sum('empty_demolished_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_demolished_lodges;
    }

    public function getEmptyOtherLodges($dicofre = null)
    {

        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_other_lodges' => $query->func()->sum('empty_other_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_other_lodges;
    }

    public function getEmptyRehabLodges($dicofre = null)
    {

        // get dicofre
        $query = $this->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_rehab_lodges' => $query->func()->sum('total_empty_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_rehab_lodges;
    }


    public function getLodgesDistribution()
    {
        $rulesTable = TableRegistry::get('Rules');

        // get dicofre
        $query = $rulesTable->find('all');
        $query->select([
            'value' => $query->func()->sum('1/(end_age-start_age)::float')
        ]);
        return (float)$query->toArray()[0]->value;

    }

    public function getTerritoryCensosResults($dicofre = null, $projection_years = null, $rules = null, $threshold = null)
    {

        $actual_lodges =  $this->getActualLodges($dicofre);
        $desertion_tax = $this->getDesertionTax($dicofre,$rules);
        $predicted_lodges = $actual_lodges - $desertion_tax;
        $tax_anual_desertion = pow(($predicted_lodges / $actual_lodges),(1/$projection_years)) - 1;

        $tax_actual_first_lodges = $this->getFirstLodges($dicofre) / $actual_lodges;
        $tax_actual_second_lodges = $this->getSecondLodges($dicofre) / $actual_lodges;

        $empty_lodges =  $this->getEmptyLodges($dicofre);
        $tax_actual_empty_lodges = $empty_lodges/ $actual_lodges;
        $total_actual_empty_lodges = $predicted_lodges * $tax_actual_empty_lodges;

        $at_market_lodges = $this->getEmptySaleLodges($dicofre) + $this->getEmptyLoanLodges($dicofre)
            - ($this->getSomeEmptySaleLodges($dicofre,$threshold) + $this->getSomeEmptyLoanLodges($dicofre,$threshold));
        $rehab_lodges = ($this->getEmptyDemolishedLodges($dicofre)
                + $this->getEmptyOtherLodges($dicofre)) + $this->getSomeEmptyLoanLodges($dicofre,$threshold) + $this->getSomeEmptySaleLodges($dicofre,$threshold) ;

        $weight_at_market = $at_market_lodges / ($at_market_lodges + $rehab_lodges);
        $weight_rehab = $rehab_lodges / ($at_market_lodges + $rehab_lodges);

        $total_actual_empty_avail_lodges = $total_actual_empty_lodges * $weight_at_market;
        $total_actual_empty_rehab_lodges = $total_actual_empty_lodges * $weight_rehab;

        return array('actual_lodges' => $actual_lodges,'tax_anual_desertion' => $tax_anual_desertion,'tax_actual_first_lodges' => $tax_actual_first_lodges,
            'tax_actual_second_lodges' => $tax_actual_second_lodges, 'tax_actual_empty_lodges' => $tax_actual_empty_lodges, 'total_actual_empty_lodges' => $total_actual_empty_lodges,
            'total_actual_empty_avail_lodges' => $total_actual_empty_avail_lodges, 'total_actual_empty_rehab_lodges' => $total_actual_empty_rehab_lodges,
            'dicofre' => $dicofre);

    }

    public function getDesertionTax($dicofre = null, $rules = null)
    {
        $tax = 0;

        $lodges_dist = $this->getLodgesDistribution();

        foreach ($rules as $rule)
        {

            $tax =  $tax + ($this->getLodgesAtAgeGroup($dicofre,$rule['rule_id']) * ($rule['value'] / $lodges_dist));

        }

        return $tax;
    }





}
