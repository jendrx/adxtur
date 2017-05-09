<?php echo $this->Html->script(['map','territorial-table','input-controls','view-data']); ?>
<script>
    var response;

    function newcalc(domain_id,politic_id,scenario_id) {
        var taxes = get_table_data();
        get_territorial_results(domain_id,politic_id,scenario_id,taxes);
    }


    function fill_resume(globals)
    {
        $('#popResidente').val(Math.round(globals.predicted_total_population));
        $('#migrantes').val((globals.predicted_migrations));
        $('#alojExistentes').val(Math.round(globals.predicted_total_lodges));
        $('#alojPorOcupar').val(Math.round(globals.predicted_empty_lodges));
        $('#dimFamilias').val(Math.round(globals.predicted_habitants_per_lodge * 10)/10);
        $('#taxaReabilitacao').val(Math.round(globals.predicted_mean_tax_rehab*10000)/100);
        $('#taxaConstrucao').val(Math.round(globals.predicted_mean_tax_construction * 10000)/100);

    }

    function init(data) {
        response = data.response;
        console.log(response);
        var domain_data = response.domain_data[0];
        var length = domain_data.types.length;

        //fullfill dropdown selectors
        fill_ddown(domain_data.scenarios,'#sel_scenarios');
        fill_ddown(domain_data.types,'#sel_types');
        fill_ddown(domain_data.features,'#sel_features');
        fill_ddown(domain_data.studies,'#sel_politics');

        if(domain_data.studies.length === 0 || domain_data.scenarios.length === 0)
        {
            alert('Insuficient data (Politics data or Scenarios Data)');
            return;
        }

        var  politic_id =$("#sel_politics").val();
        get_politic_taxes(domain_data.id,politic_id);


    }

    function getTerritorialLayer(domain_id,admin_type,types,municipality) {
        $.ajax(
            {
                type: 'get',
                url: '/Maps/getTerritorialLayer.json',
                data: {
                    domain: domain_id,
                    admin_type: admin_type,
                    types: types,
                    municipality: municipality

                },
                success: function (data) {
                    refreshLocalLayer(data.response);

                }
            }
        );
    }

    function get_domain_data(id, callback) {
        $.ajax(
            {
                type: 'get',
                url: '/Homes/getDomainData.json',
                data: {
                    domain: id
                },
                success: function (data) {
                    callback(data);
                }
            }
        );

    }

    function get_politic_taxes(domain_id,politic_id) {
        $.ajax(
            {
                type: 'get',
                url: '/Homes/getPoliticTaxes.json',
                data: {
                    domain: domain_id,
                    politic:politic_id
                },
                success: function(data)
                {

                    load_table_data(data.response);
                }
            }
        );
    }

    function get_territorial_results(domain_id,politic_id,scenario_id,taxes) {
        $.ajax(
            {
                type: 'get',
                url: '/Calcs/getResults.json',
                data: {
                    domain: domain_id,
                    politic:politic_id,
                    scenario:scenario_id,
                    taxes: taxes
                },
                success: function(data)
                {

                    locals=data.response.locals;

                    getTerritorialLayer(domain_id,1,1,"");
                    fill_resume(data.response.global_predict);

                }
            }
        );
    }

</script>
<div class="row-fluid">
    <div class="col-md-2">
        <h4> Ano de referência 2040</h4>
        <div class="row" >
            <div class="col-md-10">
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="popResidente"> População Residente</label>
                        </div>
                        <div class="col-md-10">
                            <input class="text-right" type="text" value="" id="popResidente" disabled>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <label for="migrantes"> Migrantes </label>
                        </div>
                        <div class="col-md-10">
                            <input class=" text-right" id="migrantes" type="text" value="" disabled/>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            <label for="alojExistentes"> Alojamentos existentes </label>
                        </div>
                        <div class="col-md-10">
                            <input class="outputValue text-right" id="alojExistentes" type="text" value="" disabled/>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-10">
                            <label for="alojPorOcupar"> Alojamentos por ocupar </label>
                        </div>
                        <div class="col-md-10">
                            <input class="outputValue text-right" id="alojPorOcupar" type="text" value="" disabled/>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-11">
                            <label for="dimFamilias"> Dimensão média das famílias </label>
                        </div>
                        <div class="col-md-10">
                            <input class="outputValue text-right" id="dimFamilias" type="text" value="" disabled/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <h4> Política de intervenção</h4>
            <div class="col-md-10 col-md-offset-0">
                <p><label><b>Parque habitacional</b></label></p>
                <form>
                    <div class="row">
                        <div class="col-md-10">
                            <label for="taxaReabilitacao"> Taxa de reabilitação </label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input class="form-control text-right" id="taxaReabilitacao" type="text" value="0.0" disabled/>
                                <span class="input-group-addon " style="border:none;font-size: 11px;" >
									<i class="fa fa-percent fa-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <label  class= "disable" for="taxaConstrucao"> Taxa de construção </label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group" ">
                            <input class=" form-control text-right" id="taxaConstrucao" type="text" value="0.0" disabled/>
                            <span class="input-group-addon " style="border:none;font-size: 11px;" >
							<i class="fa fa-percent fa-lg"></i>
								</span>
                        </div>
                    </div>
            </div>
            <br>
            </form>
        </div>
    </div>


</div>

<div class="col-md-3">

	<div class="table-responsive">
    <table class="table" id="table_territorials">
        <col width="34%">
        <col width="11%">
        <col width="11%">
    </table>

    <br>
    <p align="center">
        <input id="calc_politic_tax" class="button" type="button" value="Calcular">
    </p>
	</div>
</div>

<div class="col-md-7">

    <div id="map" style="position=initial; height: 600px;"></div>


    <div id='distance' class="pill" style=" position:fixed; right:0%;top:15%; padding-right: 2%; padding-top:1%;">
        <div class="pill">
            <input id="view1" class="col12 button" style="width:130px" type="submit" value="Parque habitacional"
                   onclick="view1()">
            <input id="view2" class="col12 button" style="width:130px" type="submit" value="População"
                   onclick="view2()">
            <input id="view3" class="col12 button" style="width:130px" type="submit" value="Necessidades"
                   onclick="view3()">
        </div>
    </div>
    <!--  show legend-->


    <label for="sel_scenarios"> Scenarios </label>

    <select id="sel_scenarios" type="button" class="btn btn-default" aria-haspopup="true" aria-expanded="false">Action
        <span class="caret"></span>
    </select>

    <label for="sel_politics"> Politics </label>
    <select id="sel_politics" type="button" class="btn btn-default" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
    </select>
    <label for="sel_types"> Types </label>
    <select id="sel_types" type="button" class="btn btn-default" aria-haspopup="true" aria-expanded="false"> <span
            class="caret"></span>
    </select>

    <label for="sel_features"> Features </label>
    <select id="sel_features" type="button" class="btn btn-default" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
    </select>

</div>

</div>

<script>

    $(document).ready(function()
        {
            var domain_id = '<?php echo $domain_id; ?>';

            createMap();

            get_domain_data(domain_id ,init);

            $("#calc_politic_tax").click(function(){

                var scenario_id = $("#sel_scenarios").val();
                var  politic_id =$("#sel_politics").val();

                newcalc(domain_id,politic_id,scenario_id);

            });

            $("#sel_politics").click(function()
            {
                var scenario_id = $("#sel_scenarios").val();
            });

            $("#sel_scenarios").change(function () {
                var  politic_id =$("#sel_politics").val();
                newcalc(domain_id ,politic_id,this.value)
            });


        }
    );


</script>