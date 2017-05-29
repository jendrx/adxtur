<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="row-fluid">
    <?= $this->Form->create('Studies') ?>
	<legend><?= __('Add Study') ?></legend>
	<div class="col-md-7 well">
		<div class="row">
			<div class="col-md-3">
                <?php
                echo $this->Form->control('name', ['type' => 'text']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<?=$this->Form->control('actual_year',['type' => 'number', 'value' => '2011', 'readonly' => true])?>
			</div>
			<div class="col-md-3">

				<?=$this->Form->control('projection_years',['type' => 'select', 'value' => '29','options' => $proj_years, 'style' => 'height:auto'])?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
                <?php echo $this->Form->control('description');?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 ">
				<br>
               <?= $this->Form->button(__('Submit'),['class' => 'button','style'=>'float:right']) ?>
			</div>
		</div>
        <?= $this->Form->end() ?>
	</div>

</div>
