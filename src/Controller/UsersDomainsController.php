<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsersDomains Controller
 *
 * @property \App\Model\Table\UsersDomainsTable $UsersDomains
 */
class UsersDomainsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */


    public function adminAdd($user = null)
    {

        $usersDomain = $this->UsersDomains->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $usersDomain->set('user_id',$user);
            $usersDomain = $this->UsersDomains->patchEntity($usersDomain,$data);

            if ($this->UsersDomains->save($usersDomain)) {
                $this->Flash->success(__('The users domain has been saved.'));

                return $this->redirect(['controller' => 'Users','action' => 'admin_view',$user]);
            }
            $this->Flash->error(__('The users domain could not be saved. Please, try again.'));
        }
        $users = $this->UsersDomains->Users->get($user);

        //$domains = $this->UsersDomains->Domains->find('list', ['limit' => 200]);
        $domains = $this->UsersDomains->Domains->getNotOwnedDomainsList($user);

        $this->set(compact('usersDomain', 'users', 'domains'));
        $this->set('_serialize', ['usersDomain']);
    }


    public function adminDelete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersDomain = $this->UsersDomains->get($id);
        if ($this->UsersDomains->delete($usersDomain)) {
            $this->Flash->success(__('The users domain has been deleted.'));
        } else {
            $this->Flash->error(__('The users domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Users','action' => 'admin_view',$usersDomain['user_id']]);
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Domains']
        ];
        $usersDomains = $this->paginate($this->UsersDomains);

        $this->set(compact('usersDomains'));
        $this->set('_serialize', ['usersDomains']);
    }

    /**
     * View method
     *
     * @param string|null $id Users Domain id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersDomain = $this->UsersDomains->get($id, [
            'contain' => ['Users', 'Domains']
        ]);

        $this->set('usersDomain', $usersDomain);
        $this->set('_serialize', ['usersDomain']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersDomain = $this->UsersDomains->newEntity();
        if ($this->request->is('post')) {
            $usersDomain = $this->UsersDomains->patchEntity($usersDomain, $this->request->getData());
            if ($this->UsersDomains->save($usersDomain)) {
                $this->Flash->success(__('The users domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users domain could not be saved. Please, try again.'));
        }
        $users = $this->UsersDomains->Users->find('list', ['limit' => 200]);
        $domains = $this->UsersDomains->Domains->find('list', ['limit' => 200]);
        $this->set(compact('usersDomain', 'users', 'domains'));
        $this->set('_serialize', ['usersDomain']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Domain id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersDomain = $this->UsersDomains->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersDomain = $this->UsersDomains->patchEntity($usersDomain, $this->request->getData());
            if ($this->UsersDomains->save($usersDomain)) {
                $this->Flash->success(__('The users domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users domain could not be saved. Please, try again.'));
        }
        $users = $this->UsersDomains->Users->find('list', ['limit' => 200]);
        $domains = $this->UsersDomains->Domains->find('list', ['limit' => 200]);
        $this->set(compact('usersDomain', 'users', 'domains'));
        $this->set('_serialize', ['usersDomain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersDomain = $this->UsersDomains->get($id);
        if ($this->UsersDomains->delete($usersDomain)) {
            $this->Flash->success(__('The users domain has been deleted.'));
        } else {
            $this->Flash->error(__('The users domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}
