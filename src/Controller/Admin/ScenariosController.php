<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 10:39 AM
 */

namespace App\Controller\Admin;


use App\Controller\AppController;

class ScenariosController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'contain' => ['Domains']
        ];
        $scenarios = $this->paginate($this->Scenarios);

        $this->set(compact('scenarios'));
        $this->set('_serialize', ['scenarios']);
    }

    public function view($id = null)
    {
        $scenario = $this->Scenarios->get($id, [
            'contain' => ['Domains', 'TerritoriesDomains' => ['Territories' => ['fields' => ['name']]]]
        ]);

        $this->set('scenario', $scenario);
        $this->set('_serialize', ['scenario']);
    }

    public function add($domain_id = null)
    {
        $this->loadModel('TerritoriesDomains');
        $this->loadModel('Rules');
        $scenario = $this->Scenarios->newEntity();


        if ($this->request->is('post')) {

            $scenario->domain_id = $domain_id;
            $data = $this->request->getData();

            $scenario = $this->Scenarios->patchEntity($scenario, $data);

            if ($this->Scenarios->save($scenario)) {
                $this->Flash->success(__('The scenario has been saved.'));
                return $this->redirect(['controller'=>'scenariosTerritoriesDomains', 'action' => 'add', $scenario->id]);
            }
            $this->Flash->error(__('The scenario could not be saved. Please, try again.'));
        }

        $this->set(compact('scenario','territoriesDomains'));
        $this->set('_serialize', ['scenario']);
    }

    public function edit($id = null)
    {
        $scenario = $this->Scenarios->get($id, [
            'contain' => ['TerritoriesDomains']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scenario = $this->Scenarios->patchEntity($scenario, $this->request->getData());
            if ($this->Scenarios->save($scenario)) {
                $this->Flash->success(__('The scenario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The scenario could not be saved. Please, try again.'));
        }
        $domains = $this->Scenarios->Domains->find('list', ['limit' => 200]);
        $territoriesDomains = $this->Scenarios->TerritoriesDomains->find('list', ['limit' => 200]);
        $this->set(compact('scenario', 'domains', 'territoriesDomains'));
        $this->set('_serialize', ['scenario']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scenario = $this->Scenarios->get($id);
        if ($this->Scenarios->delete($scenario)) {
            $this->Flash->success(__('The scenario has been deleted.'));
        } else {
            $this->Flash->error(__('The scenario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}