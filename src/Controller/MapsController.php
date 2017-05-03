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
        $query_params = $this->request->getQueryParams();

        $municipality = $query_params['municipality'];

        $types = $query_params['types'];

        $admin_type = $query_params['admin_type'];

        $id = $query_params['domain'];

        $this->loadModel('Domains');

        if ($types > 1)
        {
            if('municipality' == $admin_type)
            {
                $q_territorials = $this->Domains->find('all',['conditions' => ['id = ' => $id]])->select([])
                    ->contain(['Territories' => ['conditions' => ['admin_type = ' => 'municipality' ],'fields' => ['TerritoriesDomains.domain_id','geom_geoJson']]]);

            }
            else
            {
                $q_territorials = $this->Domains->find('all',['conditions' => ['id = ' => $id]])->select([])
                    ->contain(['Territories' => ['conditions' => ['admin_type = ' => 'parish', 'municipality = ' => $municipality ],'fields' => ['TerritoriesDomains.domain_id','geom_geoJson']]]);

            }
        }
        else
        {
            $q_territorials = $this->Domains->find('all',['conditions' => ['id = ' => $id]])->select([])
                ->contain(['Territories' => ['fields' => ['TerritoriesDomains.domain_id','geom_geoJson']]]);
        }

        $spots_geoJSON = array();

        // iterate over spots


        //echo json_encode($q_territorials->toArray());
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