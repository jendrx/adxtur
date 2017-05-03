<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TerritoriesDomains Controller
 *
 * @property \App\Model\Table\TerritoriesDomainsTable $TerritoriesDomains
 */
class TerritoriesDomainsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Domains', 'Territories']
        ];
        $territoriesDomains = $this->paginate($this->TerritoriesDomains);

        $this->set(compact('territoriesDomains'));
        $this->set('_serialize', ['territoriesDomains']);
    }

    /**
     * View method
     *
     * @param string|null $id Territories Domain id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $territoriesDomain = $this->TerritoriesDomains->get($id, [
            'contain' => ['Domains', 'Territories', 'Scenarios', 'Studies', 'StudiesRulesTerritorialsDomains']
        ]);

        $this->set('territoriesDomain', $territoriesDomain);
        $this->set('_serialize', ['territoriesDomain']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $territoriesDomain = $this->TerritoriesDomains->newEntity();
        if ($this->request->is('post')) {
            $territoriesDomain = $this->TerritoriesDomains->patchEntity($territoriesDomain, $this->request->getData());
            if ($this->TerritoriesDomains->save($territoriesDomain)) {
                $this->Flash->success(__('The territories domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The territories domain could not be saved. Please, try again.'));
        }
        $domains = $this->TerritoriesDomains->Domains->find('list', ['limit' => 200]);
        $territories = $this->TerritoriesDomains->Territories->find('list', ['limit' => 200]);
        $scenarios = $this->TerritoriesDomains->Scenarios->find('list', ['limit' => 200]);
        $studies = $this->TerritoriesDomains->Studies->find('list', ['limit' => 200]);
        $this->set(compact('territoriesDomain', 'domains', 'territories', 'scenarios', 'studies'));
        $this->set('_serialize', ['territoriesDomain']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Territories Domain id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $territoriesDomain = $this->TerritoriesDomains->get($id, [
            'contain' => ['Scenarios', 'Studies']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $territoriesDomain = $this->TerritoriesDomains->patchEntity($territoriesDomain, $this->request->getData());
            if ($this->TerritoriesDomains->save($territoriesDomain)) {
                $this->Flash->success(__('The territories domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The territories domain could not be saved. Please, try again.'));
        }
        $domains = $this->TerritoriesDomains->Domains->find('list', ['limit' => 200]);
        $territories = $this->TerritoriesDomains->Territories->find('list', ['limit' => 200]);
        $scenarios = $this->TerritoriesDomains->Scenarios->find('list', ['limit' => 200]);
        $studies = $this->TerritoriesDomains->Studies->find('list', ['limit' => 200]);
        $this->set(compact('territoriesDomain', 'domains', 'territories', 'scenarios', 'studies'));
        $this->set('_serialize', ['territoriesDomain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Territories Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $territoriesDomain = $this->TerritoriesDomains->get($id);
        if ($this->TerritoriesDomains->delete($territoriesDomain)) {
            $this->Flash->success(__('The territories domain has been deleted.'));
        } else {
            $this->Flash->error(__('The territories domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
