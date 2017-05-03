<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ScenariosTerritoriesDomain Entity
 *
 * @property int $id
 * @property int $closed_population
 * @property int $migrations
 * @property int $total_population
 * @property float $habitants_per_lodge
 * @property int $territory_domain_id
 * @property int $scenario_id
 * @property int $actual_total_population
 *
 * @property \App\Model\Entity\TerritoriesDomain $territories_domain
 * @property \App\Model\Entity\Scenario $scenario
 */
class ScenariosTerritoriesDomain extends Entity
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
