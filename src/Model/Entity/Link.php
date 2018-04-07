<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Link Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $url
 * @property string $slug
 * @property int $success_count
 * @property int $view_count
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Action[] $actions
 */
class Link extends Entity
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
        'user_id' => true,
        'slug' => true,
        'name' => true,
        'heading' => true,
        'button_label' => true,
        'url' => true,
        'success_count' => true,
        'view_count' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'actions' => true
    ];

    /**
     * Virtual Field: short_url
     */
    protected function _getShortUrl()
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/' . h($this->_properties['slug']);
    }
}
