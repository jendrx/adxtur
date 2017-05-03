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
                ['action' => 'delete', $study->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $study->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Studies Rules Territories Domains'), ['controller' => 'StudiesRulesTerritoriesDomains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Studies Rules Territories Domain'), ['controller' => 'StudiesRulesTerritoriesDomains', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Territories Domains'), ['controller' => 'TerritoriesDomains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Territories Domain'), ['controller' => 'TerritoriesDomains', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="studies form large-9 medium-8 columns content">
    <?= $this->Form->create($study) ?>
    <fieldset>
        <legend><?= __('Edit Study') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('domain_id', ['options' => $domains, 'empty' => true]);
            echo $this->Form->control('actual_year');
            echo $this->Form->control('projection_years');
            echo $this->Form->control('territories_domains._ids', ['options' => $territoriesDomains]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
