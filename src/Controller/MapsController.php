<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 4/27/17
 * Time: 11:28 AM
 */

namespace App\Controller;


class MapsController extends AppController
{


    public function getTerritorialLayer()
    {
        $this->loadModel('Domains');

        $query_params = $this->request->getQueryParams();

        $parent = $query_params['parent'];

        $levels = $query_params['level'];

        $domain_id = $query_params['domain'];



        $conditions = array();
        if ($levels > 1)
        {
            if($parent == null)
            {
                $conditions = array('parish is null');

                //$q_territorials = $this->Domains->find('all',['conditions' => ['id = ' => $domain_id]])->select([])
                  //  ->contain(['Territories' => ['conditions' => ['admin_type = ' => 'municipality' ],'fields' => ['TerritoriesDomains.domain_id','geom_geoJson']]]);

            }
            else
            {
                $conditions = array('parish is not null', 'parent_id' => $parent);

                //$q_territorials = $this->Domains->find('all',['conditions' => ['id = ' => $domain_id]])->select([])
                //    ->contain(['Territories' => ['conditions' => ['admin_type = ' => 'parish', 'municipality = ' => $municipality ],'fields' => ['TerritoriesDomains.domain_id','geom_geoJson']]]);

            }
        }
        $q_territorials = $this->Domains->find('all',['conditions' => ['id = ' => $domain_id]])->select([])
            ->contain(['Territories' => ['fields' => ['TerritoriesDomains.domain_id','geom_geoJson'],'conditions' => $conditions]]);

        $spots_geoJSON = array();

        // iterate over spots

        foreach ($q_territorials as $territorials_info )
        {

            foreach ($territorials_info->territories  as  $spot)
            {
                array_push($spots_geoJSON,json_decode($spot['geom_geoJson']));
            }
        }

        $response = $this->toFeatureCollection($spots_geoJSON);

        $this->set(compact('response'));
        $this->set('_serialize',['response']);

    }

    private function toFeatureCollection($territories = null)
    {
        return array("type" => "FeatureCollection", "features" => $territories);
    }


}