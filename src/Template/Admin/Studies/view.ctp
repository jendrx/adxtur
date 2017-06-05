<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 6/5/17
 * Time: 11:22 AM
 */?>

<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <h3><?= h($study->name) ?></h3>

    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($study->description)); ?>
    </div>

    <div class=" row table-responsive">
        <table class="table">
            <tr>
                <th scope="row"><?= __('Domain') ?></th>
                <td><?= $study->has('domain') ? $this->Html->link($study->domain->name, ['controller' => 'Domains', 'action' => 'view', $study->domain->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($study->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Actual Year') ?></th>
                <td><?= h($study->actual_year) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Projection Years') ?></th>
                <td><?= $this->Number->format($study->projection_years) ?></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <h4><?= __('Related Studies Rules') ?></h4>
        <?php if (!empty($studiesRules)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"><?=__('Territory')?></th>
                        <?php foreach ($rules as $rule): ?>
                            <th scope="col"><?= $rule->description ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($studiesRules as $key => $value): ?>
                        <tr>
                            <td><?= $key ?></td>
                            <?php foreach ($value as $val): ?>
                                <td> <?=$this->Number->format($val->value, array('places' => 3))  ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <h4><?= __('Related Studies Rules Territories Domains') ?></h4>
        <?php if (!empty($study->territories_domains)): ?>
            <div class="table-responsive" style="overflow: visible;">
                <table class="table table-bordered" >
                    <thead>
                    <tr>
                        <th scope="col"><?= __('Territory') ?></th>
                        <th scope="col"><?= __('Tax Rehab') ?></th>
                        <th scope="col"><?= __('Tax Construction') ?></th>
                        <th scope="col"><?= __('Anual Desertion Tax') ?></th>
                        <th scope="col"><?= __('Actual Lodges') ?></th>
                        <th scope="col"><?= __('Tax First Lodges') ?></th>
                        <th scope="col"><?= __('Tax Second Lodges') ?></th>
                        <th scope="col"><?= __('Tax Empty Lodges') ?></th>
                        <th scope="col"><?= __('At Market Lodges') ?></th>
                        <th scope="col"><?= __('Rehab Lodges') ?></th>
                        <th scope="col"><?= __('Empty Lodges') ?></th>
                        <!--<th scope="col"><?= __('Value') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>-->
                    </tr>
                    </thead>
                    <?php foreach ($study->territories_domains as $studyTerritoryDomain): ?>
                        <tr>
                            <td><?= h($studyTerritoryDomain->territory->name) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->tax_rehab,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->tax_construction,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->tax_anual_desertion,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->actual_lodges,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->tax_actual_first_lodges,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->tax_actual_second_lodges,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->tax_actual_empty_lodges,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->total_actual_empty_avail_lodges,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->total_actual_empty_rehab_lodges,array('places' => 3)) ?></td>
                            <td><?= $this->Number->format($studyTerritoryDomain->_joinData->total_actual_empty_lodges,array('places' => 3)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <!--<div class="related">
		<h4><?= __('Related Territories Domains') ?></h4>
        <?php if (!empty($study->territories_domains)): ?>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th scope="col"><?= __('Id') ?></th>
					<th scope="col"><?= __('Domain Id') ?></th>
					<th scope="col"><?= __('Territory Id') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
				</tr>
                <?php foreach ($study->territories_domains as $territoriesDomains): ?>
					<tr>
						<td><?= h($territoriesDomains->id) ?></td>
						<td><?= h($territoriesDomains->domain_id) ?></td>
						<td><?= h($territoriesDomains->territory_id) ?></td>
						<td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'TerritoriesDomains', 'action' => 'view', $territoriesDomains->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'TerritoriesDomains', 'action' => 'edit', $territoriesDomains->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'TerritoriesDomains', 'action' => 'delete', $territoriesDomains->id], ['confirm' => __('Are you sure you want to delete # {0}?', $territoriesDomains->id)]) ?>
						</td>
					</tr>
                <?php endforeach; ?>
			</table>
        <?php endif; ?>
	</div>-->
</div>

