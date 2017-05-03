<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudiesTerritoriesDomain Entity
 *
 * @property int $id
 * @property float $tax_rehab
 * @property float $tax_construction
 * @property float $tax_anual_desertion
 * @property int $actual_lodges
 * @property float $tax_actual_first_lodges
 * @property float $tax_actual_second_lodges
 * @property float $tax_actual_empty_lodges
 * @property float $total_actual_empty_avail_lodges
 * @property float $total_actual_empty_rehab_lodges
 * @property float $total_actual_empty_lodges
 * @property int $study_id
 * @property int $territory_domain_id
 *
 * @property \App\Model\Entity\Study $study
 * @property \App\Model\Entity\TerritoriesDomain $territories_domain
 */
class StudiesTerritoriesDomain extends Entity
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
