<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Statistics Model
 *
 * @property \App\Model\Table\ForeignsTable|\Cake\ORM\Association\BelongsTo $Foreigns
 *
 * @method \App\Model\Entity\Statistic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Statistic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Statistic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Statistic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Statistic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatisticsTable extends Table
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

        $this->setTable('statistics');
        $this->setDisplayField('activity');
        $this->setPrimaryKey('id');

        $this->addBehavior('CounterCache', [
        	'Actions' => [
                'click_count' => [
            		'finder' => 'clicks'
            	]
            ],
        	'Links' => [
                'completion_count' => [
                    'finder' => 'completions'
                ],
                'view_count' => [
                    'finder' => 'views'
                ]
            ]
        ]);
        $this->addBehavior('Timestamp');

        $this->belongsTo('Actions', [
            'foreignKey' => 'foreign_id',
            'joinType' => 'INNER',
            'conditions' => [
                'foreign_table' => 'Actions'
            ]
        ]);
        $this->belongsTo('Links', [
            'foreignKey' => 'foreign_id',
            'joinType' => 'INNER',
            'conditions' => [
                'foreign_table' => 'Links'
            ]
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'foreign_id',
            'joinType' => 'INNER',
            'conditions' => [
                'foreign_table' => 'Users'
            ]
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
            ->scalar('foreign_table')
            ->maxLength('foreign_table', 32)
            ->requirePresence('foreign_table', 'create')
            ->notEmpty('foreign_table');

        $validator
            ->integer('foreign_id')
            ->allowEmpty('foreign_id', 'create');

        $validator
            ->scalar('act')
            ->maxLength('act', 32)
            ->requirePresence('act', 'create')
            ->notEmpty('act');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 32)
            ->requirePresence('ip', 'create')
            ->notEmpty('ip');

        $validator
            ->scalar('country')
            ->maxLength('country', 32)
            ->requirePresence('country', 'create')
            ->notEmpty('country');

        $validator
            ->scalar('agent')
            ->maxLength('agent', 255)
            ->requirePresence('agent', 'create')
            ->notEmpty('agent');

        $validator
            ->scalar('referrer')
            ->maxLength('referrer', 4096)
            ->requirePresence('referrer', 'create')
            ->notEmpty('referrer');

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
     * Inserts an action line into the statistics table
     */
    public function insertStatistic($foreignTable, $foreignId, $operation)
    {
        $ip = env('REMOTE_ADDR');
        $country = $this->getCountry($ip);
        $agent = env('HTTP_USER_AGENT');
        $referrer = env('HTTP_REFERER');

        $statistic = $this->newEntity();
        $statistic->foreign_table = $foreignTable;
        $statistic->foreign_id = $foreignId;
        $statistic->operation = $operation;
        $statistic->ip = $ip;
        $statistic->country = $country;
        $statistic->agent = $agent;
        $statistic->referrer = $referrer;

        $this->save($statistic);
    }

    /**
     * Find click stats
     */
    public function findClicks(Query $query, array $options)
    {
    	return $query->where([
            'foreign_table' => 'Actions',
            'operation' => 'Click'
        ]);
    }

    /**
     * Find completion stats
     */
    public function findCompletions(Query $query, array $options)
    {
    	return $query->where([
            'foreign_table' => 'Links',
            'operation' => 'Completion'
        ]);
    }

    /**
     * Find view stats
     */
    public function findViews(Query $query, array $options)
    {
    	return $query->where([
            'foreign_table' => 'Links',
            'operation' => 'View'
        ]);
    }

    /**
     * Get the top countries for a given operation
     */
    public function getUserTopCountries($userId, $operation, $count)
    {
        // Get a Links table object
    	$linksTable = TableRegistry::get('Links');
    	$links = $linksTable->find('list', [
    		'conditions' => ['user_id' => $userId],
    		'valueField' => 'id'
    	])
    	->toArray();

        // Get the country counts
        $query = $this->find();
        $query
        	->select(['country', 'count' => $query->func()->count('id')])
        	->where(['foreign_table' => 'Links', 'foreign_id IN' => $links, 'operation' => $operation])
        	->order(['count' => 'DESC'])
        	->group('country')
        	->limit($count)
        	->cache('top_countries_' . $userId, 'short');

        $statistics = $query->toArray();

		return $statistics;
    }

    /**
     * Deduce country from IP using freegeoip.net
     */
    public function getCountry($ip = null)
    {
    	if ($ip) {
	        $geoIpUrl = 'http://freegeoip.net/json/' . $ip;
	        $geoIpResponse = file_get_contents($geoIpUrl);
	        $GeoIpObject = json_decode($geoIpResponse);
	        if (empty($GeoIpObject->country_name)) {
		    	return 'Unknown';
	        } else {
		        return $GeoIpObject->country_name;	        	
	        }
    	}
    	return 'Unknown';
    }
}
