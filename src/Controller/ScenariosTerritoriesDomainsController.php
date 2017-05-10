<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ScenariosTerritoriesDomains Controller
 *
 * @property \App\Model\Table\ScenariosTerritoriesDomainsTable $ScenariosTerritoriesDomains
 */
class ScenariosTerritoriesDomainsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['TerritoriesDomains', 'Scenarios']
        ];
        $scenariosTerritoriesDomains = $this->paginate($this->ScenariosTerritoriesDomains);

        $this->set(compact('scenariosTerritoriesDomains'));
        $this->set('_serialize', ['scenariosTerritoriesDomains']);
    }

    /**
     * View method
     *
     * @param string|null $id Scenarios Territories Domain id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->get($id, [
            'contain' => ['TerritoriesDomains', 'Scenarios']
        ]);

        $this->set('scenariosTerritoriesDomain', $scenariosTerritoriesDomain);
        $this->set('_serialize', ['scenariosTerritoriesDomain']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($scenario_id)
    {
        /*$scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->newEntity();
        if ($this->request->is('post')) {
            $scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->patchEntity($scenariosTerritoriesDomain, $this->request->getData());
            if ($this->ScenariosTerritoriesDomains->save($scenariosTerritoriesDomain)) {
                $this->Flash->success(__('The scenarios territories domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The scenarios territories domain could not be saved. Please, try again.'));
        }
        $territoriesDomains = $this->ScenariosTerritoriesDomains->TerritoriesDomains->find('list', ['limit' => 200]);
        $scenarios = $this->ScenariosTerritoriesDomains->Scenarios->find('list', ['limit' => 200]);
        $this->set(compact('scenariosTerritoriesDomain', 'territoriesDomains', 'scenarios'));
        $this->set('_serialize', ['scenariosTerritoriesDomain']);*/

        $this->loadModel('Scenarios');
        $this->loadModel('TerritoriesDomains');

        $scenario_info = $this->Scenarios->get($scenario_id);
        $domain_id = $scenario_info->domain_id;

        $territories = $this->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id ]])
            ->contain(['Territories' => ['fields' => ['name']]]);

        $all_saved = true;
        if ($this->request->is('post')) {

            $data = $this->request->getData();

            echo json_encode($data);

            foreach($data as $key=> $value)
            {
                $scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->newEntity();
                $scenariosTerritoriesDomain->territory_domain_id = $key;
                $scenariosTerritoriesDomain->scenario_id = $scenario_id;
                $scenariosTerritoriesDomain->closed_population = $value['closed_population'];
                $scenariosTerritoriesDomain->migrations = $value['migrations'];
                $scenariosTerritoriesDomain->total_population = $value['total_population'];
                $scenariosTerritoriesDomain->habitants_per_lodge = $value['habitants_per_lodge'];
                $scenariosTerritoriesDomain->actual_total_population = $value['actual_total_population'];

                $all_saved = $this->ScenariosTerritoriesDomains->save($scenariosTerritoriesDomain);
                if (!$all_saved)
                {
                    break;
                }
            }

            /*if ($all_saved) {
                $this->Flash->success(__('The scenarios territorials domain has been saved.'));

                return $this->redirect(['controller' => 'Domains','action' => 'view', $domain_id]);
            }*/
            $this->Flash->error(__('The scenarios parameters could not be saved. Please, try again.'));
        }

        $this->set(compact('territories','scenario_id'));
        $this->set('_serialize', ['territories','scenario_id']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Scenarios Territories Domain id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->patchEntity($scenariosTerritoriesDomain, $this->request->getData());
            if ($this->ScenariosTerritoriesDomains->save($scenariosTerritoriesDomain)) {
                $this->Flash->success(__('The scenarios territories domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The scenarios territories domain could not be saved. Please, try again.'));
        }
        $territoriesDomains = $this->ScenariosTerritoriesDomains->TerritoriesDomains->find('list', ['limit' => 200]);
        $scenarios = $this->ScenariosTerritoriesDomains->Scenarios->find('list', ['limit' => 200]);
        $this->set(compact('scenariosTerritoriesDomain', 'territoriesDomains', 'scenarios'));
        $this->set('_serialize', ['scenariosTerritoriesDomain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Scenarios Territories Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scenariosTerritoriesDomain = $this->ScenariosTerritoriesDomains->get($id);
        if ($this->ScenariosTerritoriesDomains->delete($scenariosTerritoriesDomain)) {
            $this->Flash->success(__('The scenarios territories domain has been deleted.'));
        } else {
            $this->Flash->error(__('The scenarios territories domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
