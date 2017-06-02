<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Users Domain'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usersDomains index large-9 medium-8 columns content">
    <h3><?= __('Users Domains') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('domain_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersDomains as $usersDomain): ?>
            <tr>
                <td><?= $this->Number->format($usersDomain->id) ?></td>
                <td><?= $usersDomain->has('user') ? $this->Html->link($usersDomain->user->id, ['controller' => 'Users', 'action' => 'view', $usersDomain->user->id]) : '' ?></td>
                <td><?= $usersDomain->has('domain') ? $this->Html->link($usersDomain->domain->name, ['controller' => 'Domains', 'action' => 'view', $usersDomain->domain->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $usersDomain->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usersDomain->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usersDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersDomain->id)]) ?>
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
