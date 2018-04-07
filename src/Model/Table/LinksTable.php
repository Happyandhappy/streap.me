<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Links Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ActionsTable|\Cake\ORM\Association\HasMany $Actions
 * @property \App\Model\Table\ActionsTable|\Cake\ORM\Association\HasMany $Statistics
 *
 * @method \App\Model\Entity\Link get($primaryKey, $options = [])
 * @method \App\Model\Entity\Link newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Link[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Link|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Link patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Link[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Link findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LinksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('links');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Actions', [
            'foreignKey' => 'link_id',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->allowEmpty('id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name')
            ->notEmpty('name');

        $validator
            ->scalar('heading')
            ->maxLength('heading', 255)
            ->requirePresence('heading')
            ->notEmpty('heading');

        $validator
            ->scalar('button_label')
            ->maxLength('button_label', 255)
            ->requirePresence('button_label')
            ->notEmpty('button_label');

        $validator
            ->scalar('url')
            ->maxLength('url', 4096)
            ->requirePresence('url')
            ->notEmpty('url')
            ->url('url', __('Please enter a valid URL.'));

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
            ->allowEmpty('id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmpty('name');

        $validator
            ->scalar('heading')
            ->maxLength('heading', 255)
            ->notEmpty('heading');

        $validator
            ->scalar('button_label')
            ->maxLength('button_label', 255)
            ->notEmpty('button_label');

        $validator
            ->scalar('url')
            ->maxLength('url', 4096)
            ->notEmpty('url')
            ->url('url', __('Please enter a valid URL.'));

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
        $rules->add($rules->isUnique(['slug']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->addCreate($rules->validCount('actions', 8, '<=', 'You cannot add more than 8 actions.'));

        return $rules;
    }

    /**
     * afterDelete callback.
     *
     * Update user totals when a link is deleted
     *
     * @param \Cake\Event\Event $event The afterDelete event that was fired.
     * @param \Cake\Datasource\EntityInterface $entity The entity that was deleted.
     * @param \ArrayObject $options The options for the query
     * @return void
     */
    public function afterDelete($event, $entity, $options)
    {
        // Get a user totals table object
        $userTotalsTable = TableRegistry::get('UserTotals');

        // Update completion, impression and use counts
        $userTotalsTable->updateCompletionCount($entity->user_id);
        $userTotalsTable->updateImpressionCount($entity->user_id);
        $userTotalsTable->updateUseCount($entity->user_id);
    }

    /**
     * isOwnedBy method
     *
     * @return Bool
     */
    public function isOwnedBy($linkId, $userId)
    {
        return $this->exists(['id' => $linkId, 'user_id' => $userId]);
    }

    /**
     * Trims off any blank action fields
     *
     * @return Array
     */
    public function trimAndSortActions($requestData)
    {

        $platform = array(
            "youtube",
            "instagram",
            "snapchat",
            "twitter",
            "vkontakte",
            "askfm",
            "discord",
            "spotify",
            "soundcloud",
            "custom",
        );
        if (!empty($requestData['actions'])) {
            foreach ($requestData['actions'] as $key => $action) {
                if (empty($action['name']) && empty($action['url'])) {
                    unset($requestData['actions'][$key]);
                }
                $platform_num = -1;
                if (isset($action['label']))
                    $requestData['actions'][$key]['name']     = $action['label'];

                if ($action['provider']=='0')  $platform_num = 0;
                else if ($action['provider']=='1') {
                    $platform_num = 1 + intval($action['social']);
                }
                else if($action['provider'] == '2')
                    $platform_num = 7 + intval($action['social']);
                else if ($action['provider']=='3'){
                    $platform_num = 9;
                    $requestData['actions'][$key]['type'] = "other";
                }
                if ($platform_num>0){
                    $requestData['actions'][$key]['platform'] = $platform[$platform_num];
                    $url = explode("/" , $action['url']);
                    $url = explode("=" , $url[count($url)-1]);
                    $requestData['actions'][$key]['socialMediaId'] = $url[count($url)-1];
                }
            }
        }
        
        return $requestData;
    }

    /**
     * Returns a variable length slug based on secure random bytes
	 *
	 * @return String
     */
    public function generateUniqueSlug($length)
    {
        $isUnique = false;
        while (!$isUnique) {
            $randomBytes = Security::randomBytes(512);
            $hexString = base_convert($randomBytes, 20, 36);
            $slug = substr($hexString, 0, $length);
            $count = $this->findBySlug($slug)->count();
            if ($count == 0)
            {
                $isUnique = true;
            }
        }
        return $slug;
    }
}
