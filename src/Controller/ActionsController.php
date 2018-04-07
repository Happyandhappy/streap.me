<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Actions Controller
 *
 * @property \App\Model\Table\ActionsTable $Actions
 *
 * @method \App\Model\Entity\Action[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActionsController extends AppController
{

    /**
     * Add method
     *
     * @param string|null $id action id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($linkSlug = null)
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

        $socialLabels = array(
            array("Watch My Story", "Visit XXX Instagram", "Send Direct Message"),
            array("Add Me on Snapchat", "Watch My Story", "Snap Me Something", "Screenshot my SC Story"),
            array("Watch My Story", "Visit My Twitter", "Send Direct Message"),
            array("Follow Me", "Like This Post", "Send Direct Message","Comment this Post"),
            array("Ask Me", "Follow Me"),
            array("Join Me"),
        );

        $socialTypes  = array(
            array("watch-story", "visit-instagram", "dm"),
            array("add", "watch-story" , "snap", "screen"),
            array("watch-story", "visit-twitter", "dm", ),
            array("follow", "like", "dm", "comment"),
            array("follow", "like", "dm", "commit"),
            array("ask", "follow"),
            array("join")
        );

        $musicLabels = array(
            array("Save This Song", "Save This Playlist" , "Listen To This Song" , "Follow Me On Spotify/Apple Music"),
            array("Save This Song", "Save This Playlist", "Listen To This Song", "Like My Song" , "Comment Under My Song", "Follow Me On Soundcloud", "Repost My Song"),
        );

        $musicTypes = array(
            array("save", "save-playlist", "listen", "follow-music"),
            array("save", "save-playlist", "listen", "like-song", "comment-song", "follow-cloud", "repost")
        );

        $globals = parent::buildGlobals();
        // Construct globals
        $globals = parent::buildGlobals();
        
        // Set the title
        $this->set('title', __('Create a new action') . ' | ' . $globals['siteName']);

        // Begin action
        $action = $this->Actions->newEntity();
        $link = $this->Actions->Links->findBySlug($linkSlug)->contain(['Actions'])->first();
        if (count($link->actions) > 3) {
            $this->Flash->success(__('You cannot add more actions to this link.'));
            return $this->redirect(['controller' => 'Links', 'action' => 'view', $link->slug]);
        }
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            debug($data);
            $data['link_id']  = $link->id;
            if (isset($data['name']))
                $data['name']     = $data['label'];
            $data['sort']     = 10;

            if ($data['provider']=='0') $platform_num = 0;
            if ($data['provider']=='1') {
                $platform_num = 1 + intval($data['social']);
                $data['name'] = $socialLabels[intval($data['social'])][intval($data['label'])];
                $data['type'] = $socialTypes[intval($data['social'])][intval($data['label'])];
            }
            if ($data['provider']=='2') {
                $platform_num = 7 + intval($data['social']);
                $data['name'] = $musicLabels[intval($data['social'])][intval($data['label'])];
                $data['type'] = $musicTypes[intval($data['social'])][intval($data['label'])];
            }
            if ($data['provider']=='3') {
                $platform_num = 9;
                $data['type'] = "other";
                $data['name'] = $this->request->getData()['name'];
            }

            $data['platform'] = $platform[$platform_num];
            $action = $this->Actions->patchEntity($action, $data);
            if ($this->Actions->save($action)) {
                $this->Flash->success(__('The action has been saved.'));
                if (isset($_COOKIE[$linkSlug])){
                    unset($_COOKIE[$linkSlug]);
                }
                return $this->redirect(['controller' => 'Links', 'action' => 'view', $link->slug]);
            }
        }
        $this->set(compact(['action', 'link']));
    }

    /**
     * Delete method
     *
     * @param string|null $id action id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $action = $this->Actions->get($id, ['contain' => ['Links']]);
        $userId = $action->link->user_id;
        if ($this->Actions->delete($action)) {
            $this->Flash->success(__('The action has been deleted.'));
        } else {
            $this->Flash->error(__('The action could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Links', 'action' => 'view', $action->link->slug]);
    }

    /**
     * Edit method
     *
     * @param string|null $id action id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $action = $this->Actions->get($id, ['contain' => ['Links']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($_COOKIE[$action->link->slug]))
            {    
                $cookie = $_COOKIE[$action->link->slug];
            } 
            else $cookie = ""; 
            $cookie = str_replace("/actions/forward/".$id.",", "", $cookie);
            setcookie($action->link->slug, $cookie, time()+(86400*60),"/");
            
            $action = $this->Actions->patchEntity($action, $this->request->getData(), ['validate' => 'singleFieldEdit']);
            if ($this->Actions->save($action)) {
                $this->Flash->success(__('Your changes have been saved successfully.'));
                return $this->redirect(['controller' => 'Links', 'action' => 'view', $action->link->slug]);
            }
            $this->Flash->error(__('The changes could not be saved. Please try again.'));
            return $this->redirect(['controller' => 'Links', 'action' => 'view', $action->link->slug]);
        }
    }

    /**
     * Forward method
     *
     * @param string|null $id action id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function forward($id = null)
    {
        $action = $this->Actions->get($id, ['contain' => ['Links']]);
        $this->Actions->Statistics->insertStatistic('Actions', $action->id, 'Click');
        $this->loadModel('UserTotals');
        $this->UserTotals->updateUseCount($action->link->user_id);
        return $this->redirect($action->url);
    }

    /**
     * Initialize method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['forward']);
    }

    /**
     * isAuthorized method
     *
     * @return Bool
     */
    public function isAuthorized($user = null)
    {
        // Only authors of a given actions parent link can...
        if (in_array($this->request->getParam('action'), ['add'])) {
            $linkSlug = $this->request->getParam('pass.0');
            $link = $this->Actions->Links->findBySlug($linkSlug)->first();
            if ($this->Actions->Links->isOwnedBy($link->id, $user['id'])) {
                return true;
            }
        }
        // Only authors of a given actions parent link can...
        if (in_array($this->request->getParam('action'), ['delete', 'edit'])) {
            $actionId = $this->request->getParam('pass.0');
            $action = $this->Actions->get($actionId);
            if ($this->Actions->Links->isOwnedBy($action->link_id, $user['id'])) {
                return true;
            }
        }
    	return parent::isAuthorized($user);
    }
}
