<?php echo $this->Html->script(['map','territorial-table','view-data','home-view']); ?>


<script>
    function update_taxes(study_id,table_data) {
        $.ajax(
            {
                type: 'post',
                url: '/studies-rules-territories-domains/updateTaxes.json',
                data: {
                    study: study_id,
                    table_data: table_data
                },
                success: function (data) {
                    alert(data.message);
                }
            }
        );

    }

</script>

<div class="row-fluid">
	<div class="col-md-2">
		<h4> Ano de referência 2040</h4>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-10">
						<label for="popResidente"> População Residente</label>
					</div>
					<div class="col-md-10">
						<input class="text-right" type="text" value="" id="popResidente" disabled>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10">
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
			</div>
		</div>
		<h4> Política de intervenção</h4>
		<div class="row">
			<div class="col-md-12 col-md-offset-0">
				<p><label><b>Parque habitacional</b></label></p>
				<div class="row">
					<div class="col-md-10">
						<label for="taxaReabilitacao"> Taxa de reabilitação </label>
					</div>
					<div class="col-md-10">
						<div class="input-group">
							<input class="form-control text-right" id="taxaReabilitacao" type="text" value="0.0"
							       disabled/>
							<span class="input-group-addon " style="border:none;font-size: 11px;">
									<i class="fa fa-percent fa-lg"></i></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10">
						<label class="disable" for="taxaConstrucao"> Taxa de construção </label>
					</div>
					<div class="col-md-10">
						<div class="input-group"
						">
						<input class=" form-control text-right" id="taxaConstrucao" type="text" value="0.0"
						       disabled/>
						<span class="input-group-addon " style="border:none;font-size: 11px;">
							<i class="fa fa-percent fa-lg"></i>
								</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="col-md-3">
	<div class="table-responsive">
		<table class="table" id="table_territorials">
			<col width="60%">
			<col width="6%">
			<col width="6%">
			<col width="10%">
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

	<div class="row">
		<div class="col-md-3">
            <?= $this->Form->control('Scenarios', array('type' => 'select', 'options' => $scenarios, 'style' => 'height:auto', 'id' => 'sel_scenarios')) ?>
		</div>
		<div class="col-md-3">
            <?= $this->Form->control('Studies', array('type' => 'select', 'options' => $studies, 'style' => 'height:auto', 'id' => 'sel_studies')) ?>
		</div>
		<div class="col-md-3">
			<br>
			<input type="button" id="save_taxes" value="Save Taxes" \>
		</div>

		<div class="col-md-3">
			<br>
			<input type="button" id="export_btn" value="Export" \>
		</div>

	</div>

</div>

</div>

<script>
    $(document).ready(function()
        {
            var domain_data = <?php echo json_encode($current_domain);?>;
            var territories = <?php echo json_encode($territories);?>;
            var start_view = <?php echo ($start_view);?>;

            init(domain_data);
            createMap([start_view.lat,start_view.lon]);

            $("#calc_politic_tax").click(function(){

                var  scenario_id = $("#sel_scenarios").val();
                var  study_id =$("#sel_studies").val();
                var taxes = get_table_data();
                //domain_id,politic_id,scenario_id,taxes,levels,parent_id
	            newcalc(domain_data.id,study_id,scenario_id,taxes,domain_data.types.length,null);

            });

            $("#sel_studies").change(function() {
                var scenario_id = $("#sel_scenarios").val();
                var study_id = $(this).val();
                remove_table_rows('table_territorials');
                var taxes = get_politic_taxes(study_id,domain_data.types.length,null);


                
            });



            $("#sel_scenarios").change(function () {
                var  study_id =$("#sel_studies").val();
                var scenario_id = $(this).val();
            });


            $('#save_taxes').click(function()
            {
                update_taxes($('#sel_studies').val(),get_table_data());
            });



        }
    );

</script>