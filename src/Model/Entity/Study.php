<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Study Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $domain_id
 * @property int $actual_year
 * @property int $projection_years
 *
 * @property \App\Model\Entity\Domain $domain
 * @property \App\Model\Entity\StudiesRulesTerritorialsDomain[] $studies_rules_territorials_domains
 * @property \App\Model\Entity\TerritoriesDomain[] $territories_domains
 */
class Study extends Entity
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
