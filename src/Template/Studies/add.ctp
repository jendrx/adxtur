<?php
/**
  * @var \App\View\AppView $this
  */
?>
<!--<div class="row">
    <?= $this->Form->create($study) ?>
    <fieldset>
        <legend><?= __('Add Study') ?></legend>
        <?php
            echo $this->Form->control('name', ['type' => 'text']);
            echo $this->Form->control('actual_year',['type' => 'number', 'value' => '2011']);
            echo $this->Form->control('projection_years',['type' => 'number', 'value' => '29']);

        echo $this->Form->control('description');
            //echo $this->Form->control('domain_id', ['options' => $domains, 'empty' => true]);
            //echo $this->Form->control('territories_domains._ids', ['options' => $territoriesDomains]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->


<div class="row">
    <?= $this->Form->create($study) ?>
	<legend><?= __('Add Study') ?></legend>
	<div class="well">
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
