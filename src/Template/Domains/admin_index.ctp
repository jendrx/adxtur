<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <h3><?= __('Domains') ?></h3>
    <div class="panel panel-default">


        <div class="table-responsive">
            <table class="table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('actual_year') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('projection_year') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($domains as $domain): ?>
                    <tr>
                        <td><?= $this->Number->format($domain->id) ?></td>
                        <td><?= h($domain->name) ?></td>
                        <td><?= $this->Number->format($domain->actual_year) ?></td>
                        <td><?= $this->Number->format($domain->projection_year) ?></td>
                        <td><?= $domain->has('created') ? $domain->created->i18nFormat('dd-MM-yyyy, HH:MM') : 'undefined' ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'admin_view', $domain->id]) ?>
                            <!--<?= $this->Html->link(__('Edit'), ['action' => 'admin_edit', $domain->id]) ?>-->
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'admin_delete', $domain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domain->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="">
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} domain(s) out of {{count}} total')]) ?></p>
                </div>
            </div>
        </div>
    </div>

</div