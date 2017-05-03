<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TerritoriesDomain Entity
 *
 * @property int $id
 * @property int $domain_id
 * @property int $territory_id
 *
 * @property \App\Model\Entity\Domain $domain
 * @property \App\Model\Entity\Territory $territory
 * @property \App\Model\Entity\Scenario[] $scenarios
 * @property \App\Model\Entity\Study[] $studies
 */
class TerritoriesDomain extends Entity
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
