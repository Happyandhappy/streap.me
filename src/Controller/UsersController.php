<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Utility\Text;
use Cake\Validation\Validator;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Change password method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changePassword()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'changePassword']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your password has been updated.'));
                $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Change Password');

                return $this->redirect(['action' => 'manageSettings']);
            }
            $this->Flash->error(__('There was a problem updating your password.'));
        }
        $this->request->data['password'] = '';
        $this->request->data['password-challenge'] = '';
        $this->request->data['password-verify'] = '';

        $this->set(compact('user'));
    }

    /**
     * Change username method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changeUsername()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'changeUsername']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your username has been updated.'));
                $this->Auth->setUser($user);
                $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Change Username');

                return $this->redirect(['action' => 'manageSettings']);
            }
            $this->Flash->error(__('There was a problem updating your username.'));
        }
        $this->request->data['password-verify'] = '';
        $this->set(compact('user'));
    }

    /**
     * isAuthorized method
     *
     * @return Bool
     */
    public function isAuthorized($user = null)
    {
    	// Allow registered users
    	if (in_array($this->request->getParam('action'), ['changePassword', 'changeUsername', 'manageSettings', 'setPassword'])) {
    		return true;
    	}
    	return parent::isAuthorized($user);
    }

    /**
     * Initialize method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['register', 'logout', 'recoverPassword', 'verifyRecoveryCode']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        // Check if the user is already logged in
        if ($this->Auth->user('id')) {
            $this->Flash->error(__('You are already logged in.'));
            return $this->redirect(['controller' => 'Links', 'action' => 'index']);
        }

        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Login') . ' | ' . $globals['siteName']);

        // Begin action
        $user = $this->Users->newEntity();           
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'login']);
            if (empty($user->errors())) {
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Login');

                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->error('Your username and or password was incorrect. Pleae try again.');
                $this->request->data['password'] = '';
            }
        }
        $this->request->data['password'] = '';
        $this->set(compact('globals', 'user'));
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|void
     */
    public function logout()
    {
        if ($this->Auth->user('id')) {
            $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Logout');
            $this->Flash->success('You have been logged out of the system.');
        }
        $this->redirect($this->Auth->logout());
    }

    /**
     * Manage settings method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function manageSettings()
    {
        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Manage Settings') . ' | ' . $globals['siteName']);

        // Begin action
    	$user = $this->Users->newEntity();
        $this->set(compact('globals', 'user'));    	
    }

    /**
     * Recover password method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function recoverPassword()
    {
        // Check if the user is already logged in
        if ($this->Auth->user('id')) {
            $this->Flash->error(__('You cannot recover your password while logged in.'));
            return $this->redirect(['controller' => 'Links', 'action' => 'index']);
        }

        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Recover your password') . ' | ' . $globals['siteName']);

        // Begin action
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'recoverPassword']);
            if (empty($user->errors())) {
                $email = $this->request->data['username'];
                $user = $this->Users->findByUsername($email)->first();
                if ($user) {
                    $this->Flash->success(__('A verification email has been sent to the email address you provided.'));
                    $recoveryCode = Text::uuid();

                    $this->request->data = ['recovery_code' => $recoveryCode];
                    $user = $this->Users->patchEntity($user, $this->request->getData());

                    if ($this->Users->save($user)) {
                        $email = new Email();
                        $email
                            ->template('recovery')
                            ->emailFormat('text')
                            ->to($user->username)
                            ->from('passwordrecovery@viid.openglcode.com')
                            ->subject(__('Password Recovery'))
                            ->viewVars(['recoveryCode' => $recoveryCode])
                            ->send();

                        return $this->redirect(['action' => 'login']);
                    }
                }
                $this->Flash->error(__('The username you provided does not exist in the system.'));
            }
        }
        $this->set(compact('globals', 'user'));
    }

    /**
     * Register method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function register()
    {
        // Check if the user is already logged in
        if ($this->Auth->user('id')) {
            $this->Flash->error(__('You cannot register an account while logged in.'));
            return $this->redirect(['controller' => 'Links', 'action' => 'index']);
        }

        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Sign up for free!') . ' | ' . $globals['siteName']);

        // Begin action
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['role'] = 'Standard';
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'register']);
            if (empty($user->errors())) {
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your account has been created successfully.'));
                    $this->Auth->setUser($user);
                    $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Register');

                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
            $this->Flash->error(__('There was a problem with your registration. Please try again.'));
        }
        $this->request->data['password'] = '';
        $this->request->data['password-challenge'] = '';
        $this->set(compact('globals', 'user'));
    }

    /**
     * Set password method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function setPassword()
    {
        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Set your new password') . ' | ' . $globals['siteName']);

        // Begin action
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'setPassword']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your password has been updated.'));
                $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Set Password');

                return $this->redirect(['controller' => 'Links', 'action' => 'index']);
            }
            $this->Flash->error(__('There was a problem updating your password.'));
        }
        $this->request->data['password'] = '';
        $this->request->data['password-challenge'] = '';
        $this->set(compact('globals', 'user'));
    }

    /**
     * Verify recovery code method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function verifyRecoveryCode($recoveryCode = null)
    {
        if ($recoveryCode) {
            $user = $this->Users->findByRecoveryCode($recoveryCode)->first();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Thank you for verifying your recovery code. Please update your password.'));

                $this->request->data = ['recovery_code' => ''];
                $this->Users->patchEntity($user, $this->request->getData());
                $this->Users->save($user);
                $this->Users->Statistics->insertStatistic('Users', $this->Auth->user('id'), 'Recover Password');

                return $this->redirect(['action' => 'setPassword']);
            }
            $this->Flash->error(__('This verification code has expired.'));
            return $this->redirect(['action' => 'login']);
        }
        $this->Flash->error(__('There was a problem recovering your password.'));
        return $this->redirect(['action' => 'login']);
    }
}
