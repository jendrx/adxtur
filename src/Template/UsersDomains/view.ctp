<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Users Domain'), ['action' => 'edit', $usersDomain->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Users Domain'), ['action' => 'delete', $usersDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersDomain->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users Domains'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Users Domain'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usersDomains view large-9 medium-8 columns content">
    <h3><?= h($usersDomain->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $usersDomain->has('user') ? $this->Html->link($usersDomain->user->id, ['controller' => 'Users', 'action' => 'view', $usersDomain->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Domain') ?></th>
            <td><?= $usersDomain->has('domain') ? $this->Html->link($usersDomain->domain->name, ['controller' => 'Domains', 'action' => 'view', $usersDomain->domain->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($usersDomain->id) ?></td>
        </tr>
    </table>
</div>
