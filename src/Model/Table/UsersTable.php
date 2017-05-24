<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 5/24/17
 * Time: 2:28 PM
 */

namespace App\Model\Table;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class UsersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setPrimaryKey('id');
    }

    public function validationDefault($validator)
    {
        return $validator
            ->notEmpty('username', 'A username is required')
            ->notEmpty('password', 'A password is required')
            ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'user']],
                'message' => 'Please enter a valid role'
            ]);
    }

}