<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $studiesRulesTerritoriesDomain->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $studiesRulesTerritoriesDomain->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Studies Rules Territories Domains'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Territories Domains'), ['controller' => 'TerritoriesDomains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Territories Domain'), ['controller' => 'TerritoriesDomains', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rules'), ['controller' => 'Rules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rule'), ['controller' => 'Rules', 'action' => 'add']) ?></li>
    </ul>
</nav>
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
