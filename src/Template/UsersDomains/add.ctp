<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="usersDomains form large-9 medium-8 columns content">
    <?= $this->Form->create($usersDomain) ?>
    <fieldset>
        <legend><?= __('Add Users Domain') ?></legend>
        <?php
            echo $this->Form->control('Username', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('Domains', ['options' => $domains, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),array('class' => 'button')) ?>
    <?= $this->Form->end() ?>
</div>
