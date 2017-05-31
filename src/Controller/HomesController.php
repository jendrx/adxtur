<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 4/27/17
 * Time: 11:30 AM
 */
namespace App\Controller;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use Cake\View\ViewBuilder;


class HomesController extends AppController
{
    public function isAuthorized($user)
    {
        $this->loadModel('UsersDomains');

        if (isset($user) && $user['role'] == 'user')
        {

            if ($this->request->getParam('action') == 'view') {
                $domain_id = $this->request->getParam('pass.0');

                if (!$this->UsersDomains->isOwnedBy($domain_id, $user['id']))
                    return false;
            }
            return true;
        }



        return parent::isAuthorized($user); // TODO: Change the autogenerated stub
    }


    public function index()
    {
        $user = $this->Auth->user();
        $this->viewBuilder()->setLayout('homeLayout');
        $this->loadModel('Domains');


        if ($user['role'] === 'admin')
            $domains = $this->Domains->find('all');
        else
        {
            $domains = $this->Domains->getDomainsByUser($user['id']);
        }
        $this->set(compact('domains'));
        $this->set('_serialize', ['domains']);

    }

    public function view($id = null)
    {
        $user = $this->Auth->user();
        $this->viewBuilder()->setLayout('homeLayout');
        $this->loadModel('Domains');
        $this->loadModel('Studies');

        $current_domain = $this->Domains->get($id, array('contain' => array('Studies','Scenarios','Features','Types')));
        $territories = $this->getTerritories($id, count($current_domain->types));
        $scenarios = $this->Domains->Scenarios->find('list',['field' => ['id','name'],'conditions' => ['domain_id' => $id]]);
        $studies = $this->Domains->Studies->find('list',['field' => ['id','name'],'conditions' => ['domain_id' => $id]]);


        $start_view = $this->Domains->getCentroid($id);


        $this->set(compact('current_domain','studies','scenarios','territories','start_view'));
        $this->set('_serialize', ['current_domain','studies','scenarios','territories','start_view']);
    }


    // updated function, missing level treatement
    public function getPoliticTaxes()
    {
        $this->loadModel('StudiesTerritoriesDomains');
        $this->loadModel('Studies');

        $params = $this->request->getQueryParams();
        $study_id = $params['study'];
        $level = $params['level'];
        $parent= $params['parent'];

        $conditions = array();
//        if($level > 1)
//        {
//            if($parent == null)
//            {
//                $conditions = array('parish is null');
//            }
//            else
//            {
//                $conditions = array('parish is  not null', 'parent_id = ' => $parent);
//            }
//        }
//
//        $study = $this->StudiesTerritoriesDomains->find('all',['conditions' => ['study_id' => $study_id]])
//            ->contain(['TerritoriesDomains' => ['Territories' => ['conditions' => $conditions ,'fields' => ['id','name']]]]);

        $study_taxes = array();

        $response = $this->StudiesTerritoriesDomains->getTaxesbyStudy($study_id,$this->Studies->getTerritories($study_id));
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