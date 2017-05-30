<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TerritoriesDomains Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Domains
 * @property \Cake\ORM\Association\BelongsTo $Territories
 * @property \Cake\ORM\Association\BelongsToMany $Scenarios
 * @property \Cake\ORM\Association\BelongsToMany $Studies
 *
 * @method \App\Model\Entity\TerritoriesDomain get($primaryKey, $options = [])
 * @method \App\Model\Entity\TerritoriesDomain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TerritoriesDomain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TerritoriesDomain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TerritoriesDomain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TerritoriesDomain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TerritoriesDomain findOrCreate($search, callable $callback = null, $options = [])
 */
class TerritoriesDomainsTable extends Table
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

        $this->setTable('territories_domains');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Domains', [
            'foreignKey' => 'domain_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Territories', [
            'foreignKey' => 'territory_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Scenarios', [
            'foreignKey' => 'territory_domain_id',
            'targetForeignKey' => 'scenario_id',
            'joinTable' => 'scenarios_territories_domains'
        ]);

        /* added by rom*/
        $this->hasMany('StudiesRulesTerritorialsDomains',[
            'foreignKey' => 'territory_domain_id'
        ]);

        $this->belongsToMany('Studies', [
            'foreignKey' => 'territory_domain_id',
            'targetForeignKey' => 'study_id',
            'through' => 'studies_territories_domains'
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
        $rules->add($rules->existsIn(['territory_id'], 'Territories'));

        return $rules;
    }

    public function getDicofre($id = null)
    {
        $territory = $this->get($id,['contain' => ['Territories' => ['fields' => ['dicofre']]]]);

        return $territory['dicofre'];
    }


}
