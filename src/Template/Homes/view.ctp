<?php echo $this->Html->script(['map','territorial-table','view-data','home-view']); ?>

<div class="row-fluid">

	<div id="test_div">
	</div>
	<div class="col-md-2">
		<h4> Ano de referência 2040</h4>
		<?=$this->element('resumeResults')?>
		<h4> Política de intervenção</h4>
		<?=$this->element('resumePolitics')?>
	</div>
</div>
<div class="col-md-3">
	<div class="table-responsive">
		<table class="table" id="table_territorials">
		</table>
		<br>
		<p align="center">
			<input id="calc_politic_tax" class="button" type="button" value="Calcular">
		</p>
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
			<input type="button" id="save_taxes" value="Save Taxes" />
		</div>

		<div class="col-md-3">
			<br>
			<input type="button" id="mod_rules" value="Modify Rules" />
		</div>

		<div class="col-md-3">
			<br>
			<input type="button" id="export_btn" value="Export" />
		</div>


	</div>

</div>

<script>
    $(document).ready(function () {
            var domain_data = <?php echo json_encode($current_domain);?>;
            var territories = <?php echo json_encode($territories);?>;
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
                getScenarios(study_id);
                removeTableRows('table_territorials');
                getStudyTaxes(null, study_id, scenario_id, 1, null, load_table_data);


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
                var study_id = $(this).val();

                exportCsv();
            });

        }
    );

</script>