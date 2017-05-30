<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Domains Model
 *
 * @property \Cake\ORM\Association\HasMany $Scenarios
 * @property \Cake\ORM\Association\HasMany $Studies
 * @property \Cake\ORM\Association\BelongsToMany $Features
 * @property \Cake\ORM\Association\BelongsToMany $Territories
 * @property \Cake\ORM\Association\BelongsToMany $Types
 *
 * @method \App\Model\Entity\Domain get($primaryKey, $options = [])
 * @method \App\Model\Entity\Domain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Domain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Domain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Domain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Domain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Domain findOrCreate($search, callable $callback = null, $options = [])
 */
class DomainsTable extends Table
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

        $this->setTable('domains');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Scenarios', [
            'foreignKey' => 'domain_id'
        ]);
        $this->hasMany('Studies', [
            'foreignKey' => 'domain_id'
        ]);
        $this->belongsToMany('Features', [
            'foreignKey' => 'domain_id',
            'targetForeignKey' => 'feature_id',
            'joinTable' => 'features_domains'
        ]);
        $this->belongsToMany('Territories', [
            'foreignKey' => 'domain_id',
            'targetForeignKey' => 'territory_id',
            'joinTable' => 'territories_domains'
        ]);
        $this->belongsToMany('Types', [
            'foreignKey' => 'domain_id',
            'targetForeignKey' => 'type_id',
            'joinTable' => 'types_domains'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('actual_year');

        $validator
            ->integer('projection_year');

        $validator
            ->integer('type')
            ->allowEmpty('type');

        return $validator;
    }


    public function getTerritories($id = null,$fields = null)
    {
        if ($fields === null) {
            $domain = $this->get($id, ['contain' => ['Territories']]);
        }
        else{
            array_push($fields,'TerritoriesDomains.domain_id');
            $domain = $this->get($id, ['contain' => ['Territories' =>['fields' => $fields]]]);
        }

        return $domain['territories'];
    }

    public function getStudies($id = null)
    {

        $domain =$this->get($id,['contain' =>['Studies']]);
        return $domain['studies'];

    }

    public function getScenarios($id = null)
    {
        $domain =$this->get($id,['contain' =>['Scenarios']]);
        return $domain['scenarios'];
    }

    public function getCentroid($id = null)
    {
        $conn = ConnectionManager::get('default');

        $stmt = $conn->prepare('Select row_to_json(row) as centroid  from 
                                      (Select ST_X(centroid) as lon, ST_Y(centroid) as lat  From  ( Select ST_Centroid( ST_UNION(
		(SELECT ARRAY(select geom from territories_domains inner join territories on territories.id = territory_id where domain_id =:d_id)))) as centroid) p) row');

        $stmt->bindValue('d_id',$id,'integer');

        $stmt->execute();
        $row = $stmt->fetch('assoc')['centroid'];

        return $row;

    }

}
