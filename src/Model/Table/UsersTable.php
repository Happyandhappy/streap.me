<?php
namespace App\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\LinksTable|\Cake\ORM\Association\HasMany $Links
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    /**
     * Available system roles
     */
    public $systemRoles = [
        'Administrator' => 'Administrator',
        'Standard' => 'Standard',
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Links', [
            'foreignKey' => 'user_id',
            'dependent' => true
        ]);
        $this->hasMany('Statistics', [
            'foreignKey' => 'foreign_id',
            'conditions' => ['foreign_table' => $this->table()],
            'dependent' => true
        ]);
        $this->hasMany('UserTotals', [
            'foreignKey' => 'user_id',
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
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('This email address is already in the system.')])
            ->add('username', 'custom', [
                'rule' => 'email',
                'message' => __('Please enter a valid email address.')
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('role')
            ->maxLength('role', 255)
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        return $validator;
    }

    /**
     * Change Username validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationChangeUsername(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username')
            ->notEmpty('username')
            ->add('username', 'custom', [
                'rule' => 'email',
                'message' => __('Please enter a valid email address.')
            ]);

        $validator
            ->scalar('username-challenge')
            ->maxLength('username-challenge', 255)
            ->requirePresence('username-challenge')
            ->notEmpty('username-challenge')
            ->add('username-challenge', 'custom', [
                'rule' => [$this, 'compareUsernames'],
                'message' => __('The email that you entered does not match.')
            ]);

        $validator
            ->scalar('password-verify')
            ->requirePresence('password-verify')
            ->notEmpty('password-verify')
            ->add('password-verify', 'custom', [
                'rule' => [$this, 'verifyPassword'],
                'message' => __('The password that you entered doesn\'t match our records.')
            ]);

        return $validator;
    }

    /**
     * Change Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationChangePassword(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password')
            ->notEmpty('password');

        $validator
            ->notEmpty('password-challenge')
            ->requirePresence('password-challenge')
            ->add('password-challenge', 'custom', [
                'rule' => [$this, 'comparePasswords'],
                'message' => __('The passwords that you entered do not match.')
            ]);

        $validator
            ->notEmpty('password-verify')
            ->requirePresence('password-verify')
            ->add('password-verify', 'custom', [
                'rule' => [$this, 'verifyPassword'],
                'message' => __('The password that you entered does not match our records.')
            ]);

        return $validator;
    }

    /**
     * Forgot Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRecoverPassword(Validator $validator)
    {
        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username')
            ->notEmpty('username');

        $validator
            ->requirePresence('g-recaptcha-response')
            ->notEmpty('g-recaptcha-response', __('Please complete the Captcha verification before continuing.'))
            ->add('g-recaptcha-response', 'custom', [
                'rule' => [$this, 'verifyCaptcha'],
                'message' => __('Captcha verification failed.')
            ]);

        return $validator;
    }

    /**
     * Set Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationSetPassword(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password')
            ->notEmpty('password');

        $validator
            ->notEmpty('password-challenge')
            ->requirePresence('password-challenge')
            ->add('password-challenge', 'custom', [
                'rule' => [$this, 'comparePasswords'],
                'message' => __('The passwords that you entered do not match.')
            ]);
            
        return $validator;
    }

    /**
     * Login validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationLogin(Validator $validator)
    {
        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username')
            ->notEmpty('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password')
            ->notEmpty('password');

        $validator
            ->requirePresence('g-recaptcha-response')
            ->notEmpty('g-recaptcha-response', __('Please complete the Captcha verification before continuing.'))
            ->add('g-recaptcha-response', 'custom', [
                'rule' => [$this, 'verifyCaptcha'],
                'message' => __('Captcha verification failed.')
            ]);

        return $validator;
    }

    /**
     * Register validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRegister(Validator $validator)
    {
        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username')
            ->notEmpty('username')
            ->add('username', 'custom', [
                'rule' => 'email',
                'message' => __('Please enter a valid email address.')
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password')
            ->notEmpty('password');

        $validator
            ->notEmpty('password-challenge')
            ->add('password-challenge', 'custom', [
                'rule' => [$this, 'comparePasswords'],
                'message' => __('The password that you entered does not match.')
            ]);

        $validator
            ->requirePresence('g-recaptcha-response')
            ->notEmpty('g-recaptcha-response', __('Please complete the Captcha verification before continuing.'))
            ->add('g-recaptcha-response', 'custom', [
                'rule' => [$this, 'verifyCaptcha'],
                'message' => __('Captcha verification failed.')
            ]);

        return $validator;    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username'], __('This email address already exists in the system.')));

        return $rules;
    }

    /**
     * afterSave callback.
     *
     * Add an empty user totals record
     *
     * @param \Cake\Event\Event $event The afterSave event that was fired.
     * @param \Cake\Datasource\EntityInterface $entity The entity that was saved.
     * @param \ArrayObject $options The options for the query
     * @return void
     */
    public function afterSave($event, $entity, $options ) 
    {
        // Get a user totals table object
        $userTotalsTable = TableRegistry::get('UserTotals');

        // Create the blank user totals record
        $userTotalsTable->createEmptyRecord($entity->id);
    }

    /**
     * Compares password to password-challenge
     */
    public function comparePasswords($check, $context)
    {
        if ($check == $context['data']['password']) {
            return true;
        }
        return false;
    }

    /**
     * Compares username to username-challenge
     */
    public function compareUsernames($check, $context)
    {
        if ($check == $context['data']['username']) {
            return true;
        }
        return false;
    }

    /**
     * Confirms that the entered password matches the password stored in the db
     */
    public function verifyPassword($check, $context)
    {
        $user = $this->get($context['data']['id']);
        if ((new DefaultPasswordHasher)->check($check, $user->password)) {
            return true;
        }
        return false;
    }

    /**
     * Validates captcha input
     */
    public function verifyCaptcha($check, $context)
    {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?';
        $query['secret'] = '6LfiBiQUAAAAABP2J-1RLqI6nx9IgY0VGkr8t3f0';
        $query['response'] = $check;
        $query['remoteip'] = env('REMOTE_ADDR');
        $queryString = http_build_query($query);

        $response = file_get_contents($verifyUrl . $queryString);
        $responseObject = json_decode($response);

        if ($responseObject) {
            if ($responseObject->success) {
                return true;
            }
        }
        return false;
    }
}
