<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudiesRulesTerritoriesDomain Entity
 *
 * @property int $id
 * @property int $study_id
 * @property int $territory_domain_id
 * @property int $rule_id
 * @property float $value
 *
 * @property \App\Model\Entity\Study $study
 * @property \App\Model\Entity\TerritoriesDomain $territories_domain
 * @property \App\Model\Entity\Rule $rule
 */
class StudiesRulesTerritoriesDomain extends Entity
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
