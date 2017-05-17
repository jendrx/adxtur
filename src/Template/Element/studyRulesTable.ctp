<?php
?>

<div class="table-responsive">
    <table class="table">
	    <thead>
	    <th>Territory</th>

	    <?php foreach ($content['rules'] as $rule):?>

		    <th><?= $rule->description?></th>

	    <?php endforeach; ?>

	    </thead>
	    <tbody>
		<?php foreach ($content['studyRules'] as $key => $value): ?>
		    <tr>
			    <td><?= $key ?></td>
                <?php foreach ($value as $val): ?>
	                <td> <?= $this->Form->control('',['type' => 'number', 'step' => '0.1', 'value' => $this->Number->format($val->value, array('places' => 3))]) ?></td>
                <?php endforeach; ?>
		    </tr>
        <?php endforeach; ?>
	    </tbody>


	    </tbody>

    </table>

</div>
