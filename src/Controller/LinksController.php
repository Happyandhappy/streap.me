<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Links Controller
 *
 * @property \App\Model\Table\LinksTable $Links
 *
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Create a new link') . ' | ' . $globals['siteName']);

        // Begin action
        $user_id = $this->Auth->user('id');
        $link = $this->Links->newEntity();
        if ($this->request->is('post')) {
            
            $this->request->data = $this->Links->trimAndSortActions($this->request->data);
            $link = $this->Links->patchEntity($link, $this->request->getData());
            debug($this->request->getData());exit;
            $link->user_id = $user_id;
            $link->slug = $this->Links->generateUniqueSlug(5);
            if ($this->Links->save($link)) {
                $this->Flash->success(__('The link has been saved.'));
                $this->request->session()->write('Viidsu.alert_link_id', $link->id);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The link could not be saved. Please, try again.'));
        }
        $buttonLabelList = $this->Links->Actions->buttonLabels;
        $this->set(compact('buttonLabelList', 'link'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($slug = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $link = $this->Links->findBySlug($slug)->first();
        if ($this->Links->delete($link)) {
            $this->Flash->success(__('The link has been deleted.'));
        } else {
            $this->Flash->error(__('The link could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Display method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function display($slug = null)
    {
        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', $globals['siteName']);

        // Begin action
        $link = $this->Links->findBySlug(h($slug))
        	->contain([
        		'Actions' => [
        			'sort' => ['Actions.sort' => 'ASC']
        		]])
            ->cache('display_link_' . $slug, 'short')
            ->first();
        $this->Links->Statistics->insertStatistic('Links', $link->id, 'View');
        $this->loadModel('UserTotals');
        $this->UserTotals->updateImpressionCount($link->user_id, 'impression_count');
        $this->set(compact('link'));
    }

    /**
     * Edit method
     *
     * @param string|null $slug Link slug.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($slug = null)
    {
        $link = $this->Links->findBySlug($slug)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $link = $this->Links->patchEntity($link, $this->request->getData(), ['validate' => 'singleFieldEdit']);
            if ($this->Links->save($link)) {
                $this->Flash->success(__('Your changes have been saved successfully.'));
                return $this->redirect(['action' => 'view', $link->slug]);
            }
            $this->Flash->error(__('The changes could not be saved. Please try again.'));
            return $this->redirect(['action' => 'view', $link->slug]);
        }
    }

    /**
     * Forward method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function forward($slug = null)
    {
        $link = $this->Links->findBySlug($slug)->first();
        $this->Links->Statistics->insertStatistic('Links', $link->id, 'Completion');
        $this->loadModel('UserTotals');
        $this->UserTotals->updateCompletionCount($link->user_id);
        return $this->redirect($link->url);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // Construct globals
        $globals = parent::buildGlobals();

        // Set the title
        $this->set('title', __('Dashboard') . ' | ' . $globals['siteName']);

        // Get the users links
        $this->paginate = [
            'limit' => 5,
            'conditions' => [
                'user_id' => $this->Auth->user('id')
            ]
        ];
        $links = $this->paginate($this->Links);

        // Check if there is a new link to show an alert for
        $alertLinkId = $this->request->session()->read('Viidsu.alert_link_id');
        if ($alertLinkId) {
            $alertLink = $this->Links->get($alertLinkId);
            $this->set(compact('alertLink'));
            $this->request->session()->consume('Viidsu.alert_link_id');
        }

        $this->set(compact('links'));
    }

    /**
     * Index links Table AJAX method
     *
     * @return \Cake\Http\Response|void
     */
    public function indexLinksTable()
    {
        if ($this->request->is('ajax')) {
            $this->paginate = [
                'limit' => 5,
                'conditions' => [
                    'user_id' => $this->Auth->user('id')
                ]
            ];
            $links = $this->paginate($this->Links);
            $this->set(compact('links'));
        }
    }

    /**
     * Index stats blocks AJAX method
     *
     * @return \Cake\Http\Response|void
     */
    public function indexStatsBlock()
    {
        if ($this->request->is('ajax')) {
            $userId = $this->Auth->user('id');
            $statistics = $this->Links->Statistics->getUserTopCountries($userId, 'View', 3);

            $this->loadModel('UserTotals');
            $totals = $this->UserTotals->findByUserId($this->Auth->user('id'))->cache('user_totals_' . $this->Auth->user('id'), 'minimal')->first();

            $this->set(compact('statistics',  'totals'));
        }
    }

    /**
     * Initialize method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['display', 'forward']);
    }

    /**
     * isAuthorized method
     *
     * @return Bool
     */
    public function isAuthorized($user = null)
    {
        // Any registered user can...
    	if (in_array($this->request->getParam('action'), ['add', 'index'])) {
    		return true;
    	}
        // Any registered user can if the request is AJAX
        if (in_array($this->request->getParam('action'), ['indexLinksTable', 'indexStatsBlock'])) {
            if ($this->request->is('ajax')) {
                return true;
            }
        }
        // Only authors of a given link can...
    	if (in_array($this->request->getParam('action'), ['delete', 'edit', 'reorderActions', 'view'])) {
    		$linkSlug = $this->request->getParam('pass.0');
    		$link = $this->Links->findBySlug($linkSlug)->first();
    		if ($this->Links->isOwnedBy($link->id, $user['id'])) {
    			return true;
    		}
    	}
    	return parent::isAuthorized($user);
    }

    /**
     * Reorder actions method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function reorderActions($slug = null)
    {
        $requestData = $this->request->getData();
        $link = $this->Links->findBySlug($slug)->contain([
            'Actions' => [
                'sort' => [
                    'Actions.sort' => 'ASC'
                ]
            ]
        ])->first();
        $data = [];
        foreach ($link->actions as $key => $action) {
            $data['sort'] = array_search($action->id, $requestData['sort']);
            $actions[] = $this->Links->Actions->patchEntity($link->actions[$key], $data);
        }
        if ($this->Links->Actions->saveMany($actions)) {
            $this->Flash->success(__('The actions have been reordered successfully.'));
            return $this->redirect(['action' => 'view', $slug]);
        }
        $this->Flash->error(__('There was a problem updating your actions. Please try again.'));
        return $this->redirect(['action' => 'view', $slug]);
    }

    /**
     * View method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        // Construct globals
        $globals = parent::buildGlobals();

        // Begin action
        $link = $this->Links->findBySlug($slug)->contain([
            'Actions' => [
        		'sort' => [
        			'Actions.sort' => 'ASC'
        		]
        	]
        ])->first();

        $this->set('serverName', env('SERVER_NAME'));
        $this->set('title', h($link->name) . ' (' . $link->slug . ') | ' . $globals['siteName']);
        $this->set('link', $link);
    }
}
