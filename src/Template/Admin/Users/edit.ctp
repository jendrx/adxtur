<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 12:18 PM
 */?>

<div class="container">
    <div class="row">
        <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Edit User') ?></legend>
            <?= $this->Form->control('username',['type' => 'text', 'readonly' => true]) ?>
            <?= $this->Form->control('role', ['options' => ['admin' => 'Admin', 'user' => 'User','disabled' => 'Inactive'],'style' => 'height:auto']) ?>
        </fieldset>
        <br>
        <?= $this->Form->button(__('Submit'),['class'=>'button']); ?>
        <?= $this->Form->end() ?>

    </div>
</div>
