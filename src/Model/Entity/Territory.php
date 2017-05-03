<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Territory Entity
 *
 * @property int $id
 * @property int $code
 * @property string $municipality
 * @property string $parish
 * @property string $geom
 * @property $geom_geojson
 * @property string $dicofre
 * @property string $admin_type
 * @property string $name
 * @property int $parent_id
 * @property string $s_dicofre
 *
 * @property \App\Model\Entity\ParentTerritory $parent_territory
 * @property \App\Model\Entity\ChildTerritory[] $child_territories
 * @property \App\Model\Entity\Feature[] $features
 * @property \App\Model\Entity\Domain[] $domains
 */
class Territory extends Entity
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
