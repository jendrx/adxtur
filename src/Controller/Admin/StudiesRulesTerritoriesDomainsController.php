<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 11:43 AM
 */

namespace App\Controller\Admin;


use App\Controller\AppController;

class StudiesRulesTerritoriesDomainsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Studies', 'TerritoriesDomains', 'Rules']
        ];
        $studiesRulesTerritoriesDomains = $this->paginate($this->StudiesRulesTerritoriesDomains);

        $this->set(compact('studiesRulesTerritoriesDomains'));
        $this->set('_serialize', ['studiesRulesTerritoriesDomains']);
    }

    /**
     * View method
     *
     * @param string|null $id Studies Rules Territories Domain id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Studies');
        $studiesRulesTerritoriesDomain = $this->StudiesRulesTerritoriesDomains->get($id, [
            'contain' => ['Studies', 'TerritoriesDomains', 'Rules']
        ]);

        $this->set(compact('studiesRulesTerritoriesDomain'));
        $this->set('_serialize', ['studiesRulesTerritoriesDomain']);
    }

    public function add($study_id = null)
    {
        $threshold = 6;

        $this->loadModel('Censos');
        $this->loadModel('TerritoriesDomains');
        $this->loadModel('StudiesTerritoriesDomains');

        $study_info = $this->StudiesRulesTerritoriesDomains->Studies->get($study_id);
        $domain_id = $study_info->domain_id;

        $territories = $this->StudiesRulesTerritoriesDomains->TerritoriesDomains->find('all', ['conditions' => ['domain_id = ' => $domain_id]])
            ->contain(['Territories' => ['fields' => ['name', 'dicofre']]]);

        $studiesRulesTerritoriesDomains = $this->StudiesRulesTerritoriesDomains->newEntity();
        if ($this->request->is('post')) {

            $toSave = array();
            $data = $this->request->getData();

            foreach ($data as $entity)
            {
                foreach ($entity as $row)
                {
                    $studiesRulesTerritoriesDomains = $this->StudiesRulesTerritoriesDomains->newEntity();
                    $studiesRulesTerritoriesDomains->set('study_id',$study_id);
                    $this->StudiesRulesTerritoriesDomains->patchEntity($studiesRulesTerritoriesDomains,$row);
                    array_push($toSave,$studiesRulesTerritoriesDomains);
                }
            }

            if($this->StudiesRulesTerritoriesDomains->saveMany($toSave))
            {
                $this->Flash->success(__('The studies rules territories domain has been saved.'));
                $toSave = array();

                foreach($territories as $territory)
                {
                    $studiesTerritoriesDomain = $this->StudiesTerritoriesDomains->newEntity();
                    $territory_domain_id = $territory['id'];
                    $dicofre = $territory['territory']['dicofre'];

                    $rules = $this->StudiesRulesTerritoriesDomains->getTerritoryRules($territory_domain_id,$study_id);


                    $results = $this->Censos->getTerritoryCensosResults($dicofre,$study_info->projection_years,$rules,$threshold);
                    $studiesTerritoriesDomain->set('actual_lodges',$results['actual_lodges']);
                    $studiesTerritoriesDomain->set('tax_anual_desertion',$results['tax_anual_desertion']);
                    $studiesTerritoriesDomain->set('tax_actual_first_lodges',$results['tax_actual_first_lodges']);
                    $studiesTerritoriesDomain->set('tax_actual_second_lodges',$results['tax_actual_second_lodges']);
                    $studiesTerritoriesDomain->set('tax_actual_empty_lodges',$results['tax_actual_empty_lodges']);
                    $studiesTerritoriesDomain->set('total_actual_empty_lodges',$results['total_actual_empty_lodges']);
                    $studiesTerritoriesDomain->set('total_actual_empty_avail_lodges',$results['total_actual_empty_avail_lodges']);
                    $studiesTerritoriesDomain->set('total_actual_empty_rehab_lodges',$results['total_actual_empty_rehab_lodges']);
                    $studiesTerritoriesDomain->set('study_id',$study_id);
                    $studiesTerritoriesDomain->set('territory_domain_id',$territory_domain_id);


                    array_push($toSave,$studiesTerritoriesDomain);
                }

                $entities = $this->StudiesTerritoriesDomains->saveMany($toSave);
                if($entities)
                {
                    return $this->redirect(['controller' => 'Domains','action' => 'view',$domain_id]);
                }
            }

            $this->Flash->error(__('The studies rules territories domain could not be saved. Please, try again.'));
        }

        $rules = $this->StudiesRulesTerritoriesDomains->Rules->find('all');
        $this->set(compact('studiesRulesTerritoriesDomains','territories', 'rules'));
        $this->set('_serialize', ['studiesRulesTerritoriesDomains','territories','rules']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Studies Rules Territories Domain id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studiesRulesTerritoriesDomain = $this->StudiesRulesTerritoriesDomains->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studiesRulesTerritoriesDomain = $this->StudiesRulesTerritoriesDomains->patchEntity($studiesRulesTerritoriesDomain, $this->request->getData());
            if ($this->StudiesRulesTerritoriesDomains->save($studiesRulesTerritoriesDomain)) {
                $this->Flash->success(__('The studies rules territories domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The studies rules territories domain could not be saved. Please, try again.'));
        }
        $studies = $this->StudiesRulesTerritoriesDomains->Studies->find('list', ['limit' => 200]);
        $territoriesDomains = $this->StudiesRulesTerritoriesDomains->TerritoriesDomains->find('list', ['limit' => 200]);
        $rules = $this->StudiesRulesTerritoriesDomains->Rules->find('list', ['limit' => 200]);
        $this->set(compact('studiesRulesTerritoriesDomain', 'studies', 'territoriesDomains', 'rules'));
        $this->set('_serialize', ['studiesRulesTerritoriesDomain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Studies Rules Territories Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studiesRulesTerritoriesDomain = $this->StudiesRulesTerritoriesDomains->get($id);
        if ($this->StudiesRulesTerritoriesDomains->delete($studiesRulesTerritoriesDomain)) {
            $this->Flash->success(__('The studies rules territories domain has been deleted.'));
        } else {
            $this->Flash->error(__('The studies rules territories domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}