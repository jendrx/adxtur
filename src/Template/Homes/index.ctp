<!--<div class="row">

    <div class="col-md-10 col-md-offset-1" style="background: gainsboro">-->


<div class="container">
	<legend class="text-left">My Domains</legend>
    <?php foreach ($domains as $domain): ?>
		<div class="row-fluid">
			<div class="col-md-10 col-md-offset-2">
				<div class="row well ">
					<div class="row">
					<div class="col-md-2">
						<h4> <?= $domain->name ?></h4>
					</div>
					<div class="col-md-4 col-md-offset-6">
						<h5><?=$domain->created->i18nFormat('dd-MM-yyyy HH:MM')?></h5>
					</div>
					</div>
					<div class="row">
					<div id="domain_content" class="col-md-12">
						<dl class="">
							<dt>Description</dt>
							<dd><?= $domain->description ?>
							</dd>
						</dl>
					</div>
					</div>
					<div class="row">
						<div class="col-md-3 " style="float: right;">
                            <?php echo $this->Html->link('Show', ['action' => 'view', $domain->id], array('class' => 'button')) ?>
						</div>
					</div>
				</div>
			</div>
		</div>


    <?php endforeach; ?>

	<div id="upload_div">
		<?= $this->Form->create('',['id' => 'scenario_add_form', 'encType' => 'multipart/form-data'])?>
        <?=$this->Form->control('file',['type' => 'file'])?>
        <?= $this->Form->button(__('Submit'), ['class' => 'button','style'=>'float:right']) ?>
        <?= $this->Form->end() ?>
	</div>
</div>



