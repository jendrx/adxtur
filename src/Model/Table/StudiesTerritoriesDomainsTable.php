<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudiesTerritoriesDomains Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Studies
 * @property \Cake\ORM\Association\BelongsTo $TerritoriesDomains
 *
 * @method \App\Model\Entity\StudiesTerritoriesDomain get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudiesTerritoriesDomain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StudiesTerritoriesDomain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudiesTerritoriesDomain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudiesTerritoriesDomain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudiesTerritoriesDomain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudiesTerritoriesDomain findOrCreate($search, callable $callback = null, $options = [])
 */
class StudiesTerritoriesDomainsTable extends Table
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

        $this->setTable('studies_territories_domains');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Studies', [
            'foreignKey' => 'study_id'
        ]);
        $this->belongsTo('TerritoriesDomains', [
            'foreignKey' => 'territory_domain_id'
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
            ->numeric('tax_rehab')
            ->allowEmpty('tax_rehab');

        $validator
            ->numeric('tax_construction')
            ->allowEmpty('tax_construction');

        $validator
            ->numeric('tax_anual_desertion')
            ->allowEmpty('tax_anual_desertion');

        $validator
            ->integer('actual_lodges')
            ->allowEmpty('actual_lodges');

        $validator
            ->numeric('tax_actual_first_lodges')
            ->allowEmpty('tax_actual_first_lodges');

        $validator
            ->numeric('tax_actual_second_lodges')
            ->allowEmpty('tax_actual_second_lodges');

        $validator
            ->numeric('tax_actual_empty_lodges')
            ->allowEmpty('tax_actual_empty_lodges');

        $validator
            ->numeric('total_actual_empty_avail_lodges')
            ->allowEmpty('total_actual_empty_avail_lodges');

        $validator
            ->numeric('total_actual_empty_rehab_lodges')
            ->allowEmpty('total_actual_empty_rehab_lodges');

        $validator
            ->numeric('total_actual_empty_lodges')
            ->allowEmpty('total_actual_empty_lodges');

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

        return $rules;
    }

    public function getTaxesByStudy($id = null, $territories = null)
    {
        $territoriesTaxes = array();
        if($territories != null)
        {
            foreach ($territories as $territory)
            {
                array_push($territoriesTaxes, $this->getTerritoryTaxesByStudy($id,$territory));
            }

            return $territoriesTaxes;
        }

        $territoriesTaxes = $this->find('all',['conditions' => ['StudiesTerritoriesDomains.study_id = ' => $id]])
            ->select([ 'tax_rehab' => 'StudiesTerritoriesDomains.tax_rehab', 'tax_construction' => 'StudiesTerritoriesDomains.tax_construction',
                'tax_anual_desertion' => 'StudiesTerritoriesDomains.tax_anual_desertion', 'territory_domain_id' => 'territories_domains.id',
                'territory_id' => 'territories_domains.territory_id', 'territory_name' => 'Territories.name'])
            ->enableAutoFields(false)
            ->join(['table' => 'territories_domains', 'conditions' => ['StudiesTerritoriesDomains.territory_domain_id = territories_domains.id']])
            ->join(['table' => 'territories', 'conditions' => ['territories_domains.territory_id = territories.id'], 'fields' => ['name']]);

        return $territoriesTaxes;
    }

    public function getTerritoryTaxesByStudy($id, $territory)
    {
        $territoryTaxes = $this->find('all',['conditions' => ['StudiesTerritoriesDomains.study_id = ' => $id, 'StudiesTerritoriesDomains.territory_domain_id = ' => $territory ]])
            ->select([ 'tax_rehab' => 'StudiesTerritoriesDomains.tax_rehab', 'tax_construction' => 'StudiesTerritoriesDomains.tax_construction',
                'tax_anual_desertion' => 'StudiesTerritoriesDomains.tax_anual_desertion', 'territory_domain_id' => 'territories_domains.id',
                'territory_id' => 'territories_domains.territory_id', 'territory_name' => 'Territories.name'])
            ->enableAutoFields(false)
            ->join(['table' => 'territories_domains', 'conditions' => ['StudiesTerritoriesDomains.territory_domain_id = territories_domains.id']])
            ->join(['table' => 'territories', 'conditions' => ['territories_domains.territory_id = territories.id'], 'fields' => ['name']])->first();

        return $territoryTaxes;
    }
}
