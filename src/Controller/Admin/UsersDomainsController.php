<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 12:32 PM
 */

namespace App\Controller\Admin;


use App\Controller\AppController;

class UsersDomainsController extends  AppController
{


    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Domains']
        ];
        $usersDomains = $this->paginate($this->UsersDomains);

        $this->set(compact('usersDomains'));
        $this->set('_serialize', ['usersDomains']);
    }



    public function add($user = null)
    {

        $usersDomain = $this->UsersDomains->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $usersDomain->set('user_id',$user);
            $usersDomain = $this->UsersDomains->patchEntity($usersDomain,$data);

            if ($this->UsersDomains->save($usersDomain)) {
                $this->Flash->success(__('The users domain has been saved.'));

                return $this->redirect(['controller' => 'Users','action' => 'view',$user]);
            }
            $this->Flash->error(__('The users domain could not be saved. Please, try again.'));
        }
        $users = $this->UsersDomains->Users->get($user);

        $domains = $this->UsersDomains->Domains->getNotOwnedDomainsList($user);

        $this->set(compact('usersDomain', 'users', 'domains'));
        $this->set('_serialize', ['usersDomain']);
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersDomain = $this->UsersDomains->get($id);
        if ($this->UsersDomains->delete($usersDomain)) {
            $this->Flash->success(__('The users domain has been deleted.'));
        } else {
            $this->Flash->error(__('The users domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Users','action' => 'view',$usersDomain['user_id']]);
    }

}