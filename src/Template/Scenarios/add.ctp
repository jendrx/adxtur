<?php
/**
  * @var \App\View\AppView $this
  */
?>
	<div class="row">
        <?= $this->Form->create($scenario) ?>
		<legend><?= __('Add Scenario') ?></legend>
		<div class="well">
			<div class="row">
				<div class="col-md-3">
                    <?php
                    echo $this->Form->control('name',['type' => 'text']); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
                    <?=$this->Form->control('actual_year',['type' => 'number', 'value' => '2011'])?>
				</div>
				<div class="col-md-3">
                    <?=$this->Form->control('projection_years',['type' => 'number', 'value' => '29'])?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
                    <?php echo $this->Form->control('description');?>
				</div>
				<div class="col-md-3">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<br>
                    <?= $this->Form->button(__('Submit'),['class' => 'button']) ?>
				</div>
			</div>
            <?= $this->Form->end() ?>
		</div>
	</div>
