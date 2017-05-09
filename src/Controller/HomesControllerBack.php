<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 4/27/17
 * Time: 11:30 AM
 */

namespace App\Controller;


class HomesController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('home_layout');
        $this->loadModel('Domains');

        // get domains by user list
        $domains = $this->Domains->find('all')->select([]);

        $this->set(compact('domains'));
        $this->set('_serialize', ['domains']);

    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('home_layout');
        $this->loadModel('Domains');
        $domain_id = $id;
        $current_domain = $this->Domains->find('all',['conditions' => ['Domains.id =' => $id]])
            ->contain(['Features' => ['fields' => ['FeaturesDomains.domain_id','id','name']]])
            ->contain(['Scenarios' => ['fields' => ['Scenarios.domain_id','id','name']]])
            ->contain(['Studies' => ['fields' => ['Studies.domain_id','id','name']]]);

        $this->set(compact('domain_id','current_domain'));
        $this->set('_serialize', ['domain_id','current_domain']);
    }


    public function getDomainData()
    {
        $this->loadModel('Domains');

        $id = $this->request->getQueryParams()['domain'];

        $q_territorials_data =  $this->Domains->find('all',['conditions' =>['id =' => $id]])->select([])
            ->contain(['Territories' => ['fields' => ['TerritoriesDomains.domain_id','id','admin_type','municipality','parish','name']]]);

        $domain_data = $this->Domains->find('all',['conditions' => ['id = ' => $id]])->select([])
            ->contain(['Studies' => ['fields' => ['Studies.domain_id','id','name']]])
            ->contain(['Features' => ['fields' => ['FeaturesDomains.domain_id','id','name']]])
            ->contain(['Types' => ['fields' => ['TypesDomains.domain_id','id','name']]])
            ->contain(['Scenarios' => ['fields' => ['Scenarios.domain_id','id','name']]]);

        //extract geom of territorials
        $spots_geojson = array();

        $spots_params = array();


        foreach ($q_territorials_data as $territorials_info )
        {
            foreach ($territorials_info->territories  as  $spot)
            {
                array_push($spots_params,$spot);
            }
        }

        $territorials_geoJSON = array("type" => "FeatureCollection", "features" => $spots_geojson);

        $response = compact('spots_params','territorials_geoJSON','domain_data');

        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
        $this->render('ajax');

    }

    public function getPoliticTaxes()
    {
        $this->loadModel("TerritoriesDomains");

        $params = $this->request->getQueryParams();

        $domain_id = $params['domain'];
        $politic_id = $params['politic'];

        $data = $this->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id]])->select('id','territory_id')
            ->contain(['Territories' => ['conditions','fields' =>['id','name','admin_type','municipality','parish']]])
            ->contain(['Studies' => ['conditions' => ['Studies.id = ' => $politic_id],'fields' => ['id','studies_territories_domains.territory_domain_id']]]);

        $territorials_politics = array();

        foreach ($data as $territorial)
        {

            $territorial_data = $territorial->territory->toArray();

            foreach(($territorial->studies[0]->_joinData)->toArray() as $key=> $value)
            {

                if( $key == 'tax_rehab' || $key == 'tax_construction' || $key == 'tax_anual_desertion')
                {

                    $territorial_data = array_merge($territorial_data,[$key => $value]);

                }

            }
            array_push($territorials_politics, $territorial_data);
        }

        $response = $territorials_politics;

        $this->request->session()->delete('Config.language');
        $this->set(compact('response'));
        $this->set('_serialize',['response']);
    }


}