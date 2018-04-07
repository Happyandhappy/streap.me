<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Actions Model
 *
 * @property Array $buttonLabels
 * @property \App\Model\Table\LinksTable|\Cake\ORM\Association\BelongsTo $Links
 * @property \App\Model\Table\LinksTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Action get($primaryKey, $options = [])
 * @method \App\Model\Entity\Action newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Action[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Action|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Action patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Action[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Action findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActionsTable extends Table
{

    /**
     * Available button labels
     */
    public $buttonLabels = [
    	'Subscribe' => 'Subscribe',
    	'Favorite' => 'Favorite',
    	'Follow' => 'Follow',
    	'Custom' => 'Custom',
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('actions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Links', [
            'foreignKey' => 'link_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Statistics', [
            'foreignKey' => 'foreign_id',
            'conditions' => ['foreign_table' => $this->table()],
            'dependent' => true
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 32)
            ->notEmpty('name', __('A name is required.'), function($context) {
                return !empty($context['data']['url']);
            });

        $validator
            ->scalar('url')
            ->maxLength('url', 4096)
            ->add('url', 'validUrl', [
                'rule' => 'url',
                'message' => __('Please enter a valid website address.')
            ])
            ->notEmpty('url', __('A URL is required.'), function($context) {
                return !empty($context['data']['name']);
            });

        return $validator;
    }

    /**
     * Individual add validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationIndividualAdd(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 32)
            ->requirePresence('name')
            ->notEmpty('name');

        $validator
            ->scalar('url')
            ->maxLength('url', 4096)
            ->add('url', 'validUrl', [
                'rule' => 'url',
                'message' => __('Please enter a valid website address.')
            ])
            ->requirePresence('url')
            ->notEmpty('url');

        return $validator;
    }

    /**
     * Single field edit validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationSingleFieldEdit(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 32)
            ->notEmpty('name');

        $validator
            ->scalar('url')
            ->maxLength('url', 4096)
            ->add('url', 'validUrl', [
                'rule' => 'url',
                'message' => __('Please enter a valid website address.')
            ])
            ->notEmpty('url');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['link_id'], 'Links'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * afterDelete callback.
     *
     * Update user totals when an action is deleted
     *
     * @param \Cake\Event\Event $event The afterDelete event that was fired.
     * @param \Cake\Datasource\EntityInterface $entity The entity that was deleted.
     * @param \ArrayObject $options The options for the query
     * @return void
     */
    public function afterDelete($event, $entity, $options)
    {
        // Get a user totals table object
        $linksTable = TableRegistry::get('Links');

        // Get the link
        $link = $linksTable->get($entity->link_id);

        // Get a user totals table object
        $userTotalsTable = TableRegistry::get('UserTotals');

        // Update use counts
        $userTotalsTable->updateUseCount($link->user_id);
    }

    /**
     * Check if a custom name is required
     */
    public function isCustomNameRequired($check, $context)
    {
    	if ($context['data']['name'] == 'Custom') {
    		if (strlen($check)) {
    			return true;
    		}
    	}
    	return false;
    }

    /**
     * Validates owner of action
     *
     * @return Bool
     */
    public function isOwnedBy($actionId, $userId)
    {
        return $this->exists(['id' => $actionId, 'user_id' => $userId]);
    }
}
