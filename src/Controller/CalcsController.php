<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 4/27/17
 * Time: 11:29 AM
 */

namespace App\Controller;


class CalcsController extends AppController
{

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->loadModel('TerritoriesDomains');
    }


    public function ajaxGetResults()
    {
        $params = $this->request->getQueryParams();


        $response = $this->getResults($params['domain'],$params['politic'],$params['scenario'],$params['taxes'],$params['levels'],$params['parent']);


        $this->set(compact('response'));
        $this->set('_serialize',['response']);
    }

    public function getResults($domain = null, $study = null, $scenario = null, $taxes = null, $levels = null ,$parent = null)
    {
        //Get request parameters(taxes,domain,politic)
        $this->loadModel('Studies');

        $study_info = $this->Studies->get($study);
        $projection_years = $study_info->projection_years;


        //length case study  = 1
        //find political territorial values
        $territories = $this->filterTerritoryData($domain,$study,$scenario,$levels,$parent);

        // get actual globals
        $global_actual = $this->aggGlobal($territories);

        //merge territories with taxes
        $merged = $this->mergeTaxTerritory($territories,$taxes);

        $locals = $this->getLocalsPredict($merged,$global_actual,$projection_years);

        $global_predict = $this->getGlobalsPredict($merged,$global_actual,$projection_years);

        return compact('global_predict','locals');
   }

    private function filterTerritoryData($domain_id, $study_id, $scenario_id, $levels, $parent)
    {
        $conditions = array();
        if ($levels > 1)
        {
            if($parent == '')
            {
                $conditions = array('Territories.parish' => null);

                /*$territory_study_values = $this->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id]])->select('id','territory_id')
                    ->contain(['Territories' => ['conditions' => ['Territories.parish ' => null ],'fields' =>['id','name']]])
                    ->contain(['Scenarios' => ['conditions' => ['Scenarios.id = ' => $scenario_id],'fields' => ['id', 'ScenariosTerritoriesDomains.territory_domain_id']]])
                    ->contain(['Studies' => ['conditions' => ['Studies.id = ' => $study_id],'fields' => []]]);
                */
            }
            else
            {
                $conditions = array('Territories.parish is not null','Territories.parent_id =' => $parent);

                /*$territory_study_values = $this->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id]])->select('id','territory_id')
                    ->contain(['Territories' => ['conditions' => ['Territories.parish is  not null','Territories.municipality = ' => $parent],'fields' =>['id','name']]])
                    ->contain(['Scenarios' => ['conditions' => ['Scenarios.id = ' => $scenario_id],'fields' => ['id', 'ScenariosTerritoriesDomains.territory_domain_id']]])
                    ->contain(['Studies' => ['conditions' => ['Studies.id = ' => $study_id],'fields' => []]]);
                */

            }
        }


        $territory_study_values = $this->TerritoriesDomains->find('all',['conditions' => ['domain_id = ' => $domain_id]])->select('id','territory_id')
            ->contain(['Territories' => ['conditions' => $conditions,'fields' =>['id','name']]])
            ->contain(['Scenarios' => ['conditions' => ['Scenarios.id = ' => $scenario_id],'fields' => ['id','ScenariosTerritoriesDomains.territory_domain_id']]])
            ->contain(['Studies' => ['conditions' => ['Studies.id = ' => $study_id],'fields' => []]]);

        $current_scenario = array();
        $current_study = array();
        $territories = array() ;
        
        

        foreach ($territory_study_values as $territory)
        {
            foreach ($territory['scenarios'] as $scenarios)
            {
                $current_scenario = ($scenarios['_joinData']->toArray());
            }

            foreach ($territory['studies'] as $studies)
            {
                $current_study =  ($studies['_joinData'])->toArray();
            }
            
            array_push($territories, array_merge($current_study,$current_scenario,$territory['territory']->toArray()));
        }
        return $territories;
    }

    private function getGlobalsPredict($territories,$global_actual,$projection_years)
    {
        $result = array('predicted_total_lodges' => $this->getGlobalPredictLodges($territories,$projection_years),
            'predicted_empty_lodges' => $this->getGlobalPredictEmptyLodges($territories,$global_actual,$projection_years),
            'predicted_mean_tax_rehab' => $this->getPredictedMeanTaxRehab($territories,$global_actual,$projection_years ),
            'predicted_mean_tax_construction' => $this->getPredictedMeanTaxConstruction($territories,$global_actual,$projection_years),
            'predicted_migrations' => $global_actual['migrations'],
            'predicted_total_population' => $global_actual['total_population'],
            'predicted_habitants_per_lodge' => $global_actual['habitants_per_lodge'] );
        return $result;
    }

    private function getLocalsPredict($merged,$global_actual,$projection_years)
    {
        $local = array();

        foreach($merged as $territory)
        {

//            if ($territory['id'] == 411)
//            {
//                echo json_encode($territory);
//                echo 'f1'.'  '.$this->formula1($territory,29);
//                echo 'f2'.'  '.$this->formula2($territory,29);
//                echo 'f3'.'  '.$this->formula3($territory,29);
//                echo 'f8'.'  '.$this->formula8($territory,29);
//
//                echo 'f10'.'  '.$this->formula10($territory) ;
//                echo 'f11'.' '.$this->formula11($territory,$merged,$global_actual);
//                echo 'f13'.' '.$this->getPredictedRequiredLodges($territory,$merged,$global_actual,$projection_years);
//                echo'';
//            }

            array_push($local, (array("id" => $territory['id'],"name" => $territory['name'],"predict_tax_period_variance_lodges" => $this->getPredictedPeriodLodgeVariance($territory,$projection_years),
                "predicted_tax_anual_mean_lodges" => $this->getPredictedAnualMeanLodgeVariance($territory,$projection_years),
                "predicted_first_lodges" => $this->getPredictedFirstLodge($territory,$projection_years),
                "predicted_second_lodges" => $this->getPredictedSecondLodge($territory,$projection_years),
                "predicted_total_empty_lodges" => $this->getPredictedTotalEmptyLodges($territory,$projection_years),
                "predicted_empty_avail_lodges" => $this->getPredictedEmptyAvailableLodges($territory,$projection_years),
                "predicted_empty_rehab_lodges" => $this->getPredictedEmptyRehabLodges($territory,$projection_years),
                "predicted_population_variance" => $this->getPredictedPopulationVariance($territory),
                "total_population" => $territory['total_population'],
                "predicted_required_lodges" => $this->getPredictedRequiredLodges($territory,$merged,$global_actual,$projection_years),
                "tax_construction" => $territory['tax_construction'],
                "tax_rehab" => $territory['tax_rehab'],
                "tax_anual_desertion" => $territory['tax_anual_desertion'])));
        }

        return $local;
    }

    private function getPredictedMeanTaxConstruction($territories,$global_actual,$projection_years)
    {
        $result = pow(($this->result3($territories,$projection_years) / ($global_actual['actual_lodges'] + $this->result1($territories,$projection_years) )), 1/$projection_years) -1;
        return $result;
    }

    private function getPredictedMeanTaxRehab($territories,$actual_globals,$projection_years)
    {
        $result = 1 - pow(($this->result6($territories,$projection_years) / ($actual_globals['total_actual_empty_rehab_lodges'])),(1/$projection_years)) ;
        return $result;
    }

    private function getPredictedPeriodLodgeVariance($territory,$projection_years)
    {
        return ($this->formula3($territory,$projection_years) - $territory['actual_lodges'])/$territory['actual_lodges'];

    }

    private function getPredictedAnualMeanLodgeVariance($territory,$projection_years)
    {
        return pow(($this->formula3($territory,$projection_years) / $territory['actual_lodges']), 1.0/$projection_years) - 1;
    }

    private function getPredictedFirstLodge($territory,$projection_years)
    {
        return $this->formula8($territory,$projection_years);

    }

    private function getPredictedSecondLodge($territory,$projection_years)
    {
        return $this->formula9($territory,$projection_years);
    }

    private function getPredictedTotalEmptyLodges($territory,$projection_years)
    {
        return ($this->formula5($territory,$projection_years) + $this->formula6($territory,$projection_years));

    }

    private function getPredictedEmptyAvailableLodges($territory,$projection_years)
    {
        return $this->formula5($territory,$projection_years);

    }

    private function getPredictedEmptyRehabLodges($territory,$projection_years)
    {
        return $this->formula6($territory,$projection_years);
    }

    private function getPredictedPopulationVariance($territory)
    {
        return $territory['total_population'] / $territory['actual_total_population'] - 1;
    }

    private function getPredictedRequiredLodges($territory,$territories,$global_actual,$projection_years)
    {
        return $this->formula13($territory,$territories,$global_actual,$projection_years);

    }


    private function aggGlobal($territories){

        $no_territories =  count($territories);
        $global = $this->getTotal($territories);

        $global['habitants_per_lodge'] = $global['habitants_per_lodge']/$no_territories;

        unset($global['scenario_id'],$global['politic_id'],$global['id'],$global['name']);

        return $global;

    }

    private function getGlobalPredictLodges($territories,$projection_years)
    {
        return $this->result3($territories,$projection_years);
    }

    private function getGlobalPredictEmptyLodges($territories,$globals,$projection_years)
    {
        return $this->result13($territories,$globals,$projection_years);
    }


    // aplicação da taxa de demoliçaõ => numero de edificios que morrem ate projection_years
    private function formula1($territory,$projection_years)
    {

        return $territory['actual_lodges'] * pow(1 + ($territory['tax_anual_desertion']), $projection_years)
            - $territory['actual_lodges'];    // acrescentado por JMM
    }

    private function result1($territories,$projection_years)
    {
        $sum = 0;
        foreach($territories as $territory)
        {
            $sum = $sum + $this->formula1($territory,$projection_years);
        }
        return $sum;
    }

    private function formula2($territory,$projection_years) {
        $input_user =  $territory['tax_construction'] / 100;
        //echo($input_user);
        return ($territory['actual_lodges'] + $this->formula1($territory,$projection_years)) * pow(1 + $input_user, $projection_years)
            - ($territory['actual_lodges'] + $this->formula1($territory,$projection_years));    // acrescentado por JMM
    }

    private function result2($territories,$projection_years) {
        $sum = 0;

        foreach($territories as $territory)
        {
            $sum = $sum + $this->formula2($territory,$projection_years);
        }

        return $sum;

    }

    //alojamentos em 2040
    private function formula3($territory,$projection_years)
    {
        //echo $territory['actual_lodges'];
        return $this->formula1($territory,$projection_years) + $this->formula2($territory,$projection_years) + $territory['actual_lodges'];
    }

    private function result3($territories,$projection_years)
    {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula3($territory,$projection_years);
        }

        return $sum;


    }


    /*private function formula4($territory)
    {
        $input_user = $territory['tax_rehab'] / 100;

        return ($territory['actual_lodges'] * pow(1 + $input_user, 29)) - $territory['actual_lodges'];

    }

    private function result4($territories)
    {
        $sum = 0;

        foreach ($territories as $territory)
            $sum = $sum + $this->formula4($territory);

        return $sum;

    }*/


    private function formula5($territory,$projection_years)
    {
        return $this->formula2($territory,$projection_years) * $territory['tax_actual_empty_lodges'] + $territory['total_actual_empty_avail_lodges'];

    }

    /*private function result5($territories)
    {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula5($territory);
        }

        return $sum;
    }*/

    // Result6 = InputAdmin[i,G] – ( Result2 – InputAdmin[i,G])
    private function formula6($territory,$projection_years)
    {
        $input_user = $territory['tax_rehab'] / 100;
        return $territory['total_actual_empty_rehab_lodges'] -
            ($territory['total_actual_empty_rehab_lodges'] * pow(1 + $input_user, $projection_years) - $territory['total_actual_empty_rehab_lodges']);
    }

    private function result6($territories,$projection_years)
    {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula6($territory,$projection_years);
        }

        return $sum;
    }

    //alojamentos ocupados de 1º residencia no futuro
    private function formula8($territory,$projection_years)
    {
        $input_user = $territory['tax_rehab'] / 100;

        return ($territory['tax_actual_first_lodges'] * $this->formula3($territory,$projection_years)) +
            ( ($territory['total_actual_empty_rehab_lodges'] * pow(1 + $input_user, $projection_years) - $territory['total_actual_empty_rehab_lodges'])
                * $territory['tax_actual_first_lodges']) / ($territory['tax_actual_first_lodges'] + $territory['tax_actual_second_lodges']);
    }

    private function result8($territories,$projection_years)
    {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula8($territory,$projection_years);
        }
        return $sum;
    }


    private function formula9($territory,$projection_years)
    {
        $input_user = $territory['tax_rehab'];
        return ( $territory['tax_actual_second_lodges']* $this->formula3($territory,$projection_years)) +
            (( $territory['total_actual_empty_rehab_lodges'] * pow(1 + $input_user, $projection_years) - $territory['total_actual_empty_rehab_lodges'] ) * $territory['tax_actual_second_lodges']) /
            ($territory['tax_actual_first_lodges'] + $territory['tax_actual_second_lodges']);
    }

    /*private function result9($territories)
    {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula9($territory);
        }
        return $sum;

    }*/


    private function formula10($territory) {
        return $territory['total_population'] / $territory['habitants_per_lodge'];

    }

    private function result10($territories) {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula10($territory);
        }

        return $sum;
    }

    //
    private function formula11($territory,$territories,$global) {

        $nAlojMun = $global['total_population'] / $global['habitants_per_lodge'];
        $nAlojSumFreg = $this->result10($territories);
        $ratio = $nAlojMun / $nAlojSumFreg;

        return $this->formula10($territory) * $ratio;
    }

    private function result11($territories,$global) {
        $sum = 0;

        foreach ($territories as $territory)
        {
            $sum = $sum + $this->formula11($territory,$territories,$global);
        }
        return $sum;
    }

    //alojamentos oucpados necessários
    private function formula13($territory,$territories,$global,$projection_years) {

        return - ($this->formula11($territory,$territories,$global)) + ($this->formula8($territory,$projection_years));
    }

    private function result13($territories,$global,$projection_years) {
        return - $this->result11($territories,$global) + $this->result8($territories,$projection_years);
    }

    /*private function maxDeltaPop($territories)
    {
        $current_territory = array_shift($territories);
        $max = $current_territory['']
        foreach ($territories as $territory)
        {
            if $territory['total_population']
        }
    }*/

    /* function maxDeltaPop() {
        $max = myLocalData[0].populacaoTotal2040 / myLocalData[0].populacaoTotal2011;
        for(c = 1; c < myLocalData.length; c++) {
            if(myLocalData[c].populacaoTotal2040 / myLocalData[c].populacaoTotal2011 > max)
                max = myLocalData[c].populacaoTotal2040 / myLocalData[c].populacaoTotal2011;
        }
        return max - 1;
    }*/

    /*function minDeltaPop() {
        min = myLocalData[0].populacaoTotal2040 / myLocalData[0].populacaoTotal2011;
        for(d = 1; d < myLocalData.length; d++) {
            if(myLocalData[d].populacaoTotal2040 / myLocalData[d].populacaoTotal2011 < min)
                min = myLocalData[d].populacaoTotal2040 / myLocalData[d].populacaoTotal2011;
        }
        return min - 1;
    }*/


    private function maxDeltaAloj($territories) {

        $current_territory = array_shift($territories);

        $aloj2040 = $this->formula3($current_territory,$projection_years);
        $aloj2011 = $current_territory['actual_lodges'];
        $max = $aloj2040 / $aloj2011;


        foreach($territories as $territory)
        {
            $aloj2040 = $this->formula3($territory,$projection_years);
            $aloj2011 = $territory['actual_lodges'];

            $temp = $aloj2040/ $aloj2011;

            if ($temp > $max)
            {
                $max = $temp;
            }
        }
        return $max - 1;
    }

    private function minDeltaAloj($territories) {

        $current_territory = array_shift($territories);

        $aloj2040 = $this->formula3($current_territory);
        $aloj2011 = $current_territory['actual_lodges'];

        $min = $aloj2040 / $aloj2011;

        foreach($territories as $territory)
        {
            $aloj2040 = $this->formula3($territory);
            $aloj2011 = $territory['actual_lodges'];

            $temp = $aloj2040/ $aloj2011;

            if($temp < $min)
            {
                $min = $temp;
            }
        }
        return min - 1;
    }



    private function mergeTaxTerritory($territories,$taxes)
    {
        foreach($territories as &$territory)
        {
            foreach ($taxes as $tax_row)
            {
                if ($tax_row['id'] == $territory['id'])
                {
                    $territory['tax_construction'] =$tax_row['tax_construction'];
                    $territory['tax_rehab'] = $tax_row['tax_rehab'];
                }
            }
        }

        unset ($tax_row,$territory);

        return $territories;
    }

    private function getTotal($array = null)
    {
        $final = array();

        foreach($array as $value)
            $final  = array_merge($final,$value);


        foreach($final as $key => &$value)
            $value = array_sum(array_column($array, $key));

        unset($value);

        return $final;
    }

}