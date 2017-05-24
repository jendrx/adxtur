<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 5/24/17
 * Time: 3:29 PM
 */

namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;


class User extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _setPassword($password)
    {
        if(strlen($password) > 0)
        {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

}