<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
	<div class="col-md-12">
		<h3><?= h($domain->name) ?></h3>
		<div class="panel panel-default">

			<div class="row">
				<div class="col-md-3">
					<label for="actual_year">Actual Year</label>
					<small><?= h($domain->actual_year) ?> </small>
					<br>

					<label for="proj_year"> Projection Year</label>
					<small> <?= h($domain->projection_year) ?></small>
					<br>

				</div>
				<div class="col-md-6">
					<label for="description">Description</label>
					<p style="display:inline" id="description"> <?= h($domain->description) ?></p>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="row">
				<div class="panel-heading">
					<h4><?= __('Related Territories') ?></h4>
				</div>
				<div class="panel-body">
                    <?php if (!empty($domain->territories)): ?>
					<div class="table-responsive">
						<table class="table">
							<thead>
							<tr>
								<!--<th scope="col"><?= __('Id') ?></th>
							<!--<th scope="col"><?= __('Code') ?></th>-->

								<!--<th scope="col"><?= __('Municipality') ?></th>
						<th scope="col"><?= __('Parish') ?></th>-->
								<th scope="col"><?= __('Dicofre') ?></th>
								<th scope="col"><?= __('Admin Type') ?></th>
								<th scope="col"><?= __('Name') ?></th>
								<!--<th scope="col" class="actions"><?= __('Actions') ?></th>-->
							</tr>
							</thead>
                            <?php foreach ($domain->territories as $territories): ?>
								<tr>
									<!-- <td><?= h($territories->id) ?></td>
									<td><?= h($territories->code) ?></td>-->
									<!--<td><?= h($territories->municipality) ?></td>
							<td><?= h($territories->parish) ?></td>-->
									<td><?= h($territories->dicofre) ?></td>
									<td><?= h($territories->admin_type) ?></td>
									<td><?= h($territories->name) ?></td>
									<!--<td class="actions">
									<?= $this->Html->link(__('View'), ['controller' => 'Territorials', 'action' => 'view', $territories->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Territorials', 'action' => 'edit', $territories->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Territorials', 'action' => 'delete', $territories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $territories->id)]) ?>
                </td>-->
								</tr>
                            <?php endforeach; ?>
						</table>
                        <?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="row">
				<div class="panel-heading">
					<h4><?= __('Related Studies') ?></h4>
				</div>
				<div class="panel-body">
                    <?php if (!empty($domain->studies)): ?>
						<div class="table-responsive">
							<table class="table ">
								<thead>
								<tr>
									<th scope="col"><?= __('Name') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>

								</tr>
								</thead>
								<tbody>
                                <?php foreach ($domain->studies as $studies): ?>
									<tr>
										<td><?= h($studies->name) ?></td>
										<td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'Studies', 'action' => 'view', $studies->id]) ?>
											<!--<?= $this->Html->link(__('Edit'), ['controller' => 'Studies', 'action' => 'edit', $studies->id]) ?>-->
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Studies', 'action' => 'delete', $studies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studies->id)]) ?>
										</td>
									</tr>
                                <?php endforeach; ?>
								</tbody>
							</table>
						</div>
                    <?php endif; ?>
				</div>
				<div class="panel-footer">
                    <?php echo $this->Html->link('New Study', ['controller' => 'Studies', 'action' => 'add', $domain->id], array('class' => 'button')) ?>
				</div>

			</div>
		</div>

		<div class="panel panel-default">
			<div class="row">
				<div class="panel-heading">
					<h4><?= __('Related Scenarios') ?></h4>
				</div>
				<div class="panel-body">
                    <?php if (!empty($domain->scenarios)): ?>
						<div class="table-responsive">
							<table class="table ">
								<thead>
								<tr>
									<!--<th scope="col"><?= __('Id') ?></th>-->
									<th scope="col"><?= __('Name') ?></th>
									<!--<th scope="col"><?= __('Description') ?></th>
							<th scope="col"><?= __('Domain Id') ?></th>-->
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
								</thead>
								<tbody>
                                <?php foreach ($domain->scenarios as $scenarios): ?>
									<tr>
										<!--<td><?= h($scenarios->id) ?></td>-->
										<td><?= h($scenarios->name) ?></td>
										<!--<td><?= h($scenarios->description) ?></td>
								<td><?= h($scenarios->domain_id) ?></td>-->
										<td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'Scenarios', 'action' => 'view', $scenarios->id]) ?>
											<!--<?= $this->Html->link(__('Edit'), ['controller' => 'Scenarios', 'action' => 'edit', $scenarios->id]) ?>-->
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Scenarios', 'action' => 'delete', $scenarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenarios->id)]) ?>
										</td>
									</tr>
                                <?php endforeach; ?>
								</tbody>
							</table>
						</div>
                    <?php endif; ?>
				</div>
				<div class="panel-footer">
                    <?php echo $this->Html->link('New Scenario', ['controller' => 'Scenarios', 'action' => 'add', $domain->id], array('class' => 'button')) ?>
				</div>
			</div>
		</div>

		<!--<div class="row well related">
					<h4><?= __('Related Features') ?></h4>

                        <?php if (!empty($domain->features)): ?>
					<div class="table-responsive">
							<table class="table">
								<thead>
								<tr>
									<th scope="col"><?= __('Id') ?></th>
									<th scope="col"><?= __('Name') ?></th>
									<th scope="col"><?= __('Description') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
								</thead>
								<tbody>
                                <?php foreach ($domain->features as $features): ?>
									<tr>
										<td><?= h($features->id) ?></td>
										<td><?= h($features->name) ?></td>
										<td><?= h($features->description) ?></td>
										<td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'Features', 'action' => 'view', $features->id]) ?>
                                            <?= $this->Html->link(__('Edit'), ['controller' => 'Features', 'action' => 'edit', $features->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Features', 'action' => 'delete', $features->id], ['confirm' => __('Are you sure you want to delete # {0}?', $features->id)]) ?>
										</td>
									</tr>
                                <?php endforeach; ?>
								</tbody>
							</table>
					</div>
                            <?php
        endif; ?>

				</div>-->
		<!--<div class="row well related">
					<h4><?= __('Related Types') ?></h4>

                        <?php if (!empty($domain->types)): ?>
					<div class="table-responsive">
							<table class="table">
								<thead>
								<tr>
									<th scope="col"><?= __('Id') ?></th>
									<th scope="col"><?= __('Name') ?></th>
									<th scope="col"><?= __('Description') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
								</thead>
                                <?php foreach ($domain->types as $types): ?>
									<tr>
										<!--<td><?= h($types->id) ?></td>
										<td><?= h($types->name) ?></td>
										<!--<td><?= h($types->description) ?></td>
										<td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'Types', 'action' => 'view', $types->id]) ?>
											<!--<?= $this->Html->link(__('Edit'), ['controller' => 'Types', 'action' => 'edit', $types->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Types', 'action' => 'delete', $types->id], ['confirm' => __('Are you sure you want to delete # {0}?', $types->id)]) ?>
										</td>
									</tr>
                                <?php endforeach; ?>
							</table>
					</div>
                        <?php else: ?>
							<h5> There is no rows</h5>
                        <?php endif; ?>

				</div>-->

	</div>
</div>