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


    function getStudyRules(study_id) {
        $.ajax(
            {
                type: 'get',
                url: '/studies-rules-territories-domains/getStudyRules.json',
                data: {
                    study: study_id
                },
                success: function (data) {

                    alert(data.message);
                }
            }
        );

    }

</script>



<div class="row-fluid">
	<button id="mod_trigger" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" >
		Launch demo modal
	</button>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
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
            <?= $this->Form->control('Scenarios', array('type' => 'select', 'options' => $scenarios, 'style' => 'height:auto', 'id' => 'sel_scenarios')) ?>
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
    $(document).ready(function() {
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

        $('#mod_trigger').click(function()
        {
           getStudyRules($('#sel_studies').val());
        });

        }
    );

</script>