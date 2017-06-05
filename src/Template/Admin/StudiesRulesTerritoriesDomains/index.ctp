<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <h3><?= __('Studies Rules Territories Domains') ?></h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('study_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('territory_domain_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('value') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($studiesRulesTerritoriesDomains as $studiesRulesTerritoriesDomain): ?>
                <tr>
                    <td><?= $this->Number->format($studiesRulesTerritoriesDomain->id) ?></td>
                    <td><?= $studiesRulesTerritoriesDomain->has('study') ? $this->Html->link($studiesRulesTerritoriesDomain->study->name, ['controller' => 'Studies', 'action' => 'view', $studiesRulesTerritoriesDomain->study->id]) : '' ?></td>
                    <td><?= $studiesRulesTerritoriesDomain->has('territories_domain') ? $this->Html->link($studiesRulesTerritoriesDomain->territories_domain->id, ['controller' => 'TerritoriesDomains', 'action' => 'view', $studiesRulesTerritoriesDomain->territories_domain->id]) : '' ?></td>
                    <td><?= $studiesRulesTerritoriesDomain->has('rule') ? $this->Html->link($studiesRulesTerritoriesDomain->rule->id, ['controller' => 'Rules', 'action' => 'view', $studiesRulesTerritoriesDomain->rule->id]) : '' ?></td>
                    <td><?= $this->Number->format($studiesRulesTerritoriesDomain->value) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $studiesRulesTerritoriesDomain->id]) ?>
                        <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $studiesRulesTerritoriesDomain->id]) ?>-->
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $studiesRulesTerritoriesDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studiesRulesTerritoriesDomain->id)]) ?>
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
</div>
