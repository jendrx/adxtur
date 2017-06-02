<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="scenarios form large-9 medium-8 columns content">
    <?= $this->Form->create($scenario) ?>
    <fieldset>
        <legend><?= __('Edit Scenario') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('domain_id', ['options' => $domains]);
            echo $this->Form->control('territories_domains._ids', ['options' => $territoriesDomains]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
