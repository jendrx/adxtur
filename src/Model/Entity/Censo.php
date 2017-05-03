<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Censo Entity
 *
 * @property int $admin_level
 * @property string $name
 * @property string $dicofre
 * @property string $lodge_construction_epoch
 * @property int $total_lodges
 * @property int $total_occupied_lodges
 * @property int $total_occupied_first_lodges
 * @property int $total_occupied_second_lodges
 * @property int $total_empty_lodges
 * @property int $empty_sale_lodges
 * @property int $empty_loan_lodges
 * @property int $empty_demolished_lodges
 * @property int $empty_other_lodges
 * @property int $classical_falmilies
 * @property int $inhabitants
 * @property int $rule_id
 * @property int $id
 *
 * @property \App\Model\Entity\Rule $rule
 */
class Censo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
