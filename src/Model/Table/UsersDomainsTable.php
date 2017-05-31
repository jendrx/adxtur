<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersDomains Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Domains
 *
 * @method \App\Model\Entity\UsersDomain get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersDomain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersDomain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersDomain|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersDomain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersDomain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersDomain findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersDomainsTable extends Table
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

        $this->setTable('users_domains');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Domains', [
            'foreignKey' => 'domain_id'
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['domain_id'], 'Domains'));

        return $rules;
    }

    public function isOwnedBy($domain = null, $user = null)
    {
        return $this->exists(['domain_id' => $domain, 'user_id' =>  $user ]);
    }

}
