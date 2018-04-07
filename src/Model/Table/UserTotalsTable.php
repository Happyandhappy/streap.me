<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * UserTotals Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UserTotals get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserTotals newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserTotals[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserTotals|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserTotals patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserTotals[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserTotals findOrCreate($search, callable $callback = null, $options = [])
 */
class UserTotalsTable extends Table
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

        $this->setTable('user_totals');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
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
        return $rules;
    }

    /**
     * Create a blank user totals record
     */
    public function createEmptyRecord($userId)
    {
        $data['user_id'] = $userId;
        $userTotals = $this->newEntity();
        $userTotals = $this->patchEntity($userTotals, $data);
        $this->save($userTotals);
    }

    /**
     * Update impression count
     *
     * @param string|null $userId User id.
     */
    public function updateImpressionCount($userId)
    {
        // Get a Links table object
    	$linksTable = TableRegistry::get('Links');

    	// Construct the view_count totalling query
    	$query = $linksTable->findByUserId($userId);
    	$impressionCountRow = $query->select(['impression_count' => $query->func()->sum('view_count')])->first();

    	// Get the impression count from the result
    	$data['impression_count'] = $impressionCountRow['impression_count'];

    	// Update the impressions in the user totals table
    	$userTotal = $this->findByUserId($userId)->first();
        $userTotal = $this->patchEntity($userTotal, $data);
        $this->save($userTotal);
    }

    /**
     * Update use count
     *
     * @param string|null $userId User id.
     */
    public function updateUseCount($userId)
    {
        // Get a Links table object
        $linksTable = TableRegistry::get('Links');

        // Get a list of link ids to calculate
        $linkIds = $linksTable->find('list', ['conditions' => ['user_id' => $userId], 'valueField' => 'id'])->toArray();

        if ($linkIds) {
            // Get the sum of all action clicks
            $query = $linksTable->Actions->find()->where(['link_id IN' => $linkIds]);
            $useCountRow = $query->select(['use_count' => $query->func()->sum('click_count')])->first();

            // Get the impression count from the result
            $data['use_count'] = $useCountRow['use_count'];

            // Update the impressions in the user totals table
            $userTotal = $this->findByUserId($userId)->first();
            $userTotal = $this->patchEntity($userTotal, $data);
            $this->save($userTotal);
        }
    }

    /**
     * Update completion count
     *
     * @param string|null $userId User id.
     */
    public function updateCompletionCount($userId)
    {
        // Get a Links table object
        $linksTable = TableRegistry::get('Links');

        // Construct the completion_count totalling query
        $query = $linksTable->findByUserId($userId);
        $completionCountRow = $query->select(['completion_count' => $query->func()->sum('completion_count')])->first();

        // Get the impression count from the result
        $data['completion_count'] = $completionCountRow['completion_count'];

        // Update the impressions in the user totals table
        $userTotal = $this->findByUserId($userId)->first();
        $userTotal = $this->patchEntity($userTotal, $data);
        $this->save($userTotal);
    }
}
