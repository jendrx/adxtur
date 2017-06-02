<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
	<div class="col-md-12">
        <?= $this->Form->create($usersDomain) ?>
		<fieldset>

			<legend><?= __('Add Related Domain') ?></legend>
			<div class="panel">
				<div class="row">
					<div class="col-md-6">
						<label> User</label>
						<input readonly="true" type="text" value="<?= $user['username'] ?>" </input>
						<?php
                        echo $this->Form->control('domain_id', ['options' => $domains, 'style' => ['height : auto']]);
                        ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-1 col-md-offset-10">
                        <?= $this->Form->button(__('Submit'), array('class' => 'button')) ?>
                        <?= $this->Form->end() ?>
					</div>
				</div>
			</div>
		</fieldset>
		<br>

	</div>

</div>
