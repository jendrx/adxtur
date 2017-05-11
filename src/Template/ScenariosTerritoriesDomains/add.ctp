<?php
/**
  * @var \App\View\AppView $this
  */
?>


<div class="row-fluid">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<thead class="thead-inverse">
						<th>Territory</th>
						<th>Closed Population</th>
						<th>Migrations</th>
						<th>Total Population</th>
						<th>Inhabitants per lodge</th>
						<th>Actual Population</th>
						</thead>


						<legend class="text-center"><?= __('Add Scenarios Territorials Domain') ?></legend>

                        <?= $this->Form->create('',['url' => ['action' => 'add']]) ?>

                        <?php foreach ($territories as $territory): ?>
							<tr>
								<td><label><?= $territory->territory->name ?></label></td>
								<!--<?php echo $this->Form->control($territory->id . '.territorial_domain_id', ['type' => 'hidden', 'value' => $territory->id]);
                                echo $this->Form->control($territory->id . '.scenario_id', ['type' => 'hidden', 'value' => $scenario_id]); ?>-->
								<td><?php echo $this->Form->control($territory->id . '.closed_population', ['type' => 'number', 'label' => false, 'value' => 0, 'min' => 1]); ?></td>
								<td><?php echo $this->Form->control($territory->id . '.migrations', ['type' => 'number', 'label' => false, 'value' => 0, 'min' => 0]); ?></td>
								<td><?php echo $this->Form->control($territory->id . '.total_population', ['type' => 'number', 'label' => false, 'value' => 0, 'min' => 1]); ?></td>
								<td><?php echo $this->Form->control($territory->id . '.habitants_per_lodge', ['type' => 'number', 'label' => false, 'value' => 0, 'min' => 0.1, 'step' => 0.1]); ?></td>
								<td><?php echo $this->Form->control($territory->id . '.actual_total_population', ['type' => 'number', 'label' => false, 'value' => 0, 'min' => 1]); ?></td>

							</tr>
                        <?php endforeach; ?>
					</table>

				</div>
                <?= $this->Form->button(__('Submit'), ['class' => 'button', 'style' => 'float:right']) ?>
                <?= $this->Form->end() ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<legend class="text-center"><?= __('OR') ?></legend>
			</div>
		</div>


	<div class="row">
		<div class="col-md-12">
            <?= $this->Form->create('', ['url' => ['action'=>'addUploaded',$scenario_id], 'encType' => 'multipart/form-data']) ?>
            <?= $this->Form->control('file', ['type' => 'file', 'label' => false]) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'button', 'style' => 'float:right']) ?>
            <?= $this->Form->end() ?>
		</div>

	</div>
	</div>

</div>


