<?php
?>

<div class="row">
    <h3><?= __('Users') ?></h3>
    <div class="panel panel-default">

        <div class="table-responsive">
            <table class="table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('role')?></th>
                    <th scope="col"><?= $this->Paginator->sort('created')?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $this->Number->format($user->id) ?></td>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->role) ?></td>
                        <td><?= $user->has('created') ? $user->created : 'undefined' ?></td>

                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'adminView', $user->id]) ?>
                            <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>-->
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
                    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} user(s) out of {{count}} total')]) ?></p>
                </div>
            </div>
        </div>
    </div>

</div>