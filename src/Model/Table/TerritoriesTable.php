<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Territories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentTerritories
 * @property \Cake\ORM\Association\HasMany $ChildTerritories
 * @property \Cake\ORM\Association\BelongsToMany $Features
 * @property \Cake\ORM\Association\BelongsToMany $Domains
 *
 * @method \App\Model\Entity\Territory get($primaryKey, $options = [])
 * @method \App\Model\Entity\Territory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Territory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Territory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Territory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Territory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Territory findOrCreate($search, callable $callback = null, $options = [])
 */
class TerritoriesTable extends Table
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

        $this->setTable('territories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentTerritories', [
            'className' => 'Territories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildTerritories', [
            'className' => 'Territories',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Features', [
            'foreignKey' => 'territory_id',
            'targetForeignKey' => 'feature_id',
            'joinTable' => 'features_territories'
        ]);
        $this->belongsToMany('Domains', [
            'foreignKey' => 'territory_id',
            'targetForeignKey' => 'domain_id',
            'joinTable' => 'territories_domains'
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
            ->integer('code')
            ->allowEmpty('code');

        $validator
            ->allowEmpty('municipality');

        $validator
            ->allowEmpty('parish');

        $validator
            ->allowEmpty('geom');

        $validator
            ->allowEmpty('geom_geojson');

        $validator
            ->allowEmpty('dicofre');

        $validator
            ->allowEmpty('admin_type');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('s_dicofre');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentTerritories'));

        return $rules;
    }
}
