<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row-fluid">

	<div class="col-md-9">
		<fieldset>
			<legend><?=__('Add Rules')?></legend>
		<?= $this->Form->create()?>
			<div class="table-responsive">
		<table class="table">
			<thead class="thead-inverse">

				<th>Territories</th>
				<?php foreach ($rules as $rule):?>
					<th><?=$rule->description?></th>

				<?php endforeach;?>
			</thead>
			<tbody>
			<?php foreach ($territories as $territory):?>
			<tr>
				<td><?=$territory->territory->name?></td>
				<?php foreach ($rules as $rule):?>
				<td>
                    <?php echo $this->Form->control($territory->id.'.'.$rule->id, ['type' => 'number','label' => false ,'value' => $rule->default_value, 'min' => 0 , 'step' => 0.1, 'max ' => 1 ]); ?>
				</td>
				<?php endforeach;?>
			</tr>

			<?php endforeach;?>
			</tbody>
		</table>
			</div>
		</fieldset>
        <?= $this->Form->button(__('Submit'),['class' => 'button','style'=>'float:right']) ?>
        <?= $this->Form->end() ?>
	</div>

</div>
