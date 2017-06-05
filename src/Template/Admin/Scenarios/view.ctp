<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <h3><?= h($scenario->name) ?></h3>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($scenario->description)); ?>
    </div>
    <div class="row table-responsive">
        <table class="table vertical-table">
            <tr>
                <th scope="row"><?= __('Domain') ?></th>
                <td><?= $scenario->has('domain') ? $this->Html->link($scenario->domain->name, ['controller' => 'Domains', 'action' => 'view', $scenario->domain->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($scenario->id) ?></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <h4><?= __('Related Territories Domains') ?></h4>
        <?php if (!empty($scenario->territories_domains)): ?>
            <div class="table-responsive">
                <table class="table" >
                    <tr>
                        <th scope="col"><?= __('Territory') ?></th>
                        <th scope="col"><?= __('Actual Population') ?></th>
                        <th scope="col"><?= __('Closed Population') ?></th>
                        <th scope="col"><?= __('Migrations') ?></th>
                        <th scope="col"><?= __('Total Population') ?></th>
                        <th scope="col"><?= __('Inhabitants per Lodge') ?></th>
                        <!--<th scope="col" class="actions"><?= __('Actions') ?></th>-->
                    </tr>
                    <?php foreach ($scenario->territories_domains as $territoriesDomains): ?>
                        <tr>
                            <td><?= h($territoriesDomains->territory->name) ?></td>
                            <td><?= h($territoriesDomains->_joinData->actual_total_population) ?></td>
                            <td><?= h($territoriesDomains->_joinData->closed_population) ?></td>
                            <td><?= h($territoriesDomains->_joinData->migrations) ?></td>
                            <td><?= h($territoriesDomains->_joinData->total_population) ?></td>
                            <td><?= h($territoriesDomains->_joinData->habitants_per_lodge) ?></td>


                            <!--<td><?= h($territoriesDomains->territory_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'TerritoriesDomains', 'action' => 'view', $territoriesDomains->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'TerritoriesDomains', 'action' => 'edit', $territoriesDomains->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'TerritoriesDomains', 'action' => 'delete', $territoriesDomains->id], ['confirm' => __('Are you sure you want to delete # {0}?', $territoriesDomains->id)]) ?>
                </td>-->
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>