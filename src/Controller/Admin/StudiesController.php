<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 11:10 AM
 */

namespace App\Controller\Admin;


use App\Controller\AppController;

class StudiesController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'contain' => ['Domains']
        ];
        $studies = $this->paginate($this->Studies);

        $this->set(compact('studies'));
        $this->set('_serialize', ['studies']);
    }

    public function view($id = null)
    {
        //$this->loadModel('StudiesRulesTerritoriesDomains');
        $this->loadModel('Rules');
        $study = $this->Studies->get($id, [
            'contain' => ['Domains', 'TerritoriesDomains' =>['Territories' =>['fields' => ['name']]],

            ]]);

        $studiesRules = array();

        foreach ($study->territories_domains as $territory_domain)
        {
            $rules = $this->Studies->StudiesRulesTerritoriesDomains->find('all',['conditions' => ['study_id = ' => $id,'territory_domain_id = ' => $territory_domain->id]]);
            $studiesRules[$territory_domain->territory->name] = $rules;
        }


        $rules = $this->Rules->find('all',['order' => ['id']]);
        $this->set(compact('study','studiesRules','rules'));
        $this->set('_serialize', ['study','studiesRules','rules']);
    }

    public function add($domain_id = null)
    {

        if ($domain_id === null) {
            $this->Flash->error(__('There is no associated domain.'));
            return $this->redirect(['controller' => 'Domains', 'action' => 'index']);
        }


        $this->loadModel('Scenarios');
        $proj_years = $this->Scenarios->getProjectionYearsList($domain_id);

        if (empty($proj_years->toArray())) {
            $this->Flash->error(__('There is no associated scenario.'));
            return $this->redirect(['controller' => 'Domains', 'action' => 'index']);
        }

        $this->loadModel('Domains');
        $this->loadModel('TerritoriesDomains');
        $this->loadModel('Rules');
        $this->loadModel('StudiesRulesTerritoriesDomains');

        $territories = $this->Domains->getTerritories($domain_id, ['dicofre', 'name']);
        $rules = $this->Rules->getAllRules();


        $study = $this->Studies->newEntity();
        if ($this->request->is('post')) {

            //$data = $this->request->getData();
            $study->domain_id = $domain_id;
            $study = $this->Studies->patchEntity($study, $this->request->getData());

            $errors = $study->getErrors();
            if($errors)
            {
                $this->Flash->error(__('Entity Validation error'));
                return $this->redirect(['controller' => 'Studies', 'action' => 'add', $domain_id]);
            }

            if ($this->Studies->save($study)) {
                $this->Flash->success(__('The study has been saved.'));
                return $this->redirect(['controller' => 'StudiesRulesTerritoriesDomains', 'action' => 'add', $study->id]);

            }
            $this->Flash->error(__('The study could not be saved. Please, try again.'));

        }

        $this->set(compact('study', 'proj_years', 'rules', 'territories'));
        $this->set('_serialize', ['proj_years', 'rules', 'territories']);
    }

    public function edit($id = null)
    {
        $study = $this->Studies->get($id, [
            'contain' => ['TerritoriesDomains']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $study = $this->Studies->patchEntity($study, $this->request->getData());
            if ($this->Studies->save($study)) {
                $this->Flash->success(__('The study has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The study could not be saved. Please, try again.'));
        }
        $domains = $this->Studies->Domains->find('list', ['limit' => 200]);
        $territoriesDomains = $this->Studies->TerritoriesDomains->find('list', ['limit' => 200]);
        $this->set(compact('study', 'domains', 'territoriesDomains'));
        $this->set('_serialize', ['study']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $study = $this->Studies->get($id);
        if ($this->Studies->delete($study)) {
            $this->Flash->success(__('The study has been deleted.'));
        } else {
            $this->Flash->error(__('The study could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}