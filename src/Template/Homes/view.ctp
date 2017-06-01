<?php echo $this->Html->script(['map','territorial-table','view-data','home-view']); ?>

<div class="row-fluid">
	<div class="col-md-2">
		<h4> Ano de referência 2040</h4>
		<?=$this->element('resumeResults')?>
		<h4> Política de intervenção</h4>
		<?=$this->element('resumePolitics')?>
	</div>
</div>
<div class="col-md-3">
	<div class="row">
		<div class="">
		<div class="table-responsive"  style="height: 700px;" >
			<table class="table" id="table_territorials">
			</table>
		</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-4">
				<input id="calc_politic_tax" class="button btn-block" type="button" value="Calcular">
			</div>
			<div class="col-md-4">
				<input type="button" class="button btn-block" id="save_taxes" value="Save" />
			</div>
			<div class="col-md-4">
				<input id="export_btn" class="button btn-block" type="button" value="Export"/>
			</div>
		</div>
	</div>
</div>

<div class="col-md-7">
	<div class="row-fluid">
        <?=$this->element('map')?>
	</div>
	<div class="row">
		<div class="col-md-3">
            <?= $this->Form->control('Scenarios', array('type' => 'select', 'options' => [], 'style' => 'height:auto', 'id' => 'sel_scenarios')) ?>
		</div>
		<div class="col-md-3">
            <?= $this->Form->control('Studies', array('type' => 'select', 'options' => $studies, 'style' => 'height:auto', 'id' => 'sel_studies')) ?>
		</div>
		<div class="col-md-3">
			<br>
			<?= $this->Html->link(__('New Study'), ['controller'=> 'studies', 'action' => 'add', $current_domain['id']])?>
		</div>

	</div>

</div>

<script>
    $(document).ready(function () {

            var domain_data = <?php echo json_encode($current_domain);?>;
            //var territories = <?php echo json_encode($territories);?>;
            var start_view = <?php echo($start_view);?>;

            init(domain_data);
            createMap([start_view.lat, start_view.lon]);

            $("#calc_politic_tax").click(function () {
                var scenario_id = $("#sel_scenarios").val();
                var study_id = $("#sel_studies").val();
                var taxes = get_table_data();
                getTerritorialResults(domain_data.id, study_id, scenario_id, taxes, domain_data.types.length, null,
	                showResults);

            });

            $("#sel_studies").change(function () {
                var scenario_id = $("#sel_scenarios").val();
                var study_id = $(this).val();
                getScenarios(study_id,refreshScenarioDropDown);
                removeTableRows('table_territorials');
                getStudyTaxes(null, study_id, scenario_id, domain_data.types.length, null, load_table_data);


            });

            $("#sel_scenarios").change(function () {
                var study_id = $("#sel_studies").val();
                var scenario_id = $(this).val();
            });

            $('#save_taxes').click(function () {
                updateTaxes($('#sel_studies').val(), get_table_data());
            });

            $('#export_btn').click(function () {
                var scenario_id = $("#sel_scenarios").val();
                var study_id = $('#sel_studies').val();

                getStudyTaxes(domain_data.id, study_id, scenario_id, domain_data.types.length, null, function(data)
                {
                    getTerritorialResults(domain_data.id, study_id, scenario_id, data, domain_data.types.length, null,
	                    function(domain_id,study_id,scenario_id,levels,parent_id,data) {
                        exportCsv(study_id,scenario_id,data.response);
                    });

                });

            });

        }
    );

</script>