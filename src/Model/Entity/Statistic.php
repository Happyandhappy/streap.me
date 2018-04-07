<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Statistic Entity
 *
 * @property int $id
 * @property string $foreign_table
 * @property int $foreign_id
 * @property string $operation
 * @property string $ip
 * @property string $country
 * @property string $agent
 * @property string $referrer
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Action[] $actions
 * @property \App\Model\Entity\Link[] $links
 */
class Statistic extends Entity
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
        'foreign_table' => true,
        'foreign_id' => true,
        'operation' => true,
        'ip' => true,
        'country' => true,
        'agent' => true,
        'referrer' => true,
        'created' => true,
        'actions' => true,
        'links' => true
    ];
}
