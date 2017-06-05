<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 11:55 AM
 */?>

<div class="row">
    <h3><?= h($studiesRulesTerritoriesDomain->id) ?></h3>
    <div>
        <table class="table vertical-table">
            <tr>
                <th scope="row"><?= __('Study') ?></th>
                <td><?= $studiesRulesTerritoriesDomain->has('study') ? $this->Html->link($studiesRulesTerritoriesDomain->study->name, ['controller' => 'Studies', 'action' => 'view', $studiesRulesTerritoriesDomain->study->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Territories Domain') ?></th>
                <td><?= $studiesRulesTerritoriesDomain->has('territories_domain') ? $this->Html->link($studiesRulesTerritoriesDomain->territories_domain->id, ['controller' => 'TerritoriesDomains', 'action' => 'view', $studiesRulesTerritoriesDomain->territories_domain->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Rule') ?></th>
                <td><?= $studiesRulesTerritoriesDomain->has('rule') ? $this->Html->link($studiesRulesTerritoriesDomain->rule->id, ['controller' => 'Rules', 'action' => 'view', $studiesRulesTerritoriesDomain->rule->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($studiesRulesTerritoriesDomain->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= $this->Number->format($studiesRulesTerritoriesDomain->value) ?></td>
            </tr>
        </table>
    </div>
</div>

