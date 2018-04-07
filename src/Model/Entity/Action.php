<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Action Entity
 *
 * @property int $id
 * @property int $link_id
 * @property string $name
 * @property string $url
 * @property string $platform
 * @property string $type
 * @property int $sort
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Link $link
 * @property \App\Model\Entity\Statistic[] $statistics
 */
class Action extends Entity
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
        'link_id' => true,
        'name' => true,
        'url' => true,
        'platform' => true,
        'type' => true,
        'sort' => true,
        'click_count' => true,
        'created' => true,
        'modified' => true,
        'link' => true,
        'statistics' => true,
        'socialMediaId'=>true,
    ];
}
