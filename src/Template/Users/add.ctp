<!-- src/Template/Users/add.ctp -->
<div class="container">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->control('username',['type' => 'text']) ?>
        <?= $this->Form->control('password') ?>
	    <?= $this->Form->control('repass',['type' => 'password'])?>
        <!--<?= $this->Form->control('role', [
            'options' => ['admin' => 'Admin', 'user' => 'User','disabled' => 'Inactive']
        ]) ?>-->

    </fieldset>
    <?= $this->Form->button(__('Submit')); ?>
    <?= $this->Form->end() ?>
</div>