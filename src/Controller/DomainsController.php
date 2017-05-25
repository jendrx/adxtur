<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Domains Controller
 *
 * @property \App\Model\Table\DomainsTable $Domains
 */
class DomainsController extends AppController
{

    public function isAuthorized($user)
    {
        // All registered users can add articles



        // The owner of an article can edit and delete it
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $articleId = (int)$this->request->getParam('pass.0');
            if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $domains = $this->paginate($this->Domains);
        $this->set(compact('domains'));
        $this->set('_serialize', ['domains']);
    }

    /**
     * View method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $domain = $this->Domains->get($id, [
            'contain' => ['Features', 'Territories', 'Types', 'Scenarios', 'Studies']
        ]);

        $this->set('domain',$domain);
        $this->set('_serialize', ['domain']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Types');
        $this->loadModel('TypesDomains');

        $domain = $this->Domains->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $domain = $this->Domains->patchEntity($domain, $data);

            if ($this->Domains->save($domain)) {

                $types = $this->getTypes($domain->id);
                $update_domain = $this->Domains->get($domain->id);
                $update_domain->type = count($types);
                $update_domain->types = $types;
                $this->Domains->save($update_domain);
                $this->Flash->success(__('The domain has been saved.'));

                return $this->redirect(['action' => 'view', $domain->id]);
            }
            $this->Flash->error(__('The domain could not be saved. Please, try again.'));
        }


        //* territories tha will be at panel *//
        $this->loadModel('Territories');
        $query = $this->Territories->find('all',['conditions' =>['parish is null'],'fields'=>['id','name','dicofre'],'order'=>['name' => 'ASC']]);

        //treeview source
        $municipalities = $query->toArray();
        foreach ($municipalities as &$municipality)
        {
            $parishes = $this->Territories->find('all',['conditions' =>['parish is not null', 'parent_id = ' =>$municipality->id ],'fields'=>['id','name','dicofre'],'order'=>['name' => 'ASC']]);
            $municipality->children = $parishes->toArray();
        }

        unset($municipality);

        $features = $this->Domains->Features->find('list', ['limit' => 200]);
        $territorials = $this->Domains->Territories->find('list', ['limit' => 200]);
        $types = $this->Domains->Types->find('list', ['limit' => 200]);
        $this->set(compact('domain', 'features', 'territorials', 'types','municipalities'));
        $this->set('_serialize', ['domain','municipalities']);

    }

    /**
     * Edit method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $domain = $this->Domains->get($id, [
            'contain' => ['Features', 'Territories', 'Types']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domain = $this->Domains->patchEntity($domain, $this->request->getData());
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The domain could not be saved. Please, try again.'));
        }
        $features = $this->Domains->Features->find('list', ['limit' => 200]);
        $territories = $this->Domains->Territories->find('list', ['limit' => 200]);
        $types = $this->Domains->Types->find('list', ['limit' => 200]);
        $this->set(compact('domain', 'features', 'territories', 'types'));
        $this->set('_serialize', ['domain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $domain = $this->Domains->get($id);
        if ($this->Domains->delete($domain)) {
            $this->Flash->success(__('The domain has been deleted.'));
        } else {
            $this->Flash->error(__('The domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function getTypes($id = null)
    {
        $this->loadModel('Types');
        $this->loadModel('TerritoriesDomains');
        $territories = $this->TerritoriesDomains->find('all', array('conditions' => array('domain_id = ' => $id)))->contain(array('Territories' => ['fields' => array('code')]))->select('Territories.code');
        $arr_territories = $territories->toArray();
        $uniques = array_unique($arr_territories);
        $types = array();

        foreach ($uniques as $unique)
        {
            $key = $this->Types->find()->where(['code = ' => $unique->Territories->code ])->first();

            array_push($types,$key);
        }

        return $types;

    }

    public function countTerritoryType($id = null)
    {
        $this->loadModel('TerritoriesDomains');
        $territories = $this->TerritoriesDomains->find('all', array('conditions' => array('domain_id = ' => $id)))->contain(array('Territories' => ['fields' => array('code')]))->select('Territories.code');

        $arr_territories = $territories->toArray();

        return (array_unique($arr_territories));
    }


}
