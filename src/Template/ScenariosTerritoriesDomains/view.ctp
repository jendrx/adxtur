<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Scenarios Territories Domain'), ['action' => 'edit', $scenariosTerritoriesDomain->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Scenarios Territories Domain'), ['action' => 'delete', $scenariosTerritoriesDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenariosTerritoriesDomain->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios Territories Domains'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenarios Territories Domain'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Territories Domains'), ['controller' => 'TerritoriesDomains', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Territories Domain'), ['controller' => 'TerritoriesDomains', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="scenariosTerritoriesDomains view large-9 medium-8 columns content">
    <h3><?= h($scenariosTerritoriesDomain->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Territories Domain') ?></th>
            <td><?= $scenariosTerritoriesDomain->has('territories_domain') ? $this->Html->link($scenariosTerritoriesDomain->territories_domain->id, ['controller' => 'TerritoriesDomains', 'action' => 'view', $scenariosTerritoriesDomain->territories_domain->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Scenario') ?></th>
            <td><?= $scenariosTerritoriesDomain->has('scenario') ? $this->Html->link($scenariosTerritoriesDomain->scenario->name, ['controller' => 'Scenarios', 'action' => 'view', $scenariosTerritoriesDomain->scenario->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($scenariosTerritoriesDomain->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Closed Population') ?></th>
            <td><?= $this->Number->format($scenariosTerritoriesDomain->closed_population) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Migrations') ?></th>
            <td><?= $this->Number->format($scenariosTerritoriesDomain->migrations) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Population') ?></th>
            <td><?= $this->Number->format($scenariosTerritoriesDomain->total_population) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Habitants Per Lodge') ?></th>
            <td><?= $this->Number->format($scenariosTerritoriesDomain->habitants_per_lodge) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Actual Total Population') ?></th>
            <td><?= $this->Number->format($scenariosTerritoriesDomain->actual_total_population) ?></td>
        </tr>
    </table>
</div>
