<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Studies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Domains
 * @property \Cake\ORM\Association\HasMany $StudiesRulesTerritoriesDomains
 * @property \Cake\ORM\Association\BelongsToMany $TerritoriesDomains
 *
 * @method \App\Model\Entity\Study get($primaryKey, $options = [])
 * @method \App\Model\Entity\Study newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Study[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Study|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Study patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Study[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Study findOrCreate($search, callable $callback = null, $options = [])
 */
class StudiesTable extends Table
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

        $this->setTable('studies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Domains', [
            'foreignKey' => 'domain_id'
        ]);
        $this->hasMany('StudiesRulesTerritoriesDomains', [
            'foreignKey' => 'study_id'
        ]);
        $this->belongsToMany('TerritoriesDomains', [
            'foreignKey' => 'study_id',
            'targetForeignKey' => 'territory_domain_id',
            'joinTable' => 'studies_territories_domains' // change to joinTable to test -- 26/05/2017
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
            ->allowEmpty('id','create');

        $validator
            ->add('name', 'notEmpty', [
                'rule' => 'notEmpty',
                'message' => __('You need to provide a title'),]);
            //->requirePresence('name','create')
            //->notEmpty('name','Name is required!');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('actual_year','create')
            ->requirePresence('actual_year','create')
            ->notEmpty('actual_year','Year is required!','create');

        $validator
            ->integer('projection_years')
            ->requirePresence('projection_years','create')
            ->notEmpty('projection_years','Projection Years is required!','create');

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

    // return an array with taxes by territory {tax_construct, tax_rehab, tax_anual_desertion,territory_name, territory_id, territoru_domain_id}
    public function getTaxes($id = null, $territories = null)
    {
        $territoriesTaxes = array();
        if($territories != null)
        {
            foreach ($territories as $territory)
            {
                array_push($territoriesTaxes, $this->getTerritoryTaxes($id,$territory));
            }

            return $territoriesTaxes;
        }

        $territoriesTaxes = $this->find('all',['conditions' => ['Studies.id = ' => $id]])
            ->select([ 'tax_rehab' => 'taxes.tax_rehab', 'tax_construction' => 'taxes.tax_construction', 'tax_anual_desertion' => 'taxes.tax_anual_desertion',
                'territory_domain_id' => 'territories_domains.id', 'territory_id' => 'territories_domains.territory_id', 'territory_name' => 'Territories.name'])
            ->enableAutoFields(false)
            ->join(['table' => 'studies_territories_domains', 'alias' => 'taxes', 'conditions' => ['taxes.study_id = Studies.id']])
            ->join(['table' => 'territories_domains', 'conditions' => ['taxes.territory_domain_id = territories_domains.id']])
            ->join(['table' => 'territories', 'conditions' => ['territories_domains.territory_id = territories.id'], 'fields' => ['name']]);

        return $territoriesTaxes;
    }

    public function getTerritoryTaxes($id, $territory)
    {
        $territoryTaxes = $this->find('all',['conditions' => ['Studies.id = ' => $id]])
            ->select([ 'tax_rehab' => 'taxes.tax_rehab', 'tax_construction' => 'taxes.tax_construction', 'tax_anual_desertion' => 'taxes.tax_anual_desertion',
                'territory_domain_id' => 'territories_domains.id', 'territory_id' => 'territories_domains.territory_id', 'territory_name' => 'Territories.name'])
            ->enableAutoFields(false)
            ->join(['table' => 'studies_territories_domains', 'alias' => 'taxes', 'conditions' => ['taxes.study_id = Studies.id','taxes.territory_domain_id =' => $territory]])
            ->join(['table' => 'territories_domains', 'conditions' => ['taxes.territory_domain_id = territories_domains.id']])
            ->join(['table' => 'territories', 'conditions' => ['territories_domains.territory_id = territories.id'], 'fields' => ['name']])->first();

        return $territoryTaxes;
    }

    public function getTerritories($id = null ,$options = null)
    {
        $territories = array();
        if ($options !== null)
        {
            $territories = $this->find('all',['conditions' => ['Studies.id = ' => $id]])
                ->select([ 'tax_rehab' => 'taxes.tax_rehab', 'tax_construction' => 'taxes.tax_construction', 'tax_anual_desertion' => 'taxes.tax_anual_desertion',
                    'territory_domain_id' => 'territories_domains.id', 'territory_id' => 'territories_domains.territory_id', 'territory_name' => 'Territories.name'])
                ->enableAutoFields(false)
                ->join(['table' => 'studies_territories_domains', 'alias' => 'taxes', 'conditions' => ['taxes.study_id = Studies.id']])
                ->join(['table' => 'territories_domains', 'conditions' => ['taxes.territory_domain_id = territories_domains.id']])
                ->join(['table' => 'territories', 'conditions' => ['territories_domains.territory_id = territories.id'], 'fields' => $options]);

            return $territories;
        }

        $territories = $this->find('all',['conditions' => ['Studies.id = ' => $id]])
            ->select(['territory_domain_id' => 'territories_domains.id'])
            ->enableAutoFields(false)
            ->join(['table' => 'studies_territories_domains', 'alias' => 'taxes', 'conditions' => ['taxes.study_id = Studies.id']])
            ->join(['table' => 'territories_domains', 'conditions' => ['taxes.territory_domain_id = territories_domains.id']])
            ->join(['table' => 'territories', 'conditions' => ['territories_domains.territory_id = territories.id'], 'fields' => ['name']]);


        return array_column($territories->toArray(),'territory_domain_id');
    }

}
