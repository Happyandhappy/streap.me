<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginRedirect' => [
                'controller' => 'links',
                'action' => 'index'
            ]
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Security', [
            'blackHoleCallback' => 'forceSSL',
            'validatePost' => false
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * isAuthorized method
     *
     * @return Bool
     */
    public function isAuthorized($user)
    {
        if (isset($user['role']) && $user['role'] == 'Administrator') {
            return true;
        }
        return false;
    }

    /**
     * Build globals method
     *
     * @return Array
     */
    public function buildGlobals()
    {
        // The name of the website, usually used in the title of pages
        $globals['siteName'] = Configure::read('App.siteName');
        
        return $globals;
    }

    /**
     * Force all actions to require SSL
     */
    public function beforeFilter(Event $event)
    {
        $this->Security->requireSecure();
    }

    /**
     * Redirect non SSL requests to SSL
     */
    public function forceSSL()
    {
        return $this->redirect('https://' . env('SERVER_NAME') . $this->request->getRequestTarget());
    }
}
