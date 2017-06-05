<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="domains form large-9 medium-8 columns content">
    <?= $this->Form->create($domain) ?>
    <fieldset>
        <legend><?= __('Edit Domain') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('description');
        echo $this->Form->control('actual_year');
        echo $this->Form->control('projection_year');
        echo $this->Form->control('features._ids', ['options' => $features]);
        echo $this->Form->control('territories._ids', ['options' => $territories]);
        echo $this->Form->control('types._ids', ['options' => $types]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
