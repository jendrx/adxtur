<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
            ->integer('actual_year')
            ->requirePresence('actual_year', 'create')
            ->notEmpty('actual_year');

        $validator
            ->integer('projection_year')
            ->requirePresence('projection_year', 'create')
            ->notEmpty('projection_year');

        $validator
            ->integer('type')
            ->allowEmpty('type');

        return $validator;
    }
}
