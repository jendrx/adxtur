<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
	<h3><?= __('Studies') ?></h3>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table">
				<thead>
				<tr>
					<th scope="col"><?= $this->Paginator->sort('id') ?></th>
					<th scope="col"><?= $this->Paginator->sort('domain_id') ?></th>
					<th scope="col"><?= $this->Paginator->sort('name') ?></th>
					<th scope="col"><?= $this->Paginator->sort('actual_year') ?></th>
					<th scope="col"><?= $this->Paginator->sort('projection_years') ?></th>
					<th scope="col"><?= $this->Paginator->sort('created') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
				</tr>
				</thead>
				<tbody>
                <?php foreach ($studies as $study): ?>
					<tr>
						<td><?= $this->Number->format($study->id) ?></td>
						<td><?= $study->has('domain') ? $this->Html->link($study->domain->name, ['controller' => 'Domains', 'action' => 'view', $study->domain->id]) : '' ?></td>
						<td><?= $study->name ?></td>
						<td><?= $study->has('actual_year') ? h($study->actual_year) : 'undefined' ?></td>
						<td><?= $this->Number->format($study->projection_years) ?></td>
						<td><?= $study->has('created') ? $study->created->i18nFormat('dd-MM-yyyy, HH:MM') : 'undefined' ?></td>
						<td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $study->id]) ?>
							<!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $study->id]) ?>-->
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $study->id], ['confirm' => __('Are you sure you want to delete # {0}?', $study->id)]) ?>
						</td>
					</tr>
                <?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="paginator">
			<ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
			</ul>
			<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} study(ies) out of {{count}} total')]) ?></p>
		</div>
	</div>
</div>
