<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 11:03 AM
 */?>
<div class="scenariosTerritoriesDomains index large-9 medium-8 columns content">
    <h3><?= __('Scenarios Territories Domains') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('closed_population') ?></th>
            <th scope="col"><?= $this->Paginator->sort('migrations') ?></th>
            <th scope="col"><?= $this->Paginator->sort('total_population') ?></th>
            <th scope="col"><?= $this->Paginator->sort('habitants_per_lodge') ?></th>
            <th scope="col"><?= $this->Paginator->sort('territory_domain_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('scenario_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('actual_total_population') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($scenariosTerritoriesDomains as $scenariosTerritoriesDomain): ?>
            <tr>
                <td><?= $this->Number->format($scenariosTerritoriesDomain->id) ?></td>
                <td><?= $this->Number->format($scenariosTerritoriesDomain->closed_population) ?></td>
                <td><?= $this->Number->format($scenariosTerritoriesDomain->migrations) ?></td>
                <td><?= $this->Number->format($scenariosTerritoriesDomain->total_population) ?></td>
                <td><?= $this->Number->format($scenariosTerritoriesDomain->habitants_per_lodge) ?></td>
                <td><?= $scenariosTerritoriesDomain->has('territories_domain') ? $this->Html->link($scenariosTerritoriesDomain->territories_domain->id, ['controller' => 'TerritoriesDomains', 'action' => 'view', $scenariosTerritoriesDomain->territories_domain->id]) : '' ?></td>
                <td><?= $scenariosTerritoriesDomain->has('scenario') ? $this->Html->link($scenariosTerritoriesDomain->scenario->name, ['controller' => 'Scenarios', 'action' => 'view', $scenariosTerritoriesDomain->scenario->id]) : '' ?></td>
                <td><?= $this->Number->format($scenariosTerritoriesDomain->actual_total_population) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $scenariosTerritoriesDomain->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $scenariosTerritoriesDomain->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $scenariosTerritoriesDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenariosTerritoriesDomain->id)]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

