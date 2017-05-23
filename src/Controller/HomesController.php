<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 4/27/17
 * Time: 11:30 AM
 */
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\View\ViewBuilder;
use Cake\Routing\Router;


class HomesController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('home_layout');
        $this->loadModel('Domains');

        // get domains by user list
        $domains = $this->Domains->find('all');
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


        $this->set(compact('current_domain','studies','scenarios','territories','start_view'));
        $this->set('_serialize', ['current_domain','studies','scenarios','territories','start_view']);
    }

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

    public function updateStudyRules()
    {
        $this->loadModel('Rules');
        $this->loadModel('Studies');
        $this->loadModel('StudiesRulesTerritoriesDomains');

        $params = $this->request->getQueryParams();
        $studyId = $params['study'];

        $studyRules = array();
        $rules = array();
        if($this->request->is(['ajax']))
        {
            $this->viewBuilder()->setLayout('ajax');

            $study = $this->Studies->get($studyId, [
                'contain' => ['Domains', 'TerritoriesDomains' =>['Territories' =>['fields' => ['name']]]]]);

            foreach ($study->territories_domains as $territory_domain)
            {
                $rules = $this->StudiesRulesTerritoriesDomains->find('all',['conditions' => ['study_id = ' => $studyId,'territory_domain_id = ' => $territory_domain->id]]);


                $studyRules[$territory_domain->territory->name] = $rules;

            }

            $rules = $this->Rules->find('all',['order' => ['id']]);
        }

        $content = compact('rules','studyRules');

        $this->set(compact('content'));
        $this->set('_serialize',['content']);
    }

    public function getScenarios()
    {
        $this->loadModel('Scenarios');
        $this->loadModel('Studies');

        $content = array();
        if($this->request->is(['ajax']))
        {
            $this->viewBuilder()->setLayout('ajax');
            $params = $this->request->getQueryParams();
            $study_id = $params['study'];
            $study_info = $this->Studies->get($study_id);

            $content = $this->Scenarios->find('list',
                ['conditions' => ['domain_id = ' => $study_info->domain_id, 'projection_years = ' => $study_info->projection_years, 'actual_year = ' => $study_info->actual_year]]);

        }

        $this->set(compact('content'));
        $this->set('_serialize',['content']);

    }

    public function exportCsv()
    {
        $this->loadModel('Scenarios');

        $path = null;

        if ($this->request->is('post'))
        {
            $params = $this->request->getData();
            $studyId = $params['study'];
            $scenarioId = $params['scenario'];
            $studiesTerritoriesDomains = $params['studiesTerritoriesDomains'];
            $locals = $studiesTerritoriesDomains['locals'];
            $globals = $studiesTerritoriesDomains['global_predict'];

            $scenarioName = $this->Scenarios->find('all',['conditions' => ['id' => $scenarioId]])->select('name')->first();

            // Params
            $_serialize = 'locals';
            $_delimiter = ',';
            $_enclosure = '"';
            $_newline = '\r\n';
            $_extract = array('name','tax_construction','tax_rehab','tax_anual_desertion','predict_tax_period_variance_lodges',
                'predicted_empty_avail_lodges','predicted_empty_rehab_lodges', 'predicted_first_lodges','predicted_second_lodges','predicted_population_variance',
                'predicted_required_lodges', 'predicted_tax_anual_mean_lodges','predicted_total_empty_lodges');

            $_header = array('Território','Taxa Construção','Taxa Reabilitação','Taxa de demolição','Taxa de variação de Alojamentos', 'Alojamentos Vagos Disponiveis',
                            'Alojamentos Vagos Reabilitação','Alojamentos 1º residência','Alojamentos 2º residência','Variação da População','Alojamentos Necessários',
                            'Taxa Anual Média de Alojamentos','Alojamentos Vagos Total');

            $_footer = array('Global',$globals['predicted_mean_tax_construction'],$globals['predicted_mean_tax_rehab'],'','','','','','','','','',$globals['predicted_empty_lodges']);

            $builder = new ViewBuilder;
            $builder->layout = false;
            $builder->setClassName('CsvView.Csv');

            // Then the view
            $view = $builder->build($locals);
            $view->set(compact('locals', '_serialize', '_delimiter', '_enclosure', '_newline','_extract','_header','_footer'));



            $fileName = str_replace(' ', '_', $scenarioName['name']);
            $folder = 'uploads';

            $relPath = $folder.DS.$fileName.'.csv';
            $fullPath = WWW_ROOT.DS.$relPath;
            $file = new File($fullPath, true, 0644);
            $file->write($view->render());
            $path = $file->path;

        }

        $url = Router::url($relPath,true);

        //$this->set( json_encode(["url" => Router::url($relPath,true)]);
        $this->set( compact('url'));
        $this->set('_serialize',['url']);

    }

}