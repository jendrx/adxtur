<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 4/27/17
 * Time: 11:30 AM
 */
namespace App\Controller;
use Cake\Datasource\ConnectionManager;

class HomesController extends AppController
{
    public function index()
    {
        $this->loadModel('ScenariosTerritoriesDomains');

        if($this->request->is('post'))
        {
            $data = $this->request->getData();

            $file_url = $this->uploadFile('uploads',$data['file'],null);

            $data = ($this->ScenariosTerritoriesDomains->importCsv($file_url,['id','actual_total_population','closed_population','migrations','total_population','habitants_per_lodge']));

            foreach($data as $row)
            {
                echo json_encode($row);
            }

        }


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

        $current_domain = $this->Domains->get($id, array('contain' => array('Studies','Scenarios','Features','Types')));

        $territories = $this->getTerritories($id, count($current_domain->types));

        $scenarios = $this->Domains->Scenarios->find('list',['field' => ['id','name'],'conditions' => ['domain_id' => $id]]);
        $studies = $this->Domains->Studies->find('list',['field' => ['id','name'],'conditions' => ['domain_id' => $id]]);

        $start_view = $this->getCentroid($id);
        $this->set(compact('current_domain','scenarios','studies','territories','start_view'));
        $this->set('_serialize', ['current_domain','scenarios','studies','territories','start_view']);
    }

//
//    public function getDomainData()
//    {
//        $this->loadModel('Domains');
//
//        $id = $this->request->getQueryParams()['domain'];
//
//        $q_territorials_data =  $this->Domains->find('all',['conditions' =>['id =' => $id]])->select([])
//            ->contain(['Territories' => ['fields' => ['TerritoriesDomains.domain_id','id','admin_type','municipality','parish','name']]]);
//
//        $domain_data = $this->Domains->find('all',['conditions' => ['id = ' => $id]])->select([])
//            ->contain(['Studies' => ['fields' => ['Studies.domain_id','id','name']]])
//            ->contain(['Features' => ['fields' => ['FeaturesDomains.domain_id','id','name']]])
//            ->contain(['Types' => ['fields' => ['TypesDomains.domain_id','id','name']]])
//            ->contain(['Scenarios' => ['fields' => ['Scenarios.domain_id','id','name']]]);
//
//        //extract geom of territorials
//        $spots_geojson = array();
//
//        $spots_params = array();
//
//
//        foreach ($q_territorials_data as $territorials_info )
//        {
//            foreach ($territorials_info->territories  as  $spot)
//            {
//                array_push($spots_params,$spot);
//            }
//        }
//
//        $territorials_geoJSON = array("type" => "FeatureCollection", "features" => $spots_geojson);
//
//        $response = compact('spots_params','territorials_geoJSON','domain_data');
//
//        $this->set(compact('response'));
//        $this->set('_serialize', ['response']);
//        $this->render('ajax');
//
//    }

    public function getPoliticTaxes()
    {
        $this->loadModel('StudiesTerritoriesDomains');

        $params = $this->request->getQueryParams();
        $study_id = $params['study'];
        $level = $params['level'];
        $parent= $params['parent'];

        $conditions = array();
        if($level > 1)
        {
            if($parent == null)
            {
                $conditions = array('parish is null');
            }
            else
            {
                $conditions = array('parish is  not null', 'parent_id = ' => $parent);
            }
        }

        $study = $this->StudiesTerritoriesDomains->find('all',['conditions' => ['study_id' => $study_id]])
            ->contain(['TerritoriesDomains' => ['Territories' => ['conditions' => $conditions ,'fields' => ['id','name']]]]);

        $study_taxes = array();

        foreach ($study as $study_territory)
        {
            $tax_rehab = round($study_territory->tax_rehab,3);
            $tax_construction = round($study_territory->tax_construction,3);
            $tax_anual_desertion = round($study_territory->tax_anual_desertion,3);

            array_push($study_taxes,array_merge(['territory'=> $study_territory->territories_domain->territory->name ],
                ['id' => $study_territory->territories_domain->territory->id]
                ,['tax_rehab' => $tax_rehab],
                ['tax_construction' => $tax_construction],['tax_anual_desertion' => $tax_anual_desertion]));
        }
        $response = $study_taxes;
        $this->set(compact('response'));
        $this->set('_serialize',['response']);
    }

    public function getTerritories($domain_id = null, $levels = null)
    {
        $this->loadModel('TerritoriesDomains');

        $territories = $this->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id]])
            ->contain(['Territories' => ['fields' => ['id','name','code','parent_id']]]);


        return $territories;

    }

    public function getCentroid($id = null)
    {
        $conn = ConnectionManager::get('default');

        $stmt = $conn->prepare('Select row_to_json(row) as centroid  from 
                                      (Select ST_X(centroid) as lon, ST_Y(centroid) as lat  From  ( Select ST_Centroid( ST_UNION(
		(SELECT ARRAY(select geom from territories_domains inner join territories on territories.id = territory_id where domain_id =:d_id)))) as centroid) p) row');

        $stmt->bindValue('d_id',$id,'integer');

        $stmt->execute();
        $row = $stmt->fetch('assoc')['centroid'];

        return $row;

    }


}