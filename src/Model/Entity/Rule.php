<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rule Entity
 *
 * @property int $id
 * @property int $start_age
 * @property int $end_age
 * @property string $description
 * @property float $default_value
 *
 * @property \App\Model\Entity\Censo[] $censos
 * @property \App\Model\Entity\StudiesRulesTerritorialsDomain[] $studies_rules_territorials_domains
 */
class Rule extends Entity
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
