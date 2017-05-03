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
                ['action' => 'delete', $scenariosTerritoriesDomain->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $scenariosTerritoriesDomain->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Scenarios Territories Domains'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Territories Domains'), ['controller' => 'TerritoriesDomains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Territories Domain'), ['controller' => 'TerritoriesDomains', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="scenariosTerritoriesDomains form large-9 medium-8 columns content">
    <?= $this->Form->create($scenariosTerritoriesDomain) ?>
    <fieldset>
        <legend><?= __('Edit Scenarios Territories Domain') ?></legend>
        <?php
            echo $this->Form->control('closed_population');
            echo $this->Form->control('migrations');
            echo $this->Form->control('total_population');
            echo $this->Form->control('habitants_per_lodge');
            echo $this->Form->control('territory_domain_id', ['options' => $territoriesDomains, 'empty' => true]);
            echo $this->Form->control('scenario_id', ['options' => $scenarios, 'empty' => true]);
            echo $this->Form->control('actual_total_population');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
