<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Domain Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $actual_year
 * @property int $projection_year
 *
 * @property \App\Model\Entity\Scenario[] $scenarios
 * @property \App\Model\Entity\Study[] $studies
 * @property \App\Model\Entity\Feature[] $features
 * @property \App\Model\Entity\Territory[] $territories
 * @property \App\Model\Entity\Type[] $types
 */
class Domain extends Entity
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
