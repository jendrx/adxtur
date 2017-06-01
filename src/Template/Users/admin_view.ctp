<?php
?>


<div class="row">
<div class="col-md-12">

    <div class="row">
        <div class="col-md-12">
            <h3><?= h($user->username) ?></h3>
            <div class="panel panel-default">
                <div class="table-responsive">
                    <table class=" table ">
                        <tr>
                            <th scope="row"><?= __('Id') ?></th>
                            <td><?= h($user->id) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Role') ?></th>
                            <td><?= h($user->role) ?></td>
                            <td><?= $this->Html->link(__('Edit'),['action' => 'admin_edit', $user->id])?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Created At') ?></th>
                            <td><?= $user->has('created') ? h($user->created) : 'undefined' ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Updated At') ?></th>
                            <td><?= $user->has('modified') ? h($user->modified) : 'undefined' ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="">
                    <h4>Related Domains</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($user['domains'])): ?>
                    <div class = "table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?= __('Name') ?></th>
                                <th scope="col"><?= __('created At')?> </th>
                                <th scope="col" class="actions"><?= __('Action') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($user['domains'] as $domain): ?>
                                <tr>
                                    <td><?= h($domain->name) ?> </td>
                                    <td><?= h($domain->created) ?> </td>
                                    <td><?= $this->Form->postLink(__('Delete'), ['controller' => 'users_domains', 'action' => 'admin_delete', $domain['_joinData']->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domain['_joinData']->id)]) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php  endif;?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php  echo json_encode($user)?>
</div>
</div>
