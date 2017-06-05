<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="studiesRulesTerritoriesDomains form large-9 medium-8 columns content">
    <?= $this->Form->create($studiesRulesTerritoriesDomain) ?>
    <fieldset>
        <legend><?= __('Edit Studies Rules Territories Domain') ?></legend>
        <?php
            echo $this->Form->control('study_id', ['options' => $studies, 'empty' => true]);
            echo $this->Form->control('territory_domain_id', ['options' => $territoriesDomains, 'empty' => true]);
            echo $this->Form->control('rule_id', ['options' => $rules, 'empty' => true]);
            echo $this->Form->control('value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
