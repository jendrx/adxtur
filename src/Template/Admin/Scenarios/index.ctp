<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <h3><?= __('Scenarios') ?></h3>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class='table'>
                <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('domain_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?> </th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?> </th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($scenarios as $scenario): ?>
                    <tr>
                        <td><?= $this->Number->format($scenario->id) ?></td>
                        <td><?= $scenario->has('domain') ? $this->Html->link($scenario->domain->name, ['controller' => 'Domains', 'action' => 'view', $scenario->domain->id]) : '' ?></td>
                        <td><?= $scenario->name ?></td>
                        <td><?= $scenario->has('created') ? $scenario->created->i18nFormat('dd-MM-yyyy, HH:MM') : 'undefined' ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $scenario->id]) ?>
                            <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $scenario->id]) ?>-->
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $scenario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenario->id)]) ?>
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
</div>
