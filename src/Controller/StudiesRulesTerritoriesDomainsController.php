<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\TerritoriesDomain;

/**
 * StudiesRulesTerritoriesDomains Controller
 *
 * @property \App\Model\Table\StudiesRulesTerritoriesDomainsTable $StudiesRulesTerritoriesDomains
 */
class StudiesRulesTerritoriesDomainsController extends AppController{

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
        $studiesRulesTerritoriesDomain = $this->StudiesRulesTerritoriesDomains->get($id, [
            'contain' => ['Studies', 'TerritoriesDomains', 'Rules']
        ]);

        $this->set('studiesRulesTerritoriesDomain', $studiesRulesTerritoriesDomain);
        $this->set('_serialize', ['studiesRulesTerritoriesDomain']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($study_id = null)
    {
        $threshold = 6;

        $this->loadModel('TerritoriesDomains');
        $this->loadModel('StudiesTerritoriesDomains');

        $study_info = $this->StudiesRulesTerritoriesDomains->Studies->get($study_id);
        $domain_id = $study_info->domain_id;

        $territories = $this->StudiesRulesTerritoriesDomains->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id ]])
            ->contain(['Territories' => ['fields' => ['name','dicofre']]]);


        if ($this->request->is('post')) {

            $toSave = array();
            $data = $this->request->getData();
            $saved = true;
            foreach ($data as $key=>$value)
            {
                foreach ($value as $k=>$v)
                {
                    $studiesRulesTerritoriesDomain = $this->StudiesRulesTerritoriesDomains->newEntity();
                    $studiesRulesTerritoriesDomain->study_id = $study_id;
                    $studiesRulesTerritoriesDomain->territory_domain_id = $key;
                    $studiesRulesTerritoriesDomain->rule_id = $k;
                    $studiesRulesTerritoriesDomain->value = $v;

                    /*if($studiesRulesTerritoriesDomain->getErrors())
                    {
                        $this->Flash->success(__('Fuck OFF.'));
                        return $this->redirect(['action' => 'add', $study_id]);

                    }*/

                    array_push($toSave,$studiesRulesTerritoriesDomain);


                   /*$saved = $this->StudiesRulesTerritoriesDomains->save($studiesRulesTerritoriesDomain);
                    if (!$saved)
                        break;*/
                }
            }
            //if all saved
            if($this->StudiesRulesTerritoriesDomains->saveMany($toSave))
            {
                $this->Flash->success(__('The studies rules territories domain has been saved.'));

                foreach($data as $key => $value)
                {

                    $results = $this->getStudiesTerritoriesResults($key,$study_id,$value,$threshold);

                    $studiesTerritoriesDomain = $this->StudiesTerritoriesDomains->newEntity();

                    $studiesTerritoriesDomain->actual_lodges =  $results['actual_lodges'];
                    $studiesTerritoriesDomain->tax_anual_desertion = $results['tax_anual_desertion'];
                    $studiesTerritoriesDomain->tax_actual_first_lodges = $results['tax_actual_first_lodges'];
                    $studiesTerritoriesDomain->tax_actual_second_lodges = $results['tax_actual_second_lodges'];
                    $studiesTerritoriesDomain->tax_actual_empty_lodges =  $results['tax_actual_empty_lodges'];
                    $studiesTerritoriesDomain->total_actual_empty_lodges =$results['total_actual_empty_lodges'];
                    $studiesTerritoriesDomain->total_actual_empty_avail_lodges = $results['total_actual_empty_avail_lodges'];
                    $studiesTerritoriesDomain->total_actual_empty_rehab_lodges = $results['total_actual_empty_rehab_lodges'];
                    $studiesTerritoriesDomain->study_id = $results['study_id'];
                    $studiesTerritoriesDomain->territory_domain_id = $results['territory_domain_id'];

                    $this->StudiesTerritoriesDomains->save($studiesTerritoriesDomain);

                }

                return $this->redirect(['action' => 'index']);
            }



            $this->Flash->error(__('The studies rules territories domain could not be saved. Please, try again.'));
        }

        $rules = $this->StudiesRulesTerritoriesDomains->Rules->find('all');
        $this->set(compact('territories', 'rules'));
        $this->set('_serialize', ['studiesRulesTerritoriesDomain']);
    }

    public function getStudiesTerritoriesResults($territory_domain,$study_id,$rules,$threshold)
    {
        $this->loadModel('TerritoriesDomains');
        $this->loadModel('Studies');

        $territory_info = $this->TerritoriesDomains->get($territory_domain,['contain' =>['Territories' => ['fields' => ['dicofre','name']]]]);
        $study_info = $this->Studies->get($study_id);

        $dicofre = $territory_info->territory->dicofre;


        $actual_lodges =  $this->getActualLodges($dicofre);
        $desertion_tax = $this->getDesertionTax($dicofre,$rules);
        $predicted_lodges = $actual_lodges - $desertion_tax;
        $tax_anual_desertion = pow(($predicted_lodges / $actual_lodges),(1/$study_info->projection_years)) - 1;
        $tax_actual_first_lodges = $this->getFirstLodges($dicofre) / $actual_lodges;
        $tax_actual_second_lodges = $this->getSecondLodges($dicofre) / $actual_lodges;

        $empty_lodges =  $this->getEmptyLodges($dicofre);
        $tax_actual_empty_lodges = $empty_lodges/ $actual_lodges;
        $total_actual_empty_lodges = $predicted_lodges * $tax_actual_empty_lodges;

        $at_market_lodges = $this->getEmptySaleLodges($dicofre) + $this->getEmptyLoanLodges($dicofre)
            - ($this->getSomeEmptySaleLodges($dicofre,$threshold) + $this->getSomeEmptyLoanLodges($dicofre,$threshold));
        $rehab_lodges = ($this->getEmptyDemolishedLodges($dicofre)
                + $this->getEmptyOtherLodges($dicofre)) + $this->getSomeEmptyLoanLodges($dicofre,$threshold) + $this->getSomeEmptySaleLodges($dicofre,$threshold) ;

        $weight_at_market = $at_market_lodges / ($at_market_lodges + $rehab_lodges);
        $weight_rehab = $rehab_lodges / ($at_market_lodges + $rehab_lodges);

        $total_actual_empty_avail_lodges = $total_actual_empty_lodges * $weight_at_market;
        $total_actual_empty_rehab_lodges = $total_actual_empty_lodges * $weight_rehab;

        return array('actual_lodges' => $actual_lodges,'tax_anual_desertion' => $tax_anual_desertion,'tax_actual_first_lodges' => $tax_actual_first_lodges,
            'tax_actual_second_lodges' => $tax_actual_second_lodges, 'tax_actual_empty_lodges' => $tax_actual_empty_lodges, 'total_actual_empty_lodges' => $total_actual_empty_lodges,
            'total_actual_empty_avail_lodges' => $total_actual_empty_avail_lodges, 'total_actual_empty_rehab_lodges' => $total_actual_empty_rehab_lodges,
            'study_id' => $study_info->id, 'territory_domain_id' => $territory_domain);

    }

    public function getDesertionTax($territory,$rules)
    {
        $tax = 0;

        $lodges_dist = $this->getLodgesDistribution();

        foreach ($rules as $key=>$value)
        {

            $tax =  $tax + ($this->getLodgesAtAgeGroup($territory,$key) * ($value / $lodges_dist));

        }

        return $tax;
    }

    public function getLodgesDistribution()
    {
        $this->loadModel('Rules');

        // get dicofre
        $query = $this->Rules->find('all');
        $query->select([
            'value' => $query->func()->sum('1/(end_age-start_age)::float')
        ]);
        return (float)$query->toArray()[0]->value;

    }

    public function getActualLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'actual_lodges' => $query->func()->sum('total_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->actual_lodges;
    }

    public function getFirstLodges($dicofre)
    {
        $this->loadModel('Censos');


        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'first_lodges' => $query->func()->sum('total_occupied_first_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->first_lodges;
    }

    public function getSecondLodges($dicofre)
    {

        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'second_lodges' => $query->func()->sum('total_occupied_second_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->second_lodges;

    }

    public function getEmptyLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_lodges' => $query->func()->sum('total_empty_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_lodges;

    }

    public function getLodgesAtAgeGroup($dicofre,$rule_id)
    {

        $this->loadModel('Censos');
        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id = ' => $rule_id],'fields' => ['total_lodges']]);

        return  $query->toArray()[0]->total_lodges;

    }

    public function getEmptySaleLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_sale_lodges' => $query->func()->sum('empty_sale_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_sale_lodges;

    }

    public function getSomeEmptySaleLodges($dicofre,$rule)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id <= ' => $rule]]);
        $query->select([
            'empty_sale_lodges' => $query->func()->sum('empty_sale_lodges')
        ]);
        return $query->toArray()[0]->empty_sale_lodges;
    }

    public function getEmptyLoanLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_loan_lodges' => $query->func()->sum('empty_loan_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_loan_lodges;
    }

    public function getSomeEmptyLoanLodges($dicofre,$rule)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id <= ' => $rule]]);
        $query->select([
            'empty_loan_lodges' => $query->func()->sum('empty_loan_lodges')
        ]);
        return $query->toArray()[0]->empty_loan_lodges;
    }

    public function getSomeEmptyRehabLodges($dicofre,$rule)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre, 'rule_id <= ' => $rule]]);
        $query->select([
            'empty_loan_lodges' => $query->func()->sum('empty_loan_lodges')
        ]);
        return $query->toArray()[0]->empty_loan_lodges;
    }

    public function getEmptyDemolishedLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_demolished_lodges' => $query->func()->sum('empty_demolished_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_demolished_lodges;
    }

    public function getEmptyOtherLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_other_lodges' => $query->func()->sum('empty_other_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_other_lodges;
    }

    public function getEmptyRehabLodges($dicofre)
    {
        $this->loadModel('Censos');

        // get dicofre
        $query = $this->Censos->find('all', ['conditions' => ['dicofre = ' => $dicofre]]);
        $query->select([
            'empty_rehab_lodges' => $query->func()->sum('total_empty_lodges')
        ])
            ->group('dicofre');
        return $query->toArray()[0]->empty_rehab_lodges;
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


    public function updateTaxes()
    {
        $message = 'This request is not available';

        if($this->request->is(['ajax','post','put']))
        {
            $toSave = array();
            $this->loadModel('StudiesTerritoriesDomains');
            $this->loadModel('Studies');
            $data = $this->request->getData();
            $study_id = $data['study'];

            $study_info = $this->Studies->get($study_id);
            $territories_taxes = $data['table_data'];


            foreach($territories_taxes as $territory_tax)
            {
                $territoryDomain = $this->StudiesTerritoriesDomains->TerritoriesDomains->find('all',
                    ['conditions' => ['domain_id = ' => $study_info->domain_id,'territory_id = ' => $territory_tax['id']]]);

                $studiesTerritoriesDomainsInfo = $this->StudiesTerritoriesDomains->find('all',
                    ['conditions' =>['study_id = ' => $study_id,'territory_domain_id = ' => $territoryDomain->select('id')->first()->id]]);

                $updated_taxes = array('tax_rehab' => $territory_tax['tax_rehab'], 'tax_construction' => $territory_tax['tax_construction']);

                $studiesTerritoriesDomains = $this->StudiesTerritoriesDomains->get($studiesTerritoriesDomainsInfo->select('id')->first()->id);
                $studiesTerritoriesDomains = $this->StudiesTerritoriesDomains->patchEntity($studiesTerritoriesDomains,$updated_taxes);

                array_push($toSave,$studiesTerritoriesDomains);

            }

            if($this->StudiesTerritoriesDomains->saveMany($toSave))
                $message = 'Taxes has been updated';
            else
                $message = 'Taxes has not been updated';

        }

        $this->set(compact('message'));
        $this->set('_serialize',['message']);


    }
}
